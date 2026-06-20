<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.Admin.dashboard');
    }

//     public function downloadExport(Request $request)
//     {
//         $file = $request->query('file');
        
//         // Check that the file has an export_ prefix to prevent downloading arbitrary temp files
//         if (!$file || !preg_match('/^export_[a-zA-Z0-9_-]+\.zip$/', $file)) {
//             abort(404);
//         }

//         $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file;
        
//         if (!file_exists($path)) {
//             abort(404);
//         }

//         $downloadName = 'Student_Masterlist_Export_' . date('Ymd_His') . '.zip';
//         return response()->download($path, $downloadName)->deleteFileAfterSend(true);
//     }

    public function downloadExport(Request $request)
    {
        $file = $request->query('file');
        
        // Check that the file has an export_ prefix to prevent downloading arbitrary temp files
        if (!$file || !preg_match('/^export_[a-zA-Z0-9_-]+\.zip$/', $file)) {
            abort(404, 'Invalid file pattern.');
        }

        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file;
        
        if (!file_exists($path)) {
            abort(404, 'Export file no longer exists.');
        }

        $downloadName = 'Student_Masterlist_Export_' . date('Ymd_His') . '.zip';

        // Create a direct Symfony response which handles arbitrary system paths smoothly
        $response = new BinaryFileResponse(
            $path, 
            200, 
            [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $downloadName . '"'
            ]
        );

        // This safely unlinks the file from /tmp right after the stream closes
        return $response->deleteFileAfterSend(true);
    }
}
