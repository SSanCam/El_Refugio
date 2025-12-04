<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\AnimalController;
use App\Http\Controllers\Public\FormController;

// -----------------------------
// Animales públicos
// -----------------------------
Route::get('/peludos', [AnimalController::class, 'index'])->name('public.animals.index');

// -----------------------------
// Listado y ficha de animales
// -----------------------------
Route::get('/peludo/{id}', [AnimalController::class, 'show'])->name('public.animals.show');

// -----------------------------
// Listado de perros que han sido adoptados
// -----------------------------
Route::get('/finales-felices', [AnimalController::class, 'happyEndings'])->name('public.animals.happy');

// -----------------------------
// Formularios públicos
// -----------------------------

// Formulario de contacto
Route::get('/contacto', [FormController::class, 'contact'])->name('public.forms.contact');
Route::post('/contacto', [FormController::class, 'sendContact'])->name('public.forms.contact.send');

// Formulario de solicitud de adopción o acogida
Route::get('/solicitud', [FormController::class, 'request'])->name('public.forms.request');
Route::post('/solicitud', [FormController::class, 'sendRequest'])->name('public.forms.request.send');
