<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the generic dashboard redirection based on user role and enrollment status.
     *
     * @return RedirectResponse
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('access-admin')) {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->can('access-faculty')) {
            return redirect()->route('faculty.dashboard');
        }

        return redirect()->route('student.dashboard');
    }
}
