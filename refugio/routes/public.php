<?php

use App\Http\Controllers\Admin\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\SponsorshipRequestController;

// Rutas públicas para ver animales
Route::get('/animales', [AnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [AnimalController::class, 'show'])->name('public.animals.show');

// Rutas publicas para apadrinamientos
Route::get('/apadrinar/{animal}', [SponsorshipRequestController::class, 'create'])->name('public.sponsorshipRequest.create');
Route::post('/apadrinar', [SponsorshipRequestController::class, 'store'])->name('public.sponsorshipRequest.store');