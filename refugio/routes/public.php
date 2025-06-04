<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Public\FormController;
use App\Http\Controllers\Public\UserController;

/**
 * Rutas Públicas del Refugio
 * Estas rutas son accesibles sin autenticación y permiten a los usuarios interactuar con el refugio.
 */
Route::prefix('public')->name('public.')->group(function () {

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
 * =========================
 * Rutas Públicas - Usuarios
 * =========================
*/
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::get('/login', [UserController::class, 'logIn'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');

/**
 * ============================
 * Rutas Públicas - Formularios
 * ============================
 */
Route::get('/contacto', [FormController::class, 'contact'])->name('public.user.contact');
Route::post('/contacto', [FormController::class, 'sendContact'])->name('public.user.contact.send');

Route::get('/adopcion', [FormController::class, 'AdoptionForm'])->name('public.animal.adoptionForm');
Route::post('/adopcion', [FormController::class, 'sendAdoptionForm'])->name('public.animal.adoptionForm.send');

Route::get('/acogida', [FormController::class, 'FosterForm'])->name('public.animal.fosterForm');
Route::post('/acogida', [FormController::class, 'sendFosterForm'])->name('public.animal.fosterForm.send');

Route::get('/apadrinamiento', [FormController::class, 'SponsorshipForm'])->name('public.animal.sponsorshipForm');
Route::post('/apadrinamiento', [FormController::class, 'sendSponsorshipForm'])->name('public.animal.sponsorshipForm.send');

Route::get('/voluntariado', [FormController::class, 'VolunteerForm'])->name('public.user.volunteerForm');
Route::post('/voluntariado', [FormController::class, 'sendVolunteerForm'])->name('public.user.volunteerForm.send');

});