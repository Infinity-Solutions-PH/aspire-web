<?php

use App\Livewire\EnrollmentForm;
use App\Livewire\EnrollmentPost;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\EnrollmentReview;
use App\Livewire\Admin\EnrollmentDashboard;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Enrollment\CertificateController;
use App\Http\Controllers\Landing\PageController as LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Google Authentication
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/enroll', EnrollmentForm::class)->name('enrollment.form');
    Route::get('/enrollment-status', EnrollmentPost::class)->name('enrollment.status');

    // Admin/Registrar Routes
    Route::prefix('admin')->middleware(['can:access-admin'])->group(function () {
        Route::get('/enrollments', EnrollmentDashboard::class)->name('admin.enrollments');
        Route::get('/enrollments/{enrollment}/review', EnrollmentReview::class)->name('admin.enrollment.review');
        Route::get('/schedules', \App\Livewire\Admin\ScheduleManager::class)->name('admin.schedules');
    });

    // PDF Certificate
    Route::get('/enrollment/certificate', [CertificateController::class, 'download'])->name('enrollment.certificate');
});

require __DIR__.'/settings.php';
