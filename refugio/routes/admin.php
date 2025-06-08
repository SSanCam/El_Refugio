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
Route::middleware(['auth', 'is_admin', 'throttle:5,1'])
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
        Route::prefix('user')
            ->name('user.')
            ->group(function () {

            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::post('', [UserController::class, 'store'])->name('store');
            Route::post('/{user}/assign-role', [UserController::class, 'assignRole'])->name('assignRole');
            Route::patch('/{user}/toggle/{status}', [UserController::class, 'updateActivationStatus'])->name('toggleActive');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        /**
         * Rutas para la gestión de animales
         * Estas rutas permiten crear, editar, eliminar y listar animales en el refugio.
         * Incluyen funcionalidades para cambiar el estado de un animal y desactivarlo.
         */
        Route::prefix('animal')
            ->name('animal.')
            ->group(function () {

            Route::get('/', [AnimalController::class, 'index'])->name('index');
            Route::get('/create', [AnimalController::class, 'create'])->name('create');
            Route::post('/', [AnimalController::class, 'store'])->name('store');
            Route::get('/{id}', [AnimalController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AnimalController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AnimalController::class, 'update'])->name('update');
            Route::delete('/{id}', [AnimalController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/status', [AnimalController::class, 'changeStatus'])->name('changeStatus');
            });

        /**
         * Rutas para la gestión de adopciones
         * Estas rutas permiten crear, editar, eliminar y listar adopciones de animales.
         * Incluyen funcionalidades para gestionar el proceso de adopción y asignar animales a adoptantes.
         * Las rutas están protegidas por middleware de autenticación y verificación de rol.
         * Cada ruta está nombrada para facilitar su referencia en las vistas y controladores.
         * Estas rutas son accesibles solo para administradores.
         */
        Route::prefix('adoption')
            ->name('adoption.')
            ->group(function () {

            Route::get('/', [AdoptionController::class, 'index'])->name('index');
            Route::get('/create', [AdoptionController::class, 'create'])->name('create');
            Route::post('/', [AdoptionController::class, 'store'])->name('store');
            Route::get('/{id}', [AdoptionController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdoptionController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdoptionController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdoptionController::class, 'destroy'])->name('destroy');
        });

        /**
         * Rutas para la gestión de acogidas
         * Estas rutas permiten crear, editar, eliminar y listar acogidas de animales.
         * Incluyen funcionalidades para gestionar el proceso de acogida y asignar animales a hogares de acogida.
         * Las rutas están protegidas por middleware de autenticación y verificación de rol.
         * Estas rutas son accesibles solo para administradores.
         */
        Route::prefix('foster')
            ->name('foster.')
            ->group(function () {
                
            Route::get('/', [FosterController::class, 'index'])->name('index');
            Route::get('/create', [FosterController::class, 'create'])->name('create');
            Route::post('/', [FosterController::class, 'store'])->name('store');
            Route::get('/{id}', [FosterController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [FosterController::class, 'edit'])->name('edit');
            Route::put('/{id}', [FosterController::class, 'update'])->name('update');
            Route::delete('/{id}', [FosterController::class, 'destroy'])->name('destroy');
        });
    });