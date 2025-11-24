<?php

use App\Http\Controllers\Admin\AnimalController;
use Illuminate\Support\Facades\Route;

Route::get('/peludos', [AnimalController::class, 'index'])
    ->name('public.animals.index');

Route::get('/peludos/{id}', [AnimalController::class, 'show'])
    ->name('public.animals.show');
