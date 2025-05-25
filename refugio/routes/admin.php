<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnimalController; 

Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        /**
         * Rutas para la gestión de usuarios
         */
        // GET
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

        // POST
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
        Route::post('users/{user}/activate', [UserController::class, 'activateUser'])->name('users.activate');
        Route::post('users/{user}/deactivate', [UserController::class, 'deactivateUser'])->name('users.deactivate');

        // PUT
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

        // DELETE
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   
        // Rutas para la gestión de animales
        Route::get('animals', [AnimalController::class, 'index'])->name('animals.index');
        Route::get('animals/create', [AnimalController::class, 'create'])->name('animals.create');
        Route::post('animals', [AnimalController::class, 'store'])->name('animals.store');
        Route::get('animals/{id}', [AnimalController::class, 'show'])->name('animals.show');
        Route::get('animals/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
        Route::put('animals/{id}', [AnimalController::class, 'update'])->name('animals.update');
        Route::delete('animals/{id}', [AnimalController::class, 'destroy'])->name('animals.destroy');
        Route::post('animals/{id}/status', [AnimalController::class, 'changeStatus'])->name('animals.changeStatus');
        Route::post('animals/{id}/deactivate', [AnimalController::class, 'deactivate'])->name('animals.deactivate');

    });