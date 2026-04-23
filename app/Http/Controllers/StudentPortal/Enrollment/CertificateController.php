<?php

namespace App\Http\Controllers\StudentPortal\Enrollment;

use App\Models\Fee;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download(Request $request)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->whereIn('status', ['Enrolled', 'Submitted', 'Approved'])
            ->latest()
            ->firstOrFail();

        if ($request->has('soa')) {
            $fees = Fee::where(function($query) use ($enrollment) {
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
