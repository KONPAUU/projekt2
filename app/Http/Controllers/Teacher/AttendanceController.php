<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display attendance management overview.
     */
    public function index()
    {
        $teacher = auth()->user();

        // Pobierz unikalne klasy nauczyciela
        $classIds = \DB::table('class_subject_teacher')
            ->where('teacher_id', $teacher->id)
            ->pluck('class_id')
            ->unique();

        // Policz uczniów w tych klasach
        $totalStudents = User::whereIn('class_id', $classIds)
            ->whereHas('role', fn($q) => $q->where('name', 'student'))
            ->count();

        // Statystyki frekwencji
        $stats = [
            'total_classes' => $classIds->count(),
            'total_students' => $totalStudents,
            'todays_attendance' => $this->getTodaysAttendanceCount($teacher),
            'weekly_attendance' => $this->getWeeklyAttendanceCount($teacher),
        ];

        return view('teacher.attendance.index', compact('stats'));
    }

    /**
     * Show attendance for specific class and subject.
     */
    public function showClass($classId, $subjectId, Request $request)
    {
        $teacher = auth()->user();
        $class = SchoolClass::findOrFail($classId);
        $subject = Subject::findOrFail($subjectId);

        // Sprawdź uprawnienia
        if (!$subject->isTaughtByTeacherInClass($teacher->id, $classId)) {
            return redirect()->route('teacher.attendance.index')
                           ->with('error', 'Nie masz uprawnień do tego przedmiotu w tej klasie.');
        }

        $date = $request->get('date', now()->format('Y-m-d'));

        $students = $class->students()
                         ->with(['attendances' => function($query) use ($subjectId, $date) {
                             $query->where('subject_id', $subjectId)
                                   ->where('date', $date);
                         }])
                         ->orderBy('name')
                         ->get();

        // Statystyki frekwencji dla tej daty
        $attendanceStats = $this->getAttendanceStats($classId, $subjectId, $date);

        return view('teacher.attendance.show-class', compact(
            'class', 'subject', 'students', 'date', 'attendanceStats'
        ));
    }

    /**
     * Store attendance for students.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,excused',
        ]);

        $teacher = auth()->user();
        $subject = Subject::findOrFail($request->subject_id);

        // Sprawdź uprawnienia
        if (!$subject->isTaughtByTeacherInClass($teacher->id, $request->class_id)) {
            return redirect()->back()
                           ->with('error', 'Nie masz uprawnień do tego przedmiotu.');
        }

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'date' => $request->date,
                ],
                [
                    'teacher_id' => $teacher->id,
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                ]
            );
        }

        return redirect()->back()
                        ->with('success', 'Frekwencja została zapisana pomyślnie.');
    }

    /**
     * Update single attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string|max:500',
        ]);

        $teacher = auth()->user();

        // Sprawdź uprawnienia
        if (!$attendance->subject->isTaughtByTeacherInClass($teacher->id, $attendance->student->class_id)) {
            return response()->json(['error' => 'Brak uprawnień'], 403);
        }

        $attendance->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json(['success' => true, 'message' => 'Frekwencja została zaktualizowana.']);
    }

    /**
     * Get today's attendance count for teacher.
     */
    private function getTodaysAttendanceCount($teacher)
    {
        return Attendance::whereDate('created_at', now())
                        ->whereHas('subject', function($query) use ($teacher) {
                            $query->whereIn('id', $teacher->teachingSubjects()->pluck('subjects.id'));
                        })
                        ->count();
    }

    /**
     * Get weekly attendance count for teacher.
     */
    private function getWeeklyAttendanceCount($teacher)
    {
        return Attendance::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->whereHas('subject', function($query) use ($teacher) {
                            $query->whereIn('id', $teacher->teachingSubjects()->pluck('subjects.id'));
                        })
                        ->count();
    }

    /**
     * Get attendance statistics for specific class, subject and date.
     */
    private function getAttendanceStats($classId, $subjectId, $date)
    {
        $attendances = Attendance::where('subject_id', $subjectId)
                                ->where('date', $date)
                                ->whereHas('student', function($query) use ($classId) {
                                    $query->where('class_id', $classId);
                                })
                                ->get();

        return [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count(),
        ];
    }

    /**
     * Show attendance reports for teacher.
     */
    public function reports(Request $request)
    {
        $teacher = auth()->user();

        // Pobierz klasy i przedmioty nauczyciela
        $classes = SchoolClass::whereExists(function($query) use ($teacher) {
            $query->select(\DB::raw(1))
                  ->from('class_subject_teacher')
                  ->whereColumn('class_subject_teacher.class_id', 'school_classes.id')
                  ->where('class_subject_teacher.teacher_id', $teacher->id);
        })->get();

        // Pobierz unikalne przedmioty nauczyciela
        $subjects = Subject::whereIn('id', function($query) use ($teacher) {
            $query->select('subject_id')
                  ->from('class_subject_teacher')
                  ->where('teacher_id', $teacher->id);
        })->get();

        // Pobierz dane do raportu jeśli wybrano filtry
        $reportData = null;
        if ($request->filled('class_id') && $request->filled('subject_id')) {
            $classId = $request->class_id;
            $subjectId = $request->subject_id;
            $dateFrom = $request->get('date_from', now()->subMonth()->toDateString());
            $dateTo = $request->get('date_to', now()->toDateString());

            $students = User::where('class_id', $classId)
                           ->where('role_id', function($query) {
                               $query->select('id')->from('roles')->where('name', 'student');
                           })
                           ->with(['attendances' => function($query) use ($subjectId, $dateFrom, $dateTo) {
                               $query->where('subject_id', $subjectId)
                                    ->whereBetween('date', [$dateFrom, $dateTo]);
                           }])
                           ->get();

            $reportData = $students->map(function($student) {
                $attendances = $student->attendances;
                return [
                    'student' => $student,
                    'total' => $attendances->count(),
                    'present' => $attendances->where('status', 'present')->count(),
                    'absent' => $attendances->where('status', 'absent')->count(),
                    'late' => $attendances->where('status', 'late')->count(),
                    'excused' => $attendances->where('status', 'excused')->count(),
                    'rate' => $attendances->count() > 0
                        ? round(($attendances->whereIn('status', ['present', 'late'])->count() / $attendances->count()) * 100, 1)
                        : 0,
                ];
            });
        }

        return view('teacher.attendance.reports', compact('classes', 'subjects', 'reportData', 'request'));
    }
}