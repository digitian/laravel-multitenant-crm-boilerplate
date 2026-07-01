<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Unauthenticated routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('authenticate');
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile routes. These routes are being used by all of the users. Layouts differ by the user roles (admin or user).
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::put('/photo-upload', [ProfileController::class, 'photoUpload'])->name('photo-upload');
        Route::post('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('delete-photo');
    });

    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

// Import admin routes
require __DIR__.'/admin.php';
