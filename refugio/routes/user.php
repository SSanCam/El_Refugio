<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

Route::middleware(['auth', 'verified'])
        ->prefix('auth')
        ->name('auth.')
        ->group(function () {

    // Visualización y edición de perfil
    Route::get('/perfil', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/editar', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/actualizar', [UserController::class, 'updateProfile'])->name('profile.update');

    // Cierre de sesión y eliminación de cuenta
    Route::post('/logout', [UserController::class, 'logOut'])->name('logout');
    Route::post('/eliminar-cuenta', [UserController::class, 'deleteAccount'])->name('profile.delete');

    // Cambio de contraseña
    Route::get('/cambiar-password', [UserController::class, 'changePasswordForm'])->name('changePassword.form');
    Route::post('/cambiar-password', [UserController::class, 'changePassword'])->name('changePassword.update');
});