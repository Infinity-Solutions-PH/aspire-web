<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ScheduleManager;
use App\Livewire\Admin\EnrollmentReview;
use App\Livewire\Admin\SectionManagement;
use App\Livewire\Admin\EnrollmentDashboard;
use App\Livewire\StudentPortal\EnrollmentForm;
use App\Livewire\StudentPortal\EnrollmentPost;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\StudentPortal\Enrollment\CertificateController;
use App\Http\Controllers\Landing\PageController as LandingPageController;
use App\Http\Controllers\StudentPortal\DashboardController as StudentDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\StudentPortal\EnrollmentController as StudentEnrollmentController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/programs', [LandingPageController::class, 'programs'])->name('programs');
Route::get('/login-portal', [LandingPageController::class, 'login'])->name('login-portal');

// Google Authentication
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Legacy/Generic Dashboard Redirect
    Route::get('/dashboard', function () {
        if (auth()->user()->can('access-admin')) {
            return redirect()->route('admin.dashboard');
        }

        $enrollment = \App\Models\Enrollment::where('user_id', auth()->id())->latest()->first();
        if (!$enrollment || $enrollment->status !== 'Enrolled') {
            return redirect()->route('enrollment.index');
        }

        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // Student Portal Routes
    Route::prefix('portal')->group(function () {
        Route::get('/', function() {
            return redirect()->route('dashboard');
        });
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
        Route::get('/enrollment', [StudentEnrollmentController::class, 'index'])->name('enrollment.index');
        Route::post('/enrollment/start', [StudentEnrollmentController::class, 'start'])->name('enrollment.start');
        
        Route::get('/enrollment/certificate', [CertificateController::class, 'download'])->name('enrollment.certificate');
    });

    // Admin/Registrar Routes
    Route::prefix('admin')->middleware(['can:access-admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/enrollments', EnrollmentDashboard::class)->name('admin.enrollments');
        Route::get('/enrollments/{enrollment}/review', EnrollmentReview::class)->name('admin.enrollment.review');
        Route::get('/sections', SectionManagement::class)->name('admin.sections');
        Route::get('/schedules', ScheduleManager::class)->name('admin.schedules');
    });
});

require __DIR__.'/settings.php';
