<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function index()
    {
        $student = auth()->user();

        // Statystyki ucznia
        $totalGrades = $student->grades()->count();
        $overallAverage = $student->getWeightedAverage();

        // Oblicz pozycję w klasie
        $classRank = null;
        if ($student->schoolClass) {
            $classmates = $student->schoolClass->students()->with('grades')->get();
            $classAverages = $classmates->map(function($classmate) {
                return [
                    'student_id' => $classmate->id,
                    'average' => $classmate->getWeightedAverage()
                ];
            })->sortByDesc('average')->values();

            $rank = $classAverages->search(function($item) use ($student) {
                return $item['student_id'] == $student->id;
            });
            $classRank = $rank !== false ? $rank + 1 : null;
        }

        // Frekwencja ucznia
        $totalLessons = $student->attendances()->count();
        $presentLessons = $student->attendances()->whereIn('status', ['present', 'late'])->count();
        $attendanceRate = $totalLessons > 0 ? round(($presentLessons / $totalLessons) * 100, 1) : 0;

        $stats = [
            'total_grades' => $totalGrades,
            'overall_average' => $overallAverage,
            'attendance_rate' => $attendanceRate,
            'class_rank' => $classRank,
            'class_students' => $student->schoolClass ? $student->schoolClass->students()->count() : 0,
            'class_average' => $student->schoolClass ? $this->getClassAverage($student->schoolClass) : null,
        ];

        // Ostatnie oceny
        $recentGrades = $student->grades()
                              ->with(['subject', 'teacher'])
                              ->orderBy('created_at', 'desc')
                              ->limit(10)
                              ->get();

        // Średnie z poszczególnych przedmiotów
        $subjectAverages = $student->grades()
                                 ->with('subject')
                                 ->get()
                                 ->groupBy('subject_id')
                                 ->map(function($grades) {
                                     $subject = $grades->first()->subject;
                                     $totalWeightedSum = 0;
                                     $totalWeight = 0;

                                     foreach ($grades as $grade) {
                                         $totalWeightedSum += $grade->grade * $grade->weight;
                                         $totalWeight += $grade->weight;
                                     }

                                     $average = $totalWeight > 0 ? round($totalWeightedSum / $totalWeight, 2) : null;

                                     return (object) [
                                         'name' => $subject->name,
                                         'average' => $average,
                                         'grades_count' => $grades->count(),
                                     ];
                                 });

        // Dane do wykresu postępów (ostatnie 6 miesięcy)
        $progressData = $this->getProgressData($student);

        return view('student.dashboard', compact('stats', 'recentGrades', 'subjectAverages', 'progressData'));
    }

    /**
     * Oblicz średnią klasy.
     */
    private function getClassAverage($class)
    {
        $students = $class->students()->with('grades')->get();
        $totalAverage = 0;
        $studentsWithGrades = 0;

        foreach ($students as $student) {
            $average = $student->getWeightedAverage();
            if ($average > 0) {
                $totalAverage += $average;
                $studentsWithGrades++;
            }
        }

        return $studentsWithGrades > 0 ? round($totalAverage / $studentsWithGrades, 2) : null;
    }

    /**
     * Pobierz dane do wykresu postępów.
     */
    private function getProgressData($student)
    {
        $months = [];
        $averages = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $monthGrades = $student->grades()
                                 ->whereBetween('created_at', [$monthStart, $monthEnd])
                                 ->get();

            if ($monthGrades->count() > 0) {
                $totalWeightedSum = 0;
                $totalWeight = 0;

                foreach ($monthGrades as $grade) {
                    $totalWeightedSum += $grade->grade * $grade->weight;
                    $totalWeight += $grade->weight;
                }

                $average = $totalWeight > 0 ? round($totalWeightedSum / $totalWeight, 2) : 0;
            } else {
                $average = null;
            }

            $months[] = $date->locale('pl')->format('M Y');
            $averages[] = $average;
        }

        return [
            'months' => $months,
            'averages' => $averages
        ];
    }
}