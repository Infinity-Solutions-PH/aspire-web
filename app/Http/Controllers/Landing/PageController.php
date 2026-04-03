<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.landing.login');
    }

    public function login()
    {
        return view('pages.landing.login');
    }
}
