<?php

namespace App\Http\Controllers\Enrollment;

use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download()
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('status', 'Enrolled')
            ->latest()
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.enrollment-certificate', compact('enrollment'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("TNTS_Certificate_{$enrollment->lrn}.pdf");
    }
}
