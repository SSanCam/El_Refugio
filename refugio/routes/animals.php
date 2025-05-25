<?php

use App\Http\Controllers\Admin\AnimalController;
use Illuminate\Support\Facades\Route;

Route::get('/animales', [AnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [AnimalController::class, 'show'])->name('public.animals.show');
