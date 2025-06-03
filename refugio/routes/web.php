<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
 
require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/public.php';

use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Esto es un correo de prueba desde El Refugio.', function ($message) {
        $message->to('test@example.com')
                ->subject('Correo de prueba');
    });

    return 'Correo enviado correctamente.';
});
