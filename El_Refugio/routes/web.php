<?php

use Illuminate\Support\Facades\Route;

// -----------------------------
// Página de inicio pública
// -----------------------------
Route::get('/', function () {
    return view('public.home');
})->name('public.home');


// Carga de archivos de rutas adicionales
//require __DIR__.'/public.php';
//require __DIR__.'/admin.php';
//require __DIR__.'/auth.php';
//require __DIR__.'/user.php';