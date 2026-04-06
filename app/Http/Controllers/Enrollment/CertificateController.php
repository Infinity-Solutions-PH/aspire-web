<?php

namespace App\Http\Controllers\Enrollment;

use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download(\Illuminate\Http\Request $request)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('status', 'Enrolled')
            ->latest()
            ->firstOrFail();

        if ($request->has('soa')) {
            $fees = \App\Models\Fee::where(function($query) use ($enrollment) {
                $query->where('track', $enrollment->track)
                      ->orWhere('strand', $enrollment->strand)
                      ->orWhere('specialization', $enrollment->specialization)
                      ->orWhereNull('track');
            })->get();

            $pdf = Pdf::loadView('pdf.soa', compact('enrollment', 'fees'))
                ->setPaper('a4', 'portrait');

            return $pdf->download("TNTS_SOA_{$enrollment->lrn}.pdf");
        }

        $pdf = Pdf::loadView('pdf.enrollment-certificate', compact('enrollment'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("TNTS_Certificate_{$enrollment->lrn}.pdf");
    }
}
