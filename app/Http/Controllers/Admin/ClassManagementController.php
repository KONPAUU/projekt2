<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\Subject;
use App\Models\Role;
use Illuminate\Http\Request;

class ClassManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SchoolClass::with(['tutor', 'students', 'subjects'])
                           ->withCount('students');

        // Wyszukiwanie
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $classes = $query->orderBy('name')->paginate(10);

        // Oblicz średnie dla każdej klasy
        $classes->getCollection()->transform(function ($class) {
            $totalWeightedSum = 0;
            $totalWeight = 0;

            foreach ($class->students as $student) {
                $studentAverage = $student->getWeightedAverage();
                if ($studentAverage > 0) {
                    $totalWeightedSum += $studentAverage;
                    $totalWeight++;
                }
            }

            $class->average = $totalWeight > 0 ? $totalWeightedSum / $totalWeight : 0;
            return $class;
        });

        // Statystyki
        $stats = [
            'total_classes' => SchoolClass::count(),
            'total_students' => User::where('role_id', Role::student()->id)->count(),
            'average_students' => SchoolClass::withCount('students')->avg('students_count'),
            'classes_with_tutors' => SchoolClass::whereNotNull('tutor_id')->count(),
        ];

        return view('admin.classes.index', compact('classes', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::where('role_id', Role::teacher()->id)->get();

        return view('admin.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'tutor_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nazwa klasy jest wymagana.',
            'year.required' => 'Rok szkolny jest wymagany.',
            'tutor_id.exists' => 'Wybrany wychowawca nie istnieje.',
        ]);

        SchoolClass::create($request->only(['name', 'year', 'tutor_id']));

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Klasa została utworzona pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $class)
    {
        $class->load(['students.role', 'tutor', 'subjects.teachers']);

        $stats = [
            'students_count' => $class->students->count(),
            'subjects_count' => $class->subjects->count(),
        ];

        return view('admin.classes.show', compact('class', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $class)
    {
        $teachers = User::where('role_id', Role::teacher()->id)->get();

        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'tutor_id' => 'nullable|exists:users,id',
        ]);

        $class->update($request->only(['name', 'year', 'tutor_id']));

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Klasa została zaktualizowana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class, Request $request)
    {
        // Sprawdź czy klasa ma uczniów
        if ($class->students()->count() > 0) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Nie można usunąć klasy która ma przypisanych uczniów.']);
            }
            return redirect()->route('admin.classes.index')
                           ->with('error', 'Nie można usunąć klasy która ma przypisanych uczniów.');
        }

        $class->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Klasa została usunięta.']);
        }

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Klasa została usunięta.');
    }

    /**
     * Manage class subjects and teachers assignment.
     */
    public function manage(SchoolClass $class)
    {
        $subjects = Subject::all();
        $teachers = User::where('role_id', Role::teacher()->id)->get();

        $assignedSubjects = $class->subjects()->with('teachers')->get();

        return view('admin.classes.manage', compact('class', 'subjects', 'teachers', 'assignedSubjects'));
    }

    /**
     * Assign subject and teacher to class.
     */
    public function assignSubject(Request $request, SchoolClass $class)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        // Sprawdź czy kombinacja już istnieje
        $exists = $class->subjects()
                       ->wherePivot('subject_id', $request->subject_id)
                       ->wherePivot('teacher_id', $request->teacher_id)
                       ->exists();

        if ($exists) {
            return redirect()->back()
                           ->with('error', 'Ten nauczyciel już prowadzi ten przedmiot w tej klasie.');
        }

        $class->subjects()->attach($request->subject_id, [
            'teacher_id' => $request->teacher_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()
                        ->with('success', 'Przedmiot został przypisany do klasy.');
    }

    /**
     * Remove subject assignment from class.
     */
    public function removeSubject(SchoolClass $class, $subjectId, $teacherId)
    {
        $class->subjects()
             ->wherePivot('subject_id', $subjectId)
             ->wherePivot('teacher_id', $teacherId)
             ->detach();

        return redirect()->back()
                        ->with('success', 'Przypisanie przedmiotu zostało usunięte.');
    }
}