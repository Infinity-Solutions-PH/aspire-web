<?php

namespace App\Http\Controllers;

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
        $user = auth()->user();

        if ($user->hasRole('faculty')) {
            return redirect()->route('faculty.dashboard');
        }

        if ($user->hasAnyRole(['superadmin', 'admin'])) {

            if ($user->name === 'Registrar') {
                return redirect()->route('admin.admissions');
            }

            if ($user->name === 'OVPD Office') {
                return redirect()->route('admin.violations');
            }

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('student.dashboard');
    }
}
