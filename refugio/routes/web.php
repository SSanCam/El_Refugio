<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
 
require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/public.php';
require __DIR__.'/email.php';

