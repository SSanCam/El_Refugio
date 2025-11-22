<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\AdoptionController;
use App\Http\Controllers\Admin\FosterController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->group(function () {

    // Panel principal de administración
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Gestión de animales
    Route::resource('animals', AnimalController::class);

    // Gestión de adopciones
    Route::resource('adoptions', AdoptionController::class);

    // Gestión de acogidas
    Route::resource('fosters', FosterController::class);

    // Gestión de usuarios (desde administración)
    Route::resource('users', UserController::class);
});
