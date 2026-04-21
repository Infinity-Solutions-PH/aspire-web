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
        if (auth()->user()->can('access-admin')) {
            return redirect()->route('admin.dashboard');
        }

        $enrollment = Enrollment::where('user_id', auth()->id())->latest()->first();
        if (!$enrollment || $enrollment->status !== 'Enrolled') {
            return redirect()->route('enrollment.index');
        }

        return redirect()->route('student.dashboard');
    }
}
