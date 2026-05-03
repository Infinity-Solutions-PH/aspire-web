<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ScheduleManager;
use App\Livewire\Admin\EnrollmentReview;
use App\Livewire\Admin\SectionManagement;
use App\Livewire\Admin\EnrollmentDashboard;
use App\Livewire\Admin\StudentMasterlist;
use App\Http\Controllers\Landing\PageController as LandingPageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Admin Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth', [LandingPageController::class, 'adminLogin'])->name('admin.login');
});

// Admin Authenticated Routes
Route::middleware(['auth', 'verified', 'can:access-admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/enrollments', EnrollmentDashboard::class)->name('admin.enrollments');
    Route::get('/enrollments/{enrollment}/review', EnrollmentReview::class)->name('admin.enrollment.review');
    Route::get('/pre-enrollments/{preEnrollment}/review', EnrollmentReview::class)->name('admin.pre_enrollment.review');
    Route::get('/students/masterlist', StudentMasterlist::class)->name('admin.students.masterlist');
    Route::get('/sections', SectionManagement::class)->name('admin.sections');
    Route::get('/schedules', ScheduleManager::class)->name('admin.schedules');
});
