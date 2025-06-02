<?php

use App\Http\Controllers\Admin\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\UserController;
use App\Http\Controllers\Public\SponsorshipMailController;

/** 
 * =========================
 * Rutas Públicas - Animales
 * =========================
*/
Route::get('/animales', [AnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [AnimalController::class, 'show'])->name('public.animals.show');

/** 
 * ===============================
 * Rutas Públicas - Apadrinamiento
 * ===============================
*/
Route::post('/apadrinar', [SponsorshipMailController::class, 'enviarCorreoDeApadrinamiento'])->name('apadrinar.enviar');
Route::get('/apadrinar', function () {
    return view('public.animal.sponsorshipForm');
})->name('apadrinar.index');
/** 
 * =========================================
 * Rutas Públicas - Registro y Autenticación
 * =========================================
*/
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::get('/login', [UserController::class, 'logIn'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');