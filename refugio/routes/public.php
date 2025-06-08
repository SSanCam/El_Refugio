<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Public\FormController;
use App\Http\Controllers\Public\UserController;

/**
 * Rutas Públicas del Refugio
 * Estas rutas son accesibles sin autenticación y permiten a los usuarios interactuar con el refugio.
 */
Route::middleware(['throttle:5,1'])
    ->prefix('public')
    ->name('public.')
    ->group(function () {
    /** 
     * =========================
     * Rutas Públicas - Animales
     * =========================
    */
    Route::prefix('animal')
        ->name('animal.')
        ->group(function () {

    Route::get('/', [AnimalController::class, 'index'])->name('index');
    Route::get('/{id}', [AnimalController::class, 'show'])->name('show');

    Route::get('/{id}/adoptar', function ($id) {return view('adoptForm', ['animalId' => $id]);})->name('adopt');
    Route::get('/{id}/acoger', function ($id) {return view('fosterForm', ['animalId' => $id]);})->name('foster');
    Route::get('/{id}/apadrinar', function ($id) {return view('sponsorshipForm', ['animalId' => $id]);})->name('sponsor');

        });
        
    /** 
     * =========================
     * Rutas Públicas - Usuarios
     * =========================
    */
    Route::prefix('user')
        ->name('user.')
        ->group(function () {

        Route::get('/register', [UserController::class, 'register'])->name('register');
        Route::post('/register', [UserController::class, 'store'])->name('register.store');

        Route::get('/login', [UserController::class, 'logIn'])->name('login');
        Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');

    });
    /**
     * ============================
     * Rutas Públicas - Formularios
     * ============================
     */
    Route::prefix('forms')
        ->name('forms.')
        ->group(function () {

        Route::get('/contacto', [FormController::class, 'contact'])->name('contact');
        Route::post('/contacto', [FormController::class, 'sendContact'])->name('contact.submit');

        Route::get('/adopcion', [FormController::class, 'adoptionForm'])->name('adoption');
        Route::post('/adopcion', [FormController::class, 'sendAdoptionForm'])->name('adoption.submit');

        Route::get('/acogida', [FormController::class, 'fosterForm'])->name('foster');
        Route::post('/acogida', [FormController::class, 'sendFosterForm'])->name('foster.submit');

        Route::get('/apadrinamiento', [FormController::class, 'sponsorshipForm'])->name('sponsorship');
        Route::post('/apadrinamiento', [FormController::class, 'sendSponsorshipForm'])->name('sponsorship.submit');

        Route::get('/voluntariado', [FormController::class, 'volunteerForm'])->name('volunteer');
        Route::post('/voluntariado', [FormController::class, 'sendVolunteerForm'])->name('volunteer.submit');
    });

});