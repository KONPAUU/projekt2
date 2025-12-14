<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                           ->with('error', 'Musisz być zalogowany aby uzyskać dostęp do panelu administracyjnego.');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')
                           ->with('error', 'Nie masz uprawnień administratora.');
        }

        return $next($request);
    }
}