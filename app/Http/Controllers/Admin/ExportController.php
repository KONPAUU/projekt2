<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExportController extends Controller
{
    /**
     * Wyświetl formularz wyboru danych do eksportu
     */
    public function pdf()
    {
        return view('admin.export.form');
    }

    /**
     * Generuj PDF na podstawie wybranych opcji
     */
    public function generatePdf(Request $request)
    {
        $request->validate([
            'sections' => 'required|array|min:1',
            'sections.*' => 'in:summary,classes,top_students,top_teachers',
        ]);

        $selectedSections = $request->input('sections', []);

        // Przygotuj dane tylko dla wybranych sekcji
        $data = [];

        if (in_array('summary', $selectedSections)) {
            $data['summary'] = [
                'users' => User::count(),
                'students' => User::whereHas('role', fn ($q) => $q->where('name', 'student'))->count(),
                'teachers' => User::whereHas('role', fn ($q) => $q->where('name', 'teacher'))->count(),
                'classes' => SchoolClass::count(),
                'subjects' => Subject::count(),
                'grades' => Grade::count(),
                'average_grade' => round(Grade::avg('grade') ?? 0, 2),
                'generated_at' => Carbon::now(),
            ];
        }

        if (in_array('classes', $selectedSections)) {
            $data['classes'] = SchoolClass::withCount(['students as students_count', 'subjects as subjects_count'])
                ->orderBy('name')
                ->get();
        }

        if (in_array('top_students', $selectedSections)) {
            $data['topStudents'] = User::whereHas('role', fn ($q) => $q->where('name', 'student'))
                ->withCount('grades')
                ->orderByDesc('grades_count')
                ->limit(10)
                ->get();
        }

        if (in_array('top_teachers', $selectedSections)) {
            $data['topTeachers'] = User::whereHas('role', fn ($q) => $q->where('name', 'teacher'))
                ->withCount('gradesAsTeacher')
                ->orderByDesc('grades_as_teacher_count')
                ->limit(10)
                ->get();
        }

        $data['selectedSections'] = $selectedSections;

        $pdf = Pdf::loadView('admin.reports.export', $data)
            ->setPaper('a4', 'portrait');

        $filename = 'raport-systemu-' . Carbon::now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}
