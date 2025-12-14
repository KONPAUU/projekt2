<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                           ->with('error', 'Musisz być zalogowany aby uzyskać dostęp do tej strony.');
        }

        $user = auth()->user();

        // Sprawdzenie czy użytkownik ma którąkolwiek z wymaganych ról
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Jeśli nie ma uprawnień, przekieruj na odpowiednią stronę
        return $this->redirectBasedOnUserRole($user);
    }

    /**
     * Przekieruj użytkownika na podstawie jego roli
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnUserRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Nie masz uprawnień do tej sekcji.');
        } elseif ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard')
                           ->with('error', 'Nie masz uprawnień do tej sekcji.');
        } elseif ($user->isStudent()) {
            return redirect()->route('student.dashboard')
                           ->with('error', 'Nie masz uprawnień do tej sekcji.');
        }

        return redirect()->route('home')
                       ->with('error', 'Nie masz uprawnień do tej sekcji.');
    }
}