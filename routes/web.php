<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\PageController as LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
