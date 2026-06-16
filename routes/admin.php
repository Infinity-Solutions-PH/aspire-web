<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Faculty\SignupWizard;
use App\Livewire\Admin\AdmissionReview;
use App\Livewire\Admin\ScheduleManager;
use App\Livewire\Admin\FacultyManagement;
use App\Livewire\Admin\SectionManagement;
use App\Livewire\Admin\StudentMasterlist;
use App\Livewire\Admin\StudentViolations;
use App\Livewire\Admin\AdmissionDashboard;
use App\Livewire\Admin\PlantillaManagement;
use App\Livewire\Admin\SchoolYearManagement;
use App\Livewire\Admin\Section\ManageStudents;
use App\Http\Controllers\Admin\ExportSectionMasterlistController;
use App\Http\Controllers\Landing\PageController as LandingPageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Admin Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth', [LandingPageController::class, 'adminLogin'])->name('admin.login');
    Route::get('/faculty/create', SignupWizard::class)->name('faculty.signup');
});

// Admin Authenticated Routes
Route::middleware(['auth', 'verified', 'can:access-admin'])->group(function () {
    Route::get('/', function() {
        return redirect()->route('dashboard');
    });

    // Violations route - accessible by all admin roles (including ovpd)
    Route::get('/violations', StudentViolations::class)->name('admin.violations');

    // Core admin routes - restricted to standard admins (excludes ovpd)
    Route::middleware('can:access-admin-standard')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admissions', AdmissionDashboard::class)->name('admin.admissions');
        Route::get('/enrollments/{enrollment}/review', AdmissionReview::class)->name('admin.enrollment.review');
        Route::get('/admission/{preEnrollment}/review', AdmissionReview::class)->name('admin.pre_enrollment.review');
        Route::get('/students/masterlist', StudentMasterlist::class)->name('admin.students.masterlist');

        // Section Routes
        Route::get('/sections', SectionManagement::class)->name('admin.sections');
        Route::get('/sections/{section}', ManageStudents::class)->name('admin.sections.students');
        Route::get('/sections/{section}/export/pdf', [ExportSectionMasterlistController::class, 'exportPdf'])->name('admin.sections.export.pdf');
        Route::get('/sections/{section}/export/csv', [ExportSectionMasterlistController::class, 'exportCsv'])->name('admin.sections.export.csv');

        Route::get('/schedules', ScheduleManager::class)->name('admin.schedules');
        Route::get('/faculty', FacultyManagement::class)->name('admin.faculty');
        Route::get('/plantillas', PlantillaManagement::class)->name('admin.plantillas');
        Route::get('/school-years', SchoolYearManagement::class)->name('admin.school-years');
    });
});
