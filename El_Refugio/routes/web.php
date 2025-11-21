<?php

use Illuminate\Support\Facades\Route;
/*
// Rutas públicas con limitación de tasa
Route::middleware(['throttle:120,1'])->group(function () {

    // Ruta principal pública
    Route::get('/', function () {
        return view('welcome');
    });

    // Otras rutas públicas
    require __DIR__.'/public.php';
});

// Rutas públicas sin logueo, auth está protegida por defecto
require __DIR__.'/auth.php';

// Rutas de usuario autenticado
Route::middleware(['auth', 'verified', 'throttle:100,1'])->group(function () {
    require __DIR__.'/user.php';
});

// Rutas de administración (solo admin)
Route::middleware(['auth', 'verified', 'admin', 'throttle:200,1'])->group(function () {
    require __DIR__.'/admin.php';
});
*/