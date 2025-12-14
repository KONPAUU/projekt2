<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradesViewController extends Controller
{
    /**
     * Display all grades for the student.
     */
    public function index(Request $request)
    {
        $student = auth()->user();

        $query = $student->grades()->with(['subject', 'teacher']);

        // Filtrowanie po przedmiocie
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filtrowanie po typie oceny
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrowanie po dacie
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filtrowanie po ocenach
        if ($request->filled('grade_from')) {
            $query->where('grade', '>=', $request->grade_from);
        }

        if ($request->filled('grade_to')) {
            $query->where('grade', '<=', $request->grade_to);
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statystyki ucznia
        $stats = [
            'total_grades' => $student->grades()->count(),
            'overall_average' => $student->getWeightedAverage(),
            'highest_grade' => $student->grades()->max('grade'),
            'class_rank' => $this->getClassRank($student),
        ];

        // Średnie z przedmiotów
        $subjectAverages = $student->grades()
                                 ->with('subject')
                                 ->get()
                                 ->groupBy('subject_id')
                                 ->map(function($grades) use ($student) {
                                     $subject = $grades->first()->subject;
                                     $average = $student->getSubjectAverage($subject->id);

                                     return (object)[
                                         'name' => $subject->name,
                                         'average' => $average,
                                         'grades_count' => $grades->count(),
                                     ];
                                 });

        $subjects = Subject::whereHas('grades', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })->get();

        return view('student.grades.index', compact('grades', 'subjectAverages', 'subjects', 'stats'));
    }

    /**
     * Get student's rank in class.
     */
    private function getClassRank($student)
    {
        if (!$student->schoolClass) {
            return null;
        }

        $classmates = $student->schoolClass->students()->with('grades')->get();
        $averages = $classmates->map(function($classmate) {
            return [
                'student_id' => $classmate->id,
                'average' => $classmate->getWeightedAverage()
            ];
        })->sortByDesc('average')->values();

        $rank = $averages->search(function($item) use ($student) {
            return $item['student_id'] == $student->id;
        });

        return $rank !== false ? $rank + 1 : null;
    }

    /**
     * Show grades for a specific subject.
     */
    public function bySubject($subjectId)
    {
        $student = auth()->user();
        $subject = Subject::findOrFail($subjectId);

        $grades = $student->grades()
                        ->where('subject_id', $subjectId)
                        ->with('teacher')
                        ->orderBy('created_at', 'desc')
                        ->get();

        $average = $student->getSubjectAverage($subjectId);

        // Statystyki przedmiotu
        $stats = [
            'total_grades' => $grades->count(),
            'average' => $average,
            'best_grade' => $grades->max('grade'),
            'worst_grade' => $grades->min('grade'),
            'types_distribution' => $grades->groupBy('type')->map->count(),
        ];

        return view('student.grades.by-subject', compact('subject', 'grades', 'average', 'stats'));
    }

    /**
     * Calculate and display weighted average.
     */
    public function average()
    {
        $student = auth()->user();

        // Średnia ogólna
        $overallAverage = $student->getWeightedAverage();

        // Średnie z poszczególnych przedmiotów
        $subjectAverages = $student->grades()
                                 ->with('subject')
                                 ->get()
                                 ->groupBy('subject_id')
                                 ->map(function($grades) use ($student) {
                                     $subject = $grades->first()->subject;
                                     $average = $student->getSubjectAverage($subject->id);

                                     // Szczegółowe obliczenia
                                     $totalWeightedSum = 0;
                                     $totalWeight = 0;

                                     $gradeDetails = $grades->map(function($grade) use (&$totalWeightedSum, &$totalWeight) {
                                         $weightedValue = $grade->grade * $grade->weight;
                                         $totalWeightedSum += $weightedValue;
                                         $totalWeight += $grade->weight;

                                         return [
                                             'grade' => $grade,
                                             'weighted_value' => $weightedValue,
                                         ];
                                     });

                                     return [
                                         'subject' => $subject,
                                         'average' => $average,
                                         'total_weighted_sum' => $totalWeightedSum,
                                         'total_weight' => $totalWeight,
                                         'grade_details' => $gradeDetails,
                                         'grades_count' => $grades->count(),
                                     ];
                                 });

        return view('student.grades.average', compact('overallAverage', 'subjectAverages'));
    }

    /**
     * Show grade modification history.
     */
    public function history(Request $request)
    {
        $student = auth()->user();

        $query = $student->grades()
                       ->with(['histories.changedBy', 'subject', 'teacher'])
                       ->whereHas('histories');

        // Filtrowanie po przedmiocie
        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }

        $gradesWithHistory = $query->orderBy('updated_at', 'desc')->paginate(15);

        // Wszystkie zmiany dla ucznia
        $allHistories = \App\Models\GradeHistory::whereHas('grade', function($q) use ($student) {
                                                  $q->where('student_id', $student->id);
                                              })
                                              ->with(['grade.subject', 'changedBy'])
                                              ->orderBy('created_at', 'desc')
                                              ->paginate(15);

        $subjects = Subject::all();

        return view('student.grades.history', compact('gradesWithHistory', 'allHistories', 'subjects'));
    }

    /**
     * Export grades to PDF.
     */
    public function exportPdf()
    {
        $student = auth()->user();

        $grades = $student->grades()
                        ->with(['subject', 'teacher'])
                        ->orderBy('subject_id')
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->groupBy('subject_id');

        $overallAverage = $student->getWeightedAverage();

        // Tu można zaimplementować generowanie PDF
        // używając pakietu barryvdh/laravel-dompdf

        return redirect()->route('student.grades.index')
                        ->with('info', 'Funkcja eksportu PDF będzie dostępna po instalacji odpowiedniego pakietu.');
    }

    /**
     * Get grade statistics for charts.
     */
    public function statistics()
    {
        $student = auth()->user();

        // Statystyki ocen w czasie
        $monthlyStats = $student->grades()
                              ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, AVG(grade) as average, COUNT(*) as count')
                              ->groupBy('year', 'month')
                              ->orderBy('year')
                              ->orderBy('month')
                              ->get();

        // Rozkład ocen
        $gradeDistribution = $student->grades()
                                   ->selectRaw('grade, COUNT(*) as count')
                                   ->groupBy('grade')
                                   ->orderBy('grade')
                                   ->get();

        // Statystyki według typu oceny
        $typeStats = $student->grades()
                           ->selectRaw('type, AVG(grade) as average, COUNT(*) as count')
                           ->groupBy('type')
                           ->get();

        return response()->json([
            'monthly_stats' => $monthlyStats,
            'grade_distribution' => $gradeDistribution,
            'type_stats' => $typeStats,
        ]);
    }
}