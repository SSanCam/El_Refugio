<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Grupo de rutas protegidas para administración
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('users', UserController::class);
    // Rutas para gestión de usuarios
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/activate', [UserController::class, 'activateUser'])->name('users.activate');
    Route::post('users/{user}/deactivate', [UserController::class, 'deactivateUser'])->name('users.deactivate');
});
