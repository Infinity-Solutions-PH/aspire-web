<?php

use App\Models\Enrollment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentPortal\Enrollment\CertificateController;
use App\Http\Controllers\Landing\PageController as LandingPageController;
use App\Http\Controllers\StudentPortal\DashboardController as StudentDashboardController;
use App\Http\Controllers\StudentPortal\EnrollmentController as StudentEnrollmentController;

// Portal Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth', [LandingPageController::class, 'portalLogin'])->name('portal.login');
});

// Portal Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function() {
        return redirect()->route('dashboard');
    });
    
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/enrollment', [StudentEnrollmentController::class, 'index'])->name('enrollment.index');
    Route::post('/enrollment/start', [StudentEnrollmentController::class, 'start'])->name('enrollment.start');
    
    Route::get('/enrollment/certificate', [CertificateController::class, 'download'])->name('enrollment.certificate');
});
