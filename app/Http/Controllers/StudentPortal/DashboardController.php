<?php

namespace App\Http\Controllers\StudentPortal;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $enrollment = auth()->user()->enrollments()
            ->with(['section.adviser'])
            ->latest()
            ->first();

        return view('pages.StudentPortal.dashboard.index', [
            'enrollment' => $enrollment,
        ]);
    }

    public function profile()
    {
        $enrollment = auth()->user()->enrollments()
            ->latest()
            ->first();

        return view('pages.StudentPortal.profile', [
            'enrollment' => $enrollment,
        ]);
    }

    public function enrollmentHistory()
    {
        $enrollments = auth()->user()->enrollments()
            ->with(['schoolYear', 'section.adviser', 'techVocSection.adviser'])
            ->join('school_years', 'enrollments.school_year_id', '=', 'school_years.id')
            ->orderBy('school_years.name', 'desc')
            ->select('enrollments.*')
            ->get();

        return view('pages.StudentPortal.history', [
            'enrollments' => $enrollments,
        ]);
    }
}
