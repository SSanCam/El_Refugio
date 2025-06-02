<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/perfil', [UserController::class, 'showProfile'])->name('user.profile');
    
});