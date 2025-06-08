<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/**
 * =====================================
 * RUTAS PÚBLICAS PARA VERIFICACIÓN DE EMAIL
 * =====================================
 */
Route::middleware(['auth', 'throttle:6,1'])
    ->prefix('email')
    ->name('verification.')
    ->group(function () {

        // Muestra la vista que solicita al usuario verificar su correo electrónico
        Route::get('/verify', fn() => view('auth.verify-email'))->middleware('auth')->name('notice');

        // Procesa el enlace de verificación recibido por email y marca el correo como verificado
        Route::get('/verify/{id}/{hash}', fn(EmailVerificationRequest $request) => tap($request)->fulfill() && redirect('/'))
            ->middleware(['auth', 'signed'])
            ->name('verify');

        // Reenvía el correo de verificación al usuario autenticado
        Route::post('/verification-notification', fn(Request $request) => tap($request->user())->sendEmailVerificationNotification() && back()->with('message', 'Correo de verificación reenviado.'))
            ->name('send');
    });
