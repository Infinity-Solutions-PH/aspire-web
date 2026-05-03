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
        $qrCode = null;
        try {
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($this->enrollment->transaction_number);
            $qrData = file_get_contents($qrUrl);
            $qrCode = 'data:image/png;base64,' . base64_encode($qrData);
        } catch (\Exception $e) {
            // Fallback
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.enrollment-certificate', [
            'enrollment' => $this->enrollment,
            'qrCode' => $qrCode
        ])->setPaper('a4', 'portrait')
          ->setOption('isRemoteEnabled', true)
          ->setOption('isHtml5ParserEnabled', true);

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
