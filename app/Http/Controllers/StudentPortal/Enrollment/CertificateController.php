<?php

namespace App\Http\Controllers\StudentPortal\Enrollment;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download(Request $request)
    {
        $enrollment = Auth::user()->enrollments()
            ->whereIn('status', ['Enrolled', 'pending_approval', 'Approved'])
            ->latest()
            ->firstOrFail();



        $qrCode = null;
        try {
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($enrollment->lrn);
            $qrData = file_get_contents($qrUrl);
            $qrCode = 'data:image/png;base64,' . base64_encode($qrData);
        } catch (\Exception $e) {
            // Fallback to null if QR generation fails
        }

        $isOfficialCOE = true;
        $pdf = Pdf::loadView('pdf.enrollment-certificate', compact('enrollment', 'qrCode', 'isOfficialCOE'))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true);

        return $pdf->download("TNTS_Certificate_{$enrollment->lrn}.pdf");
    }
}
