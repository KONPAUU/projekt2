<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceViewController extends Controller
{
    /**
     * Display student's attendance.
     */
    public function index(Request $request)
    {
        $student = auth()->user();

        $query = $student->attendances()->with(['subject', 'teacher']);

        // Filtrowanie po przedmiocie
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filtrowanie po statusie
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrowanie po dacie
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(20);

        // Oblicz statystyki
        $totalLessons = $student->attendances()->count();
        $presentCount = $student->attendances()->where('status', 'present')->count();
        $lateCount = $student->attendances()->where('status', 'late')->count();
        $absentCount = $student->attendances()->where('status', 'absent')->count();
        $excusedCount = $student->attendances()->where('status', 'excused')->count();

        $stats = [
            'total_lessons' => $totalLessons,
            'present_count' => $presentCount,
            'late_count' => $lateCount,
            'absent_count' => $absentCount,
            'excused_count' => $excusedCount,
            'attendance_rate' => $totalLessons > 0 ? round(($presentCount + $lateCount) / $totalLessons * 100, 1) : 0,
        ];

        // Statystyki według przedmiotów
        $subjectStats = $student->attendances()
                               ->with('subject')
                               ->get()
                               ->groupBy('subject_id')
                               ->map(function($attendances) {
                                   $subject = $attendances->first()->subject;
                                   $total = $attendances->count();
                                   $present = $attendances->whereIn('status', ['present', 'late'])->count();

                                   return [
                                       'subject' => $subject->name,
                                       'total' => $total,
                                       'rate' => $total > 0 ? round($present / $total * 100, 1) : 0,
                                   ];
                               })
                               ->values();

        // Dane do wykresów
        $chartData = $this->getChartData($student);
        $monthlyData = $this->getMonthlyData($student);

        $subjects = Subject::whereHas('attendances', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })->get();

        return view('student.attendance.index', compact(
            'attendances',
            'stats',
            'subjectStats',
            'chartData',
            'monthlyData',
            'subjects'
        ));
    }

    /**
     * Get chart data for attendance visualization.
     */
    private function getChartData($student)
    {
        $attendances = $student->attendances()
                             ->selectRaw('DATE(date) as date, status, COUNT(*) as count')
                             ->where('date', '>=', now()->subDays(30))
                             ->groupBy('date', 'status')
                             ->orderBy('date')
                             ->get();

        $dates = [];
        $rates = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayAttendances = $attendances->where('date', $date);

            $total = $dayAttendances->sum('count');
            $present = $dayAttendances->whereIn('status', ['present', 'late'])->sum('count');

            $dates[] = now()->subDays($i)->format('d.m');
            $rates[] = $total > 0 ? round($present / $total * 100, 1) : null;
        }

        return [
            'dates' => $dates,
            'rates' => $rates,
        ];
    }

    /**
     * Get monthly attendance data.
     */
    private function getMonthlyData($student)
    {
        $months = [];
        $rates = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $monthAttendances = $student->attendances()
                                      ->whereBetween('date', [$monthStart, $monthEnd])
                                      ->get();

            $total = $monthAttendances->count();
            $present = $monthAttendances->whereIn('status', ['present', 'late'])->count();

            $months[] = $date->locale('pl')->format('M Y');
            $rates[] = $total > 0 ? round($present / $total * 100, 1) : 0;
        }

        return [
            'months' => $months,
            'rates' => $rates,
        ];
    }

    /**
     * Show attendance for a specific subject.
     */
    public function bySubject($subjectId)
    {
        $student = auth()->user();
        $subject = Subject::findOrFail($subjectId);

        $attendances = $student->attendances()
                             ->where('subject_id', $subjectId)
                             ->orderBy('date', 'desc')
                             ->get();

        // Statystyki dla przedmiotu
        $stats = [
            'total_lessons' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'excused' => $attendances->where('status', 'excused')->count(),
        ];

        $stats['presence_rate'] = $stats['total_lessons'] > 0
            ? round(($stats['present'] + $stats['late']) / $stats['total_lessons'] * 100, 1)
            : 0;

        // Kalendarz frekwencji (ostatnie 30 dni)
        $calendar = $attendances->where('date', '>=', now()->subDays(30))
                               ->keyBy(function($attendance) {
                                   return $attendance->date->format('Y-m-d');
                               });

        return view('student.attendance.by-subject', compact('subject', 'attendances', 'stats', 'calendar'));
    }

    /**
     * Show monthly attendance calendar.
     */
    public function calendar(Request $request)
    {
        $student = auth()->user();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = $student->attendances()
                             ->with('subject')
                             ->whereMonth('date', $month)
                             ->whereYear('date', $year)
                             ->get()
                             ->groupBy(function($attendance) {
                                 return $attendance->date->format('Y-m-d');
                             });

        // Dni w miesiącu
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDayOfWeek = date('w', mktime(0, 0, 0, $month, 1, $year));

        return view('student.attendance.calendar', compact(
            'attendances',
            'month',
            'year',
            'daysInMonth',
            'firstDayOfWeek'
        ));
    }

    /**
     * Get attendance statistics for charts.
     */
    public function statistics()
    {
        $student = auth()->user();

        // Statystyki miesięczne
        $monthlyStats = $student->attendances()
                              ->selectRaw('YEAR(date) as year, MONTH(date) as month, status, COUNT(*) as count')
                              ->groupBy('year', 'month', 'status')
                              ->orderBy('year')
                              ->orderBy('month')
                              ->get()
                              ->groupBy(function($item) {
                                  return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                              });

        // Rozkład statusów
        $statusDistribution = $student->attendances()
                                    ->selectRaw('status, COUNT(*) as count')
                                    ->groupBy('status')
                                    ->get();

        return response()->json([
            'monthly_stats' => $monthlyStats,
            'status_distribution' => $statusDistribution,
        ]);
    }
}