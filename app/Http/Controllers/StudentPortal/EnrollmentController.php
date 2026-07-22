<?php

namespace App\Http\Controllers\StudentPortal;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollment = Auth::user()->enrollments()->latest()->first();

        return view('pages.StudentPortal.enrollment.index', [
            'enrollment' => $enrollment,
        ]);
    }

    public function start()
    {
        $exists = Auth::user()->enrollments()
            ->whereIn('status', ['Draft', 'pending_approval', 'Approved', 'Enrolled'])
            ->exists();

        if ($exists) {
            return redirect()->route('enrollment.index')->with('error', 'You already have an active enrollment application.');
        }

        Enrollment::create([
            'student_id' => Auth::user()->student->id,
            'status' => 'Draft',
            'current_step' => 1,
        ]);

        return redirect()->route('enrollment.index');
    }
}
