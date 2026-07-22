<?php

use App\Livewire\Faculty\Profile;
use App\Livewire\Faculty\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\Faculty\SectionsList;
use App\Livewire\StudentPortal\Violations;
use App\Livewire\Faculty\ManageSectionStudents;
use App\Http\Controllers\Admin\ExportSectionMasterlistController;
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
    Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('student.profile');
    Route::get('/history', [StudentDashboardController::class, 'enrollmentHistory'])->name('student.history');
    Route::get('/violations', Violations::class)->name('student.violations');
    // Route::get('/enrollment', [StudentEnrollmentController::class, 'index'])->name('enrollment.index');
    // Route::post('/enrollment/start', [StudentEnrollmentController::class, 'start'])->name('enrollment.start');
    Route::get('/enrollment/certificate', [CertificateController::class, 'download'])->name('enrollment.certificate');
});

// Faculty Portal Authenticated Routes
Route::middleware(['auth', 'verified', 'role:faculty'])->prefix('faculty')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('faculty.dashboard');
    Route::get('/sections', SectionsList::class)->name('faculty.sections');
    Route::get('/sections/{section}', ManageSectionStudents::class)->name('faculty.sections.students');
    Route::get('/profile', Profile::class)->name('faculty.profile');

    Route::get('/sections/{section}/export/pdf', [ExportSectionMasterlistController::class, 'exportPdf'])->name('faculty.sections.export.pdf');
    Route::get('/sections/{section}/export/csv', [ExportSectionMasterlistController::class, 'exportCsv'])->name('faculty.sections.export.csv');
});
