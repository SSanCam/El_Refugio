<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Perfil del usuario autenticado
Route::get('/perfil', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::patch('/perfil', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/perfil', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
