<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/**
 * =====================================
 * Rutas públicas para verificación de email
 * =====================================
 */
Route::middleware(['auth', 'throttle:6,1']) // Limita a 6 solicitudes por minuto
    ->prefix('email')
    ->name('verification.')
    ->group(function () {

   
// Página que solicita verificación
Route::get('/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Enlace de verificación clicado en email
Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // marca el email como verificado
    return redirect('/'); // redirige tras verificación
})->middleware(['auth', 'signed'])->name('verification.verify');

// Reenviar verificación
Route::post('/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Correo de verificación reenviado.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

});