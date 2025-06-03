<?php

use App\Http\Controllers\Admin\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\UserController;

/** 
 * =========================
 * Rutas Públicas - Animales
 * =========================
*/
Route::get('/animales', [AnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [AnimalController::class, 'show'])->name('public.animals.show');

Route::get('/animales/{id}/adoptar', function ($id) {return view('public.animal.adoptForm', ['animalId' => $id]);})->name('public.animals.adopt');
Route::get('/animales/{id}/acoger', function ($id) {return view('public.animal.fosterForm', ['animalId' => $id]);})->name('public.animals.foster');
Route::get('/animales/{id}/apadrinar', function ($id) {return view('public.animal.sponsorshipForm', ['animalId' => $id]);})->name('public.animals.sponsor');

/** 
 * =========================================
 * Rutas Públicas - Usuarios
 * =========================================
*/
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::get('/login', [UserController::class, 'logIn'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');

Route::get('/contacto', [UserController::class, 'contact'])->name('contact.form');
Route::post('/contacto', [UserController::class, 'sendContact'])->name('contact.send');



