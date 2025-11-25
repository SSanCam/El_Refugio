<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\AnimalController;
use App\Http\Controllers\Public\FormController;

// -----------------------------
// Animales públicos
// -----------------------------

Route::get('/peludos', [AnimalController::class, 'index'])
    ->name('public.animals.index');

Route::get('/peludo/{id}', [AnimalController::class, 'show'])
    ->name('public.animals.show');