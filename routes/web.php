<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController; // ← tambah ini

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// ← tambah ini
Route::middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
});

require __DIR__.'/auth.php';
