<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Role;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role_id', Role::student()->id)->count(),
            'total_teachers' => User::where('role_id', Role::teacher()->id)->count(),
            'total_classes' => SchoolClass::count(),
            'total_subjects' => Subject::count(),
            'total_grades' => Grade::count(),
            'average_grade' => Grade::avg('grade'),
        ];

        // Ostatnie oceny
        $recentGrades = Grade::with(['student', 'teacher', 'subject'])
                           ->orderBy('created_at', 'desc')
                           ->limit(10)
                           ->get();

        // Statystyki ocen
        $gradeStats = Grade::selectRaw('grade, COUNT(*) as count')
                          ->groupBy('grade')
                          ->orderBy('grade')
                          ->get();

        return view('admin.dashboard', compact('stats', 'recentGrades', 'gradeStats'));
    }

    /**
     * Show system settings.
     */
    public function settings()
    {
        return view('admin.settings.index');
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255',
            'admin_email' => 'required|email',
        ]);

        // Tu można zaimplementować zapisywanie ustawień do bazy danych
        // lub do pliku konfiguracyjnego

        return redirect()->route('admin.settings')
                        ->with('success', 'Ustawienia zostały zaktualizowane.');
    }

    /**
     * Generate system reports.
     */
    public function reports()
    {
        $classReports = SchoolClass::with(['students', 'subjects'])
                                  ->withCount('students')
                                  ->get()
                                  ->map(function($class) {
                                      return [
                                          'class' => $class,
                                          'students_count' => $class->students_count,
                                          'average_grade' => $class->students->avg(function($student) {
                                              return $student->getWeightedAverage();
                                          }),
                                      ];
                                  });

        $subjectReports = Subject::withCount(['grades', 'classes'])
                                ->with('grades')
                                ->get()
                                ->map(function($subject) {
                                    return [
                                        'subject' => $subject,
                                        'grades_count' => $subject->grades_count,
                                        'average_grade' => $subject->grades->avg('grade'),
                                        'classes_count' => $subject->classes_count,
                                    ];
                                });

        return view('admin.reports.index', compact('classReports', 'subjectReports'));
    }

    /**
     * Export data to PDF.
     */
    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'users');

        switch ($type) {
            case 'users':
                $data = User::with(['role', 'schoolClass'])->get();
                break;
            case 'grades':
                $data = Grade::with(['student', 'teacher', 'subject'])->get();
                break;
            case 'classes':
                $data = SchoolClass::with(['students', 'tutor'])->get();
                break;
            default:
                $data = collect();
        }

        // Tu można zaimplementować generowanie PDF używając pakietu dompdf
        // return $pdf->download($type . '_report.pdf');

        return redirect()->back()
                        ->with('info', 'Funkcja eksportu PDF będzie dostępna po instalacji pakietu dompdf.');
    }

    /**
     * Show system statistics.
     */
    public function statistics()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'admins' => User::where('role_id', Role::admin()->id)->count(),
                'teachers' => User::where('role_id', Role::teacher()->id)->count(),
                'students' => User::where('role_id', Role::student()->id)->count(),
            ],
            'grades' => [
                'total' => Grade::count(),
                'average' => Grade::avg('grade'),
                'by_grade' => Grade::selectRaw('grade, COUNT(*) as count')
                                  ->groupBy('grade')
                                  ->orderBy('grade')
                                  ->get(),
                'monthly' => Grade::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                 ->whereYear('created_at', now()->year)
                                 ->groupBy('month')
                                 ->orderBy('month')
                                 ->get(),
            ],
            'classes' => [
                'total' => SchoolClass::count(),
                'with_students' => SchoolClass::has('students')->count(),
                'average_students' => (function () {
                    $classesForStats = SchoolClass::withCount('students')->get();
                    return $classesForStats->count() > 0
                        ? $classesForStats->sum('students_count') / $classesForStats->count()
                        : 0;
                })(),
            ],
            'subjects' => [
                'total' => Subject::count(),
                'with_grades' => Subject::has('grades')->count(),
                'most_graded' => Subject::withCount('grades')
                                       ->orderBy('grades_count', 'desc')
                                       ->first(),
            ],
        ];

        return view('admin.statistics.index', compact('stats'));
    }

    /**
     * Show backup management.
     */
    public function backup()
    {
        $backups = [
            // Symulacja listy kopii zapasowych
            [
                'name' => 'backup_' . now()->format('Y_m_d_H_i_s') . '.sql',
                'size' => '2.5 MB',
                'created_at' => now(),
                'type' => 'auto'
            ],
            [
                'name' => 'backup_' . now()->subDay()->format('Y_m_d_H_i_s') . '.sql',
                'size' => '2.3 MB',
                'created_at' => now()->subDay(),
                'type' => 'manual'
            ],
        ];

        return view('admin.backup.index', compact('backups'));
    }
}