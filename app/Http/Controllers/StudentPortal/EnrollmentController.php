<?php

namespace App\Http\Controllers\StudentPortal;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollment = Enrollment::where('user_id', Auth::id())->latest()->first();

        return view('pages.StudentPortal.enrollment.index', [
            'enrollment' => $enrollment,
        ]);
    }

    public function start()
    {
        Enrollment::create([
            'user_id' => Auth::id(),
            'status' => 'Draft',
            'current_step' => 1,
        ]);

        return redirect()->route('enrollment.index');
    }
}
