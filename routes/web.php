<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ServiceRecordController;

Route::view('/', 'welcome');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('service-records', ServiceRecordController::class);
    Route::resource('fuel-logs', \App\Http\Controllers\FuelLogController::class);
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    Route::resource('reminders', \App\Http\Controllers\ReminderController::class);
    Route::post('reminders/{reminder}/toggle', [\App\Http\Controllers\ReminderController::class, 'toggle'])->name('reminders.toggle');
    Route::resource('documents', \App\Http\Controllers\DocumentController::class);
});

require __DIR__.'/auth.php';
