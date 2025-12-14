<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Jeśli użytkownik jest zalogowany, przekieruj do odpowiedniego panelu
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('home');
    }
}