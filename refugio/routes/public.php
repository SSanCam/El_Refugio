<?php

use App\Http\Controllers\Admin\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\UserController;

// Rutas públicas para ver animales
Route::get('/animales', [AnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [AnimalController::class, 'show'])->name('public.animals.show');

// Rutas de registro y autenticación de usuario
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::get('/login', [UserController::class, 'logIn'])->name('login');
Route::post('/login', [UserController::class, 'authenticate']);