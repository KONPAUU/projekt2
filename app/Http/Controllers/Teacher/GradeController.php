<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of grades for teacher.
     */
    public function index(Request $request)
    {
        $teacher = auth()->user();

        // Pobierz klasy i przedmioty nauczyciela
        $classes = SchoolClass::whereExists(function($query) use ($teacher) {
            $query->select(\DB::raw(1))
                  ->from('class_subject_teacher')
                  ->whereColumn('class_subject_teacher.class_id', 'school_classes.id')
                  ->where('class_subject_teacher.teacher_id', $teacher->id);
        })->withCount('students')->get();

        // Pobierz unikalne przedmioty nauczyciela
        $subjects = Subject::whereIn('id', function($query) use ($teacher) {
            $query->select('subject_id')
                  ->from('class_subject_teacher')
                  ->where('teacher_id', $teacher->id);
        })->get();

        // Pobierz oceny z filtrami
        $query = Grade::where('teacher_id', $teacher->id)
                     ->with(['student.schoolClass', 'subject']);

        if ($request->filled('class_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('teacher.grades.index', compact('grades', 'classes', 'subjects'));
    }

    /**
     * Show students in a specific class for a specific subject.
     */
    public function showClass($classId, $subjectId)
    {
        $teacher = auth()->user();
        $class = SchoolClass::findOrFail($classId);
        $subject = Subject::findOrFail($subjectId);

        // Sprawdź czy nauczyciel uczy tego przedmiotu w tej klasie
        if (!$subject->isTaughtByTeacherInClass($teacher->id, $classId)) {
            return redirect()->route('teacher.grades.index')
                           ->with('error', 'Nie masz uprawnień do tego przedmiotu w tej klasie.');
        }

        $students = $class->students()
                         ->with(['grades' => function($query) use ($subjectId) {
                             $query->where('subject_id', $subjectId)
                                   ->with('teacher')
                                   ->orderBy('created_at', 'desc');
                         }])
                         ->get();

        // Oblicz średnią klasy
        $classAverage = $class->getClassAverage($subjectId);

        return view('teacher.grades.show-class', compact('class', 'subject', 'students', 'classAverage'));
    }

    /**
     * Show the form for creating a new grade.
     */
    public function create()
    {
        $teacher = auth()->user();

        // Pobierz klasy nauczyciela
        $classes = SchoolClass::whereExists(function($query) use ($teacher) {
            $query->select(\DB::raw(1))
                  ->from('class_subject_teacher')
                  ->whereColumn('class_subject_teacher.class_id', 'school_classes.id')
                  ->where('class_subject_teacher.teacher_id', $teacher->id);
        })->withCount('students')->get();

        // Pobierz unikalne przedmioty nauczyciela
        $subjects = Subject::whereIn('id', function($query) use ($teacher) {
            $query->select('subject_id')
                  ->from('class_subject_teacher')
                  ->where('teacher_id', $teacher->id);
        })->get();

        return view('teacher.grades.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created grade.
     */
    public function store(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:1|max:6',
            'weight' => 'required|integer|min:1|max:10',
            'type' => 'required|in:sprawdzian,kartkówka,odpowiedź,projekt,praca_domowa,aktywność',
            'description' => 'nullable|string|max:500',
        ]);

        $teacher = auth()->user();

        foreach ($request->students as $studentId) {
            Grade::create([
                'student_id' => $studentId,
                'teacher_id' => $teacher->id,
                'subject_id' => $request->subject_id,
                'grade' => $request->grade,
                'weight' => $request->weight,
                'type' => $request->type,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('teacher.grades.index')
                ->with('success', 'Oceny zostały dodane pomyślnie dla ' . count($request->students) . ' uczniów.');
    }

    /**
     * Show the form for editing a grade.
     */
    public function edit(Grade $grade)
    {
        $teacher = auth()->user();

        // Sprawdź czy nauczyciel może edytować tę ocenę
        if ($grade->teacher_id !== $teacher->id) {
            return redirect()->route('teacher.grades.index')
                           ->with('error', 'Nie możesz edytować tej oceny.');
        }

        return view('teacher.grades.edit', compact('grade'));
    }

    /**
     * Update the specified grade.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $teacher = auth()->user();

        // Sprawdź uprawnienia
        if ($grade->teacher_id !== $teacher->id) {
            return redirect()->route('teacher.grades.index')
                           ->with('error', 'Nie możesz edytować tej oceny.');
        }

        $validated = $request->validated();
        $grade->update($validated);

        return redirect()->route('teacher.grades.index')
                ->with('success', 'Ocena została zaktualizowana. Zmiana została zapisana w historii.');
    }

    /**
     * Remove the specified grade.
     */
    public function destroy(Grade $grade)
    {
        $teacher = auth()->user();

        // Sprawdź uprawnienia
        if ($grade->teacher_id !== $teacher->id) {
            return redirect()->route('teacher.grades.index')
                           ->with('error', 'Nie możesz usunąć tej oceny.');
        }

        $grade->delete();

        return redirect()->route('teacher.grades.index')
                ->with('success', 'Ocena została usunięta.');
    }

    /**
     * Show grade history for a student.
     */
    public function history($studentId, $subjectId = null)
    {
        $student = User::findOrFail($studentId);
        $teacher = auth()->user();

        $query = $student->grades()
                        ->with(['subject', 'teacher', 'histories.changedBy'])
                        ->where('teacher_id', $teacher->id);

        if ($subjectId) {
            $query->where('subject_id', $subjectId);
            $subject = Subject::findOrFail($subjectId);
        } else {
            $subject = null;
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('teacher.grades.history', compact('student', 'grades', 'subject'));
    }

    /**
     * Dashboard for teacher.
     */
    public function dashboard()
    {
        $teacher = auth()->user();

        // Statystyki nauczyciela
        $stats = [
            'total_classes' => $teacher->teachingSubjects()
                                     ->join('class_subject_teacher', 'subjects.id', '=', 'class_subject_teacher.subject_id')
                                     ->where('class_subject_teacher.teacher_id', $teacher->id)
                                     ->distinct('class_subject_teacher.class_id')
                                     ->count(),
            'total_subjects' => $teacher->teachingSubjects()->count(),
            'total_students' => User::whereHas('schoolClass.subjects', function($query) use ($teacher) {
                                     $query->wherePivot('teacher_id', $teacher->id);
                                 })->count(),
            'total_grades' => $teacher->gradesAsTeacher()->count(),
            'recent_grades' => $teacher->gradesAsTeacher()
                                      ->with(['student', 'subject'])
                                      ->orderBy('created_at', 'desc')
                                      ->limit(5)
                                      ->get(),
        ];

        return view('teacher.dashboard', compact('stats'));
    }

    /**
     * Quick grade entry form.
     */
    public function quickGrade()
    {
        $teacher = auth()->user();

        // Pobierz unikalne przedmioty nauczyciela
        $subjects = Subject::whereIn('id', function($query) use ($teacher) {
            $query->select('subject_id')
                  ->from('class_subject_teacher')
                  ->where('teacher_id', $teacher->id);
        })->get();

        $classes = SchoolClass::whereExists(function($query) use ($teacher) {
            $query->select(\DB::raw(1))
                  ->from('class_subject_teacher')
                  ->whereColumn('class_subject_teacher.class_id', 'school_classes.id')
                  ->where('class_subject_teacher.teacher_id', $teacher->id);
        })->get();

        return view('teacher.grades.quick-grade', compact('subjects', 'classes'));
    }

    /**
     * Store quick grade.
     */
    public function storeQuick(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:1|max:6',
            'weight' => 'required|integer|min:1|max:10',
            'type' => 'required|in:sprawdzian,kartkówka,odpowiedź,projekt,praca_domowa,aktywność',
            'description' => 'nullable|string|max:500',
        ]);

        Grade::create([
            'student_id' => $request->student_id,
            'teacher_id' => auth()->id(),
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
            'weight' => $request->weight,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Ocena została dodana.']);
        }

        return redirect()->route('teacher.grades.quick')
                ->with('success', 'Ocena została dodana pomyślnie.');
    }

    /**
     * List all subjects taught by the teacher.
     */
    public function subjects()
    {
        $teacher = auth()->user();

        $subjects = $teacher->teachingSubjects()
            ->withCount('grades')
            ->with(['classSubjectTeachers' => function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id)->with('class');
            }])
            ->get();

        // Dla każdego przedmiotu dodaj statystyki
        $subjectsWithStats = $subjects->map(function($subject) use ($teacher) {
            $grades = Grade::where('teacher_id', $teacher->id)
                          ->where('subject_id', $subject->id)
                          ->get();

            $subject->students_count = $grades->pluck('student_id')->unique()->count();
            $subject->average_grade = $grades->avg('grade');
            $subject->classes = $subject->classSubjectTeachers->pluck('class')->unique('id');

            return $subject;
        });

        return view('teacher.subjects.index', compact('subjectsWithStats'));
    }
}