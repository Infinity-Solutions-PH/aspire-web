<?php

use App\Livewire\Enrollment\Wizard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Landing\PageController as LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/programs', [LandingPageController::class, 'programs'])->name('programs');
Route::get('/enrollment', Wizard::class)->name('enroll.public');

// Google Authentication
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route::get('/demo-reset', function() {
//     try {
//         Artisan::call('migrate:fresh', [
//             '--seed' => true,
//             '--force' => true,
//         ]);
//         return "Database has been refreshed and seeded successfully for demo purposes.";
//     } catch (\Exception $e) {
//         return "Reset failed: " . $e->getMessage();
//     }
// });

require __DIR__.'/settings.php';
