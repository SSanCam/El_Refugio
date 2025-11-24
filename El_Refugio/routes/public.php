<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\AnimalController as PublicAnimalController;
use App\Http\Controllers\Public\PublicFormController as PublicFormController;
use App\Models\Animal;

// Listado público de animales disponibles
Route::get('/peludos', [PublicAnimalController::class, 'index'])
    ->name('public.animals.index');

// Ficha pública de un animal concreto
Route::get('/peludos/{id}', [PublicAnimalController::class, 'show'])
    ->name('public.animals.show');

// Formulario de adopción
Route::get('/adoptar', [PublicFormController::class, 'adoptionForm'])
    ->name('public.forms.adoption');
Route::post('/adoptar', [PublicFormController::class, 'sendAdoptionForm'])
    ->name('public.forms.adoption.send');

// Formulario de acogida
Route::get('/acoger', [PublicFormController::class, 'fosterForm'])
    ->name('public.forms.foster');
Route::post('/acoger', [PublicFormController::class, 'sendFosterForm'])
    ->name('public.forms.foster.send');

// Formulario de contacto
Route::get('/contacto', [PublicFormController::class, 'contact'])
    ->name('public.forms.contact');
Route::post('/contacto', [PublicFormController::class, 'sendContact'])
    ->name('public.forms.contact.send');

Route::get('/prueba-animal', function () {
    $animal = Animal::with('images')->first();
    return view('welcome', compact('animal'));
});