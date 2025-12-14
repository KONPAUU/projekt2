<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the teacher dashboard.
     */
    public function index()
    {
        $teacher = auth()->user();

        // Pobierz klasy i przedmioty nauczyciela z liczbą uczniów
        $classSubjects = $teacher->teachingSubjects()
                               ->with(['classes' => function($query) use ($teacher) {
                                   $query->wherePivot('teacher_id', $teacher->id)
                                         ->withCount('students');
                               }])
                               ->get()
                               ->flatMap(function($subject) use ($teacher) {
                                   return $subject->classes->map(function($class) use ($subject, $teacher) {
                                       // Oblicz średnią ocen dla tego przedmiotu w tej klasie
                                       $averageGrade = Grade::where('subject_id', $subject->id)
                                                          ->where('teacher_id', $teacher->id)
                                                          ->whereHas('student', function($q) use ($class) {
                                                              $q->where('class_id', $class->id);
                                                          })
                                                          ->selectRaw('AVG(grade * weight) / AVG(weight) as avg_grade')
                                                          ->first()
                                                          ->avg_grade;

                                       return (object) [
                                           'class' => $class,
                                           'subject' => $subject,
                                           'students_count' => $class->students_count,
                                           'average_grade' => $averageGrade ? round($averageGrade, 2) : null,
                                       ];
                                   });
                               });

        // Statystyki główne
        $stats = [
            'total_classes' => $classSubjects->unique(function($item) {
                return $item->class->id;
            })->count(),
            'total_students' => $classSubjects->sum('students_count'),
            'total_subjects' => $classSubjects->unique(function($item) {
                return $item->subject->id;
            })->count(),
            'grades_today' => Grade::where('teacher_id', $teacher->id)
                                 ->whereDate('created_at', today())
                                 ->count(),
        ];

        // Ostatnie oceny wystawione przez nauczyciela
        $recentGrades = Grade::where('teacher_id', $teacher->id)
                           ->with(['student.schoolClass', 'subject'])
                           ->orderBy('created_at', 'desc')
                           ->limit(10)
                           ->get();

        // Statystyki frekwencji (ostatnie 7 dni)
        $attendanceStats = [
            'present' => Attendance::whereHas('subject', function($query) use ($teacher) {
                           $query->whereIn('id', $teacher->teachingSubjects()->pluck('subjects.id'));
                       })
                       ->where('status', 'present')
                       ->whereBetween('date', [now()->subDays(7), now()])
                       ->count(),
            'late' => Attendance::whereHas('subject', function($query) use ($teacher) {
                        $query->whereIn('id', $teacher->teachingSubjects()->pluck('subjects.id'));
                    })
                    ->where('status', 'late')
                    ->whereBetween('date', [now()->subDays(7), now()])
                    ->count(),
            'absent' => Attendance::whereHas('subject', function($query) use ($teacher) {
                          $query->whereIn('id', $teacher->teachingSubjects()->pluck('subjects.id'));
                      })
                      ->where('status', 'absent')
                      ->whereBetween('date', [now()->subDays(7), now()])
                      ->count(),
            'excused' => Attendance::whereHas('subject', function($query) use ($teacher) {
                           $query->whereIn('id', $teacher->teachingSubjects()->pluck('subjects.id'));
                       })
                       ->where('status', 'excused')
                       ->whereBetween('date', [now()->subDays(7), now()])
                       ->count(),
        ];

        // Pobierz klasy i przedmioty dla formularza
        $classes = $teacher->teachingSubjects()
                          ->with('classes')
                          ->get()
                          ->pluck('classes')
                          ->flatten()
                          ->unique('id')
                          ->values();

        $subjects = $teacher->teachingSubjects()->get();

        return view('teacher.dashboard', compact('stats', 'classSubjects', 'recentGrades', 'attendanceStats', 'classes', 'subjects'));
    }
}