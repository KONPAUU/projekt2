<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class StudentListController extends Controller
{
    /**
     * Display students for a specific class.
     */
    public function index(SchoolClass $class)
    {
        $teacher = auth()->user();

        // Sprawdź czy nauczyciel ma dostęp do tej klasy
        $hasAccess = \DB::table('class_subject_teacher')
                       ->where('class_id', $class->id)
                       ->where('teacher_id', $teacher->id)
                       ->exists();

        if (!$hasAccess) {
            return redirect()->route('teacher.dashboard')
                           ->with('error', 'Nie masz dostępu do tej klasy.');
        }

        $students = $class->students()
                         ->with(['grades' => function($query) use ($teacher) {
                             $query->where('teacher_id', $teacher->id)
                                   ->with('subject')
                                   ->orderBy('created_at', 'desc');
                         }])
                         ->orderBy('name')
                         ->get();

        // Pobierz przedmioty które nauczyciel prowadzi w tej klasie
        $subjects = \DB::table('subjects')
                      ->join('class_subject_teacher', 'subjects.id', '=', 'class_subject_teacher.subject_id')
                      ->where('class_subject_teacher.class_id', $class->id)
                      ->where('class_subject_teacher.teacher_id', $teacher->id)
                      ->select('subjects.*')
                      ->get();

        // Statystyki klasy
        $stats = [
            'total_students' => $students->count(),
            'subjects_count' => $subjects->count(),
            'total_grades' => $students->sum(function($student) {
                return $student->grades->count();
            }),
            'class_average' => $this->calculateClassAverage($students),
        ];

        return view('teacher.students.list', compact('class', 'students', 'subjects', 'stats'));
    }

    /**
     * Show detailed view of a specific student.
     */
    public function show(SchoolClass $class, User $student)
    {
        $teacher = auth()->user();

        // Sprawdź czy student należy do klasy
        if ($student->class_id !== $class->id) {
            return redirect()->route('teacher.students.list', $class)
                           ->with('error', 'Student nie należy do tej klasy.');
        }

        // Sprawdź dostęp nauczyciela
        $hasAccess = \DB::table('class_subject_teacher')
                       ->where('class_id', $class->id)
                       ->where('teacher_id', $teacher->id)
                       ->exists();

        if (!$hasAccess) {
            return redirect()->route('teacher.dashboard')
                           ->with('error', 'Nie masz dostępu do tego studenta.');
        }

        // Pobierz oceny z przedmiotów nauczyciela
        $grades = $student->grades()
                        ->where('teacher_id', $teacher->id)
                        ->with(['subject', 'histories.changedBy'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Pobierz frekwencję
        $subjectIds = \DB::table('class_subject_teacher')
                        ->where('class_id', $class->id)
                        ->where('teacher_id', $teacher->id)
                        ->pluck('subject_id');

        $attendance = $student->attendances()
                            ->whereIn('subject_id', $subjectIds)
                            ->with('subject')
                            ->orderBy('date', 'desc')
                            ->limit(20)
                            ->get();

        // Statystyki studenta
        $stats = [
            'total_grades' => $grades->count(),
            'average_grade' => $grades->avg('grade'),
            'best_grade' => $grades->max('grade'),
            'worst_grade' => $grades->min('grade'),
            'attendance_rate' => $this->calculateAttendanceRate($student, $teacher, $class),
        ];

        return view('teacher.students.show', compact('class', 'student', 'grades', 'attendance', 'stats'));
    }

    /**
     * Calculate class average for teacher's subjects.
     */
    private function calculateClassAverage($students)
    {
        $totalGrades = 0;
        $totalWeight = 0;

        foreach ($students as $student) {
            foreach ($student->grades as $grade) {
                $totalGrades += $grade->grade * $grade->weight;
                $totalWeight += $grade->weight;
            }
        }

        return $totalWeight > 0 ? round($totalGrades / $totalWeight, 2) : 0;
    }

    /**
     * Calculate attendance rate for student in teacher's subjects.
     */
    private function calculateAttendanceRate($student, $teacher, $class)
    {
        $subjectIds = \DB::table('class_subject_teacher')
                        ->where('class_id', $class->id)
                        ->where('teacher_id', $teacher->id)
                        ->pluck('subject_id');

        $totalLessons = $student->attendances()
                              ->whereIn('subject_id', $subjectIds)
                              ->count();

        $presentLessons = $student->attendances()
                                ->whereIn('subject_id', $subjectIds)
                                ->whereIn('status', ['present', 'late'])
                                ->count();

        return $totalLessons > 0 ? round(($presentLessons / $totalLessons) * 100, 1) : 0;
    }
}