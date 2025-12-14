<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::with(['teachers', 'classes'])
                       ->withCount(['grades', 'classes', 'teachers'])
                       ->withAvg('grades', 'grade');

        // Wyszukiwanie
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $subjects = $query->orderBy('name')->paginate(15);

        // Dodaj average_grade jako atrybut
        $subjects->getCollection()->transform(function ($subject) {
            $subject->average_grade = $subject->grades_avg_grade;
            return $subject;
        });

        // Statystyki
        $stats = [
            'total_subjects' => Subject::count(),
            'subjects_with_teachers' => Subject::has('teachers')->count(),
            'subjects_with_grades' => Subject::has('grades')->count(),
            'average_grade' => \App\Models\Grade::avg('grade') ?? 0,
        ];

        return view('admin.subjects.index', compact('subjects', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'code' => 'nullable|string|max:10|unique:subjects',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'hours_per_week' => 'nullable|integer|min:1|max:20',
            'is_mandatory' => 'boolean',
            'has_final_exam' => 'boolean',
        ], [
            'name.required' => 'Nazwa przedmiotu jest wymagana.',
            'name.unique' => 'Przedmiot o tej nazwie już istnieje.',
            'code.unique' => 'Kod przedmiotu już istnieje.',
            'description.max' => 'Opis nie może być dłuższy niż 1000 znaków.',
            'hours_per_week.min' => 'Minimalna liczba godzin to 1.',
            'hours_per_week.max' => 'Maksymalna liczba godzin to 20.',
        ]);

        $data = $request->only([
            'name', 'description', 'code', 'category', 'icon', 'color', 'hours_per_week'
        ]);

        $data['is_mandatory'] = $request->has('is_mandatory');
        $data['has_final_exam'] = $request->has('has_final_exam');

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
                        ->with('success', 'Przedmiot został utworzony pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load(['classes.tutor', 'teachers', 'grades.student']);

        $stats = [
            'classes_count' => $subject->classes->count(),
            'teachers_count' => $subject->teachers->count(),
            'grades_count' => $subject->grades->count(),
            'average_grade' => $subject->grades->avg('grade'),
        ];

        return view('admin.subjects.show', compact('subject', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'code' => 'nullable|string|max:10|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:255',
            'hours_per_week' => 'nullable|integer|min:1|max:20',
        ]);

        $data = $request->only([
            'name', 'description', 'code', 'category', 'hours_per_week'
        ]);

        $data['is_mandatory'] = $request->has('is_mandatory');
        $data['has_final_exam'] = $request->has('has_final_exam');

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
                        ->with('success', 'Przedmiot został zaktualizowany.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Request $request)
    {
        // Sprawdź czy przedmiot ma oceny
        if ($subject->grades()->count() > 0) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Nie można usunąć przedmiotu który ma przypisane oceny.']);
            }
            return redirect()->route('admin.subjects.index')
                           ->with('error', 'Nie można usunąć przedmiotu który ma przypisane oceny.');
        }

        $subject->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Przedmiot został usunięty.']);
        }

        return redirect()->route('admin.subjects.index')
                        ->with('success', 'Przedmiot został usunięty.');
    }
}