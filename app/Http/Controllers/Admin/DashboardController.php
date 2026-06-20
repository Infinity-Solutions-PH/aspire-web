<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.Admin.dashboard');
    }

    public function downloadExport(Request $request)
    {
        $file = $request->query('file');
        
        // Basic security check
        if (!$file || !preg_match('/^[a-zA-Z0-9_-]+\.zip$/', $file)) {
            abort(404);
        }

        $path = storage_path('app/exports/' . $file);
        
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
