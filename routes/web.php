<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Authenticated\CustomerController;
use App\Http\Controllers\Authenticated\DashboardController;
use App\Http\Controllers\Authenticated\OrderController;
use App\Http\Controllers\Authenticated\StockController;
use App\Http\Controllers\Authenticated\SupportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // If not authenticated, forward to the login page
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    // Else, forward to admin panel or user panel based on the user role
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard');
})->name('home');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customers routes
    Route::prefix('customers')->as('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Orders routes
    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    });

    // Stock routes
    Route::prefix('stock')->as('stock.')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/{product}', [StockController::class, 'show'])->name('show');
        Route::delete('/{product}', [StockController::class, 'destroy'])->name('destroy');
    });

    // Support routes
    Route::prefix('support')->as('support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
    });
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
