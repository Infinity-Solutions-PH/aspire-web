<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.landing.home');
    }

    public function login()
    {
        return view('pages.landing.login');
    }

    public function programs()
    {
        return view('pages.landing.programs');
    }
}
