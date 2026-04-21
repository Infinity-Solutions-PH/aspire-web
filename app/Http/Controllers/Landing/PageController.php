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

    public function portalLogin()
    {
        return view('pages.landing.portal-login');
    }

    public function adminLogin()
    {
        return view('pages.landing.admin-login');
    }

    public function programs()
    {
        return view('pages.landing.programs');
    }
}
