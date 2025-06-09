<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

Route::middleware(['auth'])
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {

    // Perfil del usuario
    Route::get('/perfil', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/perfil/editar', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/perfil/actualizar', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/perfil/eliminar', [UserController::class, 'deleteAccount'])->name('profile.delete');

    // Seguridad: contraseña
    Route::get('/password', [UserController::class, 'changePasswordForm'])->name('changePassword.form');
    Route::post('/password', [UserController::class, 'changePassword'])->name('changePassword.update');

    // Cierre de sesión
    Route::post('/logout', [UserController::class, 'logOut'])->name('logout');
});
