<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the generic dashboard redirection based on user role and enrollment status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if (auth()->user()->role === 'ovpd') {
            return redirect()->route('admin.violations');
        }

        if (auth()->user()->can('access-admin')) {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->can('access-faculty')) {
            return redirect()->route('faculty.dashboard');
        }

        return redirect()->route('student.dashboard');
    }
}
