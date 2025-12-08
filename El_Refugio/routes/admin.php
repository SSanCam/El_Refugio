<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdoptionController;
use App\Http\Controllers\Admin\FosterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnimalController;

Route::middleware(['auth', 'verified', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Panel principal
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD usuarios
        Route::resource('users', UserController::class);

        // CRUD animales
        Route::resource('animals', AnimalController::class);
            //Agrega una nueva imagen a,l animal
        Route::post('animals/{animal}/photos', [AnimalController::class, 'storePhoto'])
            ->name('animals.addPhoto');

        // CRUD adopciones
        Route::resource('adoptions', AdoptionController::class);

        // CRUD acogidas
        Route::resource('fosters', FosterController::class);
});