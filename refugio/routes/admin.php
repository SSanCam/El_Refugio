<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnimalController; 
use App\Http\Controllers\Admin\AdoptionController;
use App\Http\Controllers\Admin\FosterController;

/**
 * Rutas de administración del refugio
 * Estas rutas están protegidas por middleware de autenticación y verificación de rol.
 * Solo los usuarios con el rol de administrador pueden acceder a estas rutas.
 * Las rutas están agrupadas bajo el prefijo 'admin' y tienen un nombre específico para facilitar su referencia.
 */
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        /**
         * Rutas para la gestión de usuarios
         * Estas rutas permiten crear, editar, eliminar y listar usuarios del sistema.
         * Incluyen funcionalidades para asignar roles, activar y desactivar usuarios.
         * Además, se asegura que solo los administradores puedan acceder a estas rutas.
         * Las rutas están protegidas por middleware de autenticación y verificación de rol.
         * Cada ruta está nombrada para facilitar su referencia en las vistas y controladores.
         */
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
        Route::patch('users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggleActive');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   
        /**
         * Rutas para la gestión de animales
         * Estas rutas permiten crear, editar, eliminar y listar animales en el refugio.
         * Incluyen funcionalidades para cambiar el estado de un animal y desactivarlo.
         */
        Route::get('animals', [AnimalController::class, 'index'])->name('animals.index');
        Route::get('animals/create', [AnimalController::class, 'create'])->name('animals.create');
        Route::post('animals', [AnimalController::class, 'store'])->name('animals.store');
        Route::get('animals/{id}', [AnimalController::class, 'show'])->name('animals.show');
        Route::get('animals/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
        Route::put('animals/{id}', [AnimalController::class, 'update'])->name('animals.update');
        Route::delete('animals/{id}', [AnimalController::class, 'destroy'])->name('animals.destroy');
        Route::post('animals/{id}/status', [AnimalController::class, 'changeStatus'])->name('animals.changeStatus');

        /**
         * Rutas para la gestión de adopciones
         * Estas rutas permiten crear, editar, eliminar y listar adopciones de animales.
         * Incluyen funcionalidades para gestionar el proceso de adopción y asignar animales a adoptantes.
         * Las rutas están protegidas por middleware de autenticación y verificación de rol.
         * Cada ruta está nombrada para facilitar su referencia en las vistas y controladores.
         * Estas rutas son accesibles solo para administradores.
         */
        Route::get('adoptions', [AdoptionController::class, 'index'])->name('adoptions.index');
        Route::get('adoptions/create', [AdoptionController::class, 'create'])->name('adoptions.create');
        Route::post('adoptions', [AdoptionController::class, 'store'])->name('adoptions.store');
        Route::get('adoptions/{id}', [AdoptionController::class, 'show'])->name('adoptions.show');
        Route::get('adoptions/{id}/edit', [AdoptionController::class, 'edit'])->name('adoptions.edit');
        Route::put('adoptions/{id}', [AdoptionController::class, 'update'])->name('adoptions.update');
        Route::delete('adoptions/{id}', [AdoptionController::class, 'destroy'])->name('adoptions.destroy');

        /**
         * Rutas para la gestión de acogidas
         * Estas rutas permiten crear, editar, eliminar y listar acogidas de animales.
         * Incluyen funcionalidades para gestionar el proceso de acogida y asignar animales a hogares de acogida.
         * Las rutas están protegidas por middleware de autenticación y verificación de rol.
         * Estas rutas son accesibles solo para administradores.
         */
        Route::get('fosters', [FosterController::class, 'index'])->name('foster.index');
        Route::get('fosters/create', [FosterController::class, 'create'])->name('foster.create');
        Route::post('fosters', [FosterController::class, 'store'])->name('foster.store');
        Route::get('fosters/{id}', [FosterController::class, 'show'])->name('foster.show');
        Route::get('fosters/{id}/edit', [FosterController::class, 'edit'])->name('foster.edit');
        Route::put('fosters/{id}', [FosterController::class, 'update'])->name('foster.update');
        Route::delete('fosters/{id}', [FosterController::class, 'destroy'])->name('foster.destroy');
   
    });