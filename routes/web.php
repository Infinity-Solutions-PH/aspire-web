<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Public\EnrollmentWizard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Landing\PageController as LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/programs', [LandingPageController::class, 'programs'])->name('programs');
Route::get('/enrollment/start', EnrollmentWizard::class)->name('enroll.public');

// Google Authentication
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Legacy/Generic Dashboard Redirect
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
