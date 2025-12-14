<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\GradeHistory;
use Illuminate\Http\Request;

class GradeHistoryController extends Controller
{
    /**
     * Show grade history for a specific student.
     */
    public function show(User $student, Request $request)
    {
        $teacher = auth()->user();

        // Sprawdź czy nauczyciel ma dostęp do tego ucznia
        $hasAccess = $teacher->teachingSubjects()
                           ->join('class_subject_teacher', 'subjects.id', '=', 'class_subject_teacher.subject_id')
                           ->where('class_subject_teacher.class_id', $student->class_id)
                           ->where('class_subject_teacher.teacher_id', $teacher->id)
                           ->exists();

        if (!$hasAccess) {
            return redirect()->route('teacher.dashboard')
                           ->with('error', 'Nie masz dostępu do historii tego ucznia.');
        }

        $query = GradeHistory::whereHas('grade', function($q) use ($student, $teacher) {
                               $q->where('student_id', $student->id)
                                 ->where('teacher_id', $teacher->id);
                           })
                           ->with(['grade.subject', 'changedBy']);

        // Filtrowanie po przedmiocie
        if ($request->filled('subject')) {
            $query->whereHas('grade', function($q) use ($request) {
                $q->where('subject_id', $request->subject);
            });
        }

        // Filtrowanie po dacie
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $histories = $query->orderBy('created_at', 'desc')->paginate(15);

        // Przedmioty które nauczyciel prowadzi dla tego ucznia
        $subjects = $teacher->teachingSubjects()
                          ->join('class_subject_teacher', 'subjects.id', '=', 'class_subject_teacher.subject_id')
                          ->where('class_subject_teacher.class_id', $student->class_id)
                          ->where('class_subject_teacher.teacher_id', $teacher->id)
                          ->select('subjects.*')
                          ->get();

        // Statystyki historii
        $stats = [
            'total_changes' => $histories->total(),
            'improvements' => GradeHistory::whereHas('grade', function($q) use ($student, $teacher) {
                                $q->where('student_id', $student->id)
                                  ->where('teacher_id', $teacher->id);
                            })
                            ->whereRaw('new_grade > old_grade')
                            ->count(),
            'downgrades' => GradeHistory::whereHas('grade', function($q) use ($student, $teacher) {
                              $q->where('student_id', $student->id)
                                ->where('teacher_id', $teacher->id);
                          })
                          ->whereRaw('new_grade < old_grade')
                          ->count(),
            'last_change' => GradeHistory::whereHas('grade', function($q) use ($student, $teacher) {
                               $q->where('student_id', $student->id)
                                 ->where('teacher_id', $teacher->id);
                           })
                           ->latest()
                           ->first(),
        ];

        return view('teacher.grades.history', compact('student', 'histories', 'subjects', 'stats'));
    }

    /**
     * Show detailed history for a specific grade.
     */
    public function gradeHistory($gradeId)
    {
        $teacher = auth()->user();

        $grade = \App\Models\Grade::with(['student', 'subject', 'histories.changedBy'])
                                ->where('teacher_id', $teacher->id)
                                ->findOrFail($gradeId);

        $histories = $grade->histories()->orderBy('created_at', 'desc')->get();

        return view('teacher.grades.grade-history', compact('grade', 'histories'));
    }

    /**
     * Show all recent grade changes for teacher.
     */
    public function recent()
    {
        $teacher = auth()->user();

        $recentHistories = GradeHistory::whereHas('grade', function($q) use ($teacher) {
                                         $q->where('teacher_id', $teacher->id);
                                     })
                                     ->with(['grade.student', 'grade.subject', 'changedBy'])
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(20);

        // Statystyki ostatnich zmian
        $stats = [
            'today_changes' => GradeHistory::whereHas('grade', function($q) use ($teacher) {
                                 $q->where('teacher_id', $teacher->id);
                             })
                             ->whereDate('created_at', now())
                             ->count(),
            'week_changes' => GradeHistory::whereHas('grade', function($q) use ($teacher) {
                                $q->where('teacher_id', $teacher->id);
                            })
                            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                            ->count(),
            'total_changes' => GradeHistory::whereHas('grade', function($q) use ($teacher) {
                                 $q->where('teacher_id', $teacher->id);
                             })
                             ->count(),
        ];

        return view('teacher.grades.recent-changes', compact('recentHistories', 'stats'));
    }

    /**
     * Export grade history to PDF.
     */
    public function exportPdf(User $student, Request $request)
    {
        $teacher = auth()->user();

        // Sprawdź uprawnienia
        $hasAccess = $teacher->teachingSubjects()
                           ->join('class_subject_teacher', 'subjects.id', '=', 'class_subject_teacher.subject_id')
                           ->where('class_subject_teacher.class_id', $student->class_id)
                           ->where('class_subject_teacher.teacher_id', $teacher->id)
                           ->exists();

        if (!$hasAccess) {
            return redirect()->back()
                           ->with('error', 'Nie masz uprawnień do eksportu historii tego ucznia.');
        }

        $histories = GradeHistory::whereHas('grade', function($q) use ($student, $teacher) {
                                   $q->where('student_id', $student->id)
                                     ->where('teacher_id', $teacher->id);
                               })
                               ->with(['grade.subject', 'changedBy'])
                               ->orderBy('created_at', 'desc')
                               ->get();

        // Tu można zaimplementować generowanie PDF
        // używając pakietu barryvdh/laravel-dompdf

        return redirect()->back()
                        ->with('info', 'Funkcja eksportu PDF zostanie wkrótce udostępniona.');
    }
}