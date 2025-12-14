<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\SchoolClass;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['role', 'schoolClass']);

        // Wyszukiwanie
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('pesel', 'LIKE', "%{$search}%");
            });
        }

        // Filtrowanie po roli
        if ($request->filled('role')) {
            $roleId = match($request->role) {
                'admin' => Role::admin()->id,
                'teacher' => Role::teacher()->id,
                'student' => Role::student()->id,
                default => null
            };
            if ($roleId) {
                $query->where('role_id', $roleId);
            }
        }

        // Filtrowanie po statusie
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        // Filtrowanie po klasie
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        $roles = Role::all();
        $classes = SchoolClass::all();

        // Statystyki użytkowników
        $stats = [
            'total' => User::count(),
            'students' => User::whereHas('role', function($q) {
                $q->where('name', 'student');
            })->count(),
            'teachers' => User::whereHas('role', function($q) {
                $q->where('name', 'teacher');
            })->count(),
            'admins' => User::whereHas('role', function($q) {
                $q->where('name', 'admin');
            })->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'classes', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $classes = SchoolClass::all();

        return view('admin.users.create', compact('roles', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Użytkownik został utworzony pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['role', 'schoolClass', 'grades.subject', 'grades.teacher']);

        // Statystyki ucznia
        $stats = [
            'total_grades' => $user->grades->count(),
            'average' => $user->getWeightedAverage(),
            'subjects_count' => $user->grades->groupBy('subject_id')->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $classes = SchoolClass::all();

        return view('admin.users.edit', compact('user', 'roles', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        // Jeśli podano nowe hasło, zahashuj je
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json';

        // Nie pozwalaj usunąć siebie
        if ($user->id === auth()->id()) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'Nie możesz usunąć swojego własnego konta.']);
            }
            return redirect()->route('admin.users.index')
                           ->with('error', 'Nie możesz usunąć swojego własnego konta.');
        }

        $user->delete();

        if ($isAjax) {
            return response()->json(['success' => true, 'message' => 'Użytkownik został usunięty.']);
        }

        return redirect()->route('admin.users.index')
                        ->with('success', 'Użytkownik został usunięty.');
    }

    /**
     * Search users using regular expressions.
     */
    public function search(Request $request)
    {
        $request->validate([
            'pattern' => 'required|string|max:255',
            'field' => 'required|in:name,email,pesel',
        ]);

        $pattern = $request->pattern;
        $field = $request->field;

        try {
            $users = User::with(['role', 'schoolClass'])
                        ->where($field, 'REGEXP', $pattern)
                        ->paginate(20);

            return view('admin.users.search', compact('users', 'pattern', 'field'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Nieprawidłowe wyrażenie regularne.');
        }
    }

    /**
     * Bulk actions for users.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,change_role',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'role_id' => 'required_if:action,change_role|exists:roles,id',
        ]);

        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json';

        $userIds = $request->user_ids;
        $action = $request->action;

        // Nie pozwalaj na akcje na swoim koncie
        if (in_array(auth()->id(), $userIds)) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'Nie możesz wykonać tej akcji na swoim koncie.']);
            }
            return redirect()->route('admin.users.index')
                           ->with('error', 'Nie możesz wykonać tej akcji na swoim koncie.');
        }

        switch ($action) {
            case 'delete':
                User::whereIn('id', $userIds)->delete();
                $message = 'Wybrani użytkownicy zostali usunięci.';
                break;

            case 'change_role':
                User::whereIn('id', $userIds)->update(['role_id' => $request->role_id]);
                $message = 'Rola została zmieniona dla wybranych użytkowników.';
                break;
        }

        if ($isAjax) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('admin.users.index')
                        ->with('success', $message);
    }
}