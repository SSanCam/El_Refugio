<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

Route::middleware(['auth', 'verified'])
        ->prefix('auth')
        ->name('auth.')
        ->group(function () {

    Route::get('/perfil', [UserController::class, 'showProfile'])->name('profile');   
    Route::get('/editar', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/actualizar', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::post('/logout', [UserController::class, 'logOut'])->name('logout');
    Route::post('/eliminar-cuenta', [UserController::class, 'deleteAccount'])->name('profile.delete');

    Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('user.changePasswordForm');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');

});