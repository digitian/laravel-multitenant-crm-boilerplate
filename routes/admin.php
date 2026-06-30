<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SupportRequestController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/companies', CompanyController::class);
    Route::post('/companies/{company}/create-user', [CompanyController::class, 'storeUser'])->name('companies.store.user');

    Route::resource('/users', UserController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/support', [SupportRequestController::class, 'index'])->name('support.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});
