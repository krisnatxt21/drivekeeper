<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ServiceRecordController; // ← tambah ini

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('service-records', ServiceRecordController::class); // ← tambah ini
});

require __DIR__.'/auth.php';
