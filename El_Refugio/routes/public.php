<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\AnimalController;
use App\Http\Controllers\Public\FormController;

// -----------------------------
// Animales públicos
// -----------------------------
Route::get('/peludos', [AnimalController::class, 'index'])
    ->name('public.animals.index');
// -----------------------------
// Listado y ficha de animales
// -----------------------------
Route::get('/peludo/{id}', [AnimalController::class, 'show'])
    ->name('public.animals.show');

// -----------------------------
// Listado de perros que han sido adoptados
// -----------------------------
Route::get('/finales-felices', [AnimalController::class, 'happyEndings'])
->name('public.animals.happy');

// -----------------------------
// Formularios públicos
// -----------------------------
Route::view('/contacto', 'public.forms.contact')->name('public.forms.contact');
Route::view('/solicitud', 'public.forms.request')->name('public.forms.request');