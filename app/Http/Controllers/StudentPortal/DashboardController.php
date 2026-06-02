<?php

namespace App\Http\Controllers\StudentPortal;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->with(['section.adviser'])
            ->latest()
            ->first();

        return view('pages.StudentPortal.dashboard.index', [
            'enrollment' => $enrollment,
        ]);
    }

    public function profile()
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('pages.StudentPortal.profile', [
            'enrollment' => $enrollment,
        ]);
    }
}
