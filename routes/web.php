<?php

use App\Livewire\EnrollmentForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Landing\PageController as LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Google Authentication
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/enroll', EnrollmentForm::class)->name('enrollment.form');
});

require __DIR__.'/settings.php';
