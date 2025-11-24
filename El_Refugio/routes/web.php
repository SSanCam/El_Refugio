<?php

use Illuminate\Support\Facades\Route;

// Landing pública
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
/*
// Rutas de autenticación (públicas)
require __DIR__.'/auth.php';

// Rutas públicas (home, animales, formularios...)
Route::middleware(['throttle:120,1'])->group(function () {
    require __DIR__.'/public.php';
});

// Rutas del usuario autenticado
Route::middleware(['auth', 'verified', 'throttle:100,1'])->group(function () {
    require __DIR__.'/user.php';
});

// Rutas exclusivas de administración
Route::middleware(['auth', 'verified', 'admin', 'throttle:200,1'])->group(function () {
    require __DIR__.'/admin.php';
});
*/