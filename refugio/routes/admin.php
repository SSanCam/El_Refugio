<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    // GET
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

        // POST
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
        Route::post('users/{user}/activate', [UserController::class, 'activateUser'])->name('users.activate');
        Route::post('users/{user}/deactivate', [UserController::class, 'deactivateUser'])->name('users.deactivate');

        // PUT
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

        // DELETE
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   
    });