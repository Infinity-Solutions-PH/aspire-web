<?php

namespace App\Livewire\StudentPortal;

use Livewire\Component;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentPost extends Component
{
    public Enrollment $enrollment;

    public function mount()
    {
        $this->enrollment = Enrollment::where('user_id', Auth::id())->latest()->first();

        if (!$this->enrollment) {
            return redirect()->route('enrollment.index');
        }

        // If the enrollment is already verified (i.e. registrar checked), 
        // they shouldn't be seeing the post-enrollment schedule screen anymore.
        if ($this->enrollment->status === 'Verified') {
            return redirect()->route('dashboard');
        }
    }

    public function downloadPass()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.enrollment-certificate', [
            'enrollment' => $this->enrollment
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "TNTS_Admission_Pass_{$this->enrollment->lrn}.pdf");
    }

    public function render()
    {
        return view('pages.StudentPortal.enrollment.post')
            ->layout('layouts.student-portal');
    }
}
