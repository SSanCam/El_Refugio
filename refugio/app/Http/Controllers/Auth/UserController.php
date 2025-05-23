<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // Funciones del perfil del usuario autenticado

    /**
     * Muestra el perfil del usuario autenticado.
     * @return void
     */
    public function showProfile()
    {
        //
    }

    /**
     * Actualiza el perfil del usuario autenticado.
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        //
    }

    /**
     * Muestra las adopciones del usuario autenticado.
     * @return void
     */
    public function myAdoptions()
    {
        //
    }

    /**
     * Muestra las acogidas del usuario autenticado.
     * @return void
     */
    public function myFosters()
    {
        //
    }

    /**
     * Muestra los apadrinamientos del usuario autenticado.
     * @return void
     */
    public function mySponsorships()
    {
        //
    }

    /**
     * Solicita la eliminación de la cuenta del usuario autenticado.
     * @return void
     */
    public function requestAccountDeletion()
    {
        //
    }

    // Funcionalidades de seguridad

    /**
     * Cambia la contraseña del usuario autenticado.
     * @param Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {
        //
    }

    /**
     * Restablece la contraseña de un usuario.
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request)
    {
        //
    }

    /**
     * Envía un enlace de restablecimiento de contraseña.
     * @param Request $request
     * @return void
     */
    public function sendPasswordResetLink(Request $request)
    {
        //
    }

    /**
     * Verifica el correo electrónico del usuario.
     * @param Request $request
     * @return void
     */
    public function verifyEmail(Request $request)
    {
        //
    }

    /**
     * Reenvía el correo de verificación al usuario.
     * @param Request $request
     * @return void
     */
    public function resendVerificationEmail(Request $request)
    {
        //
    }

    /**
     * Verifica la contraseña actual antes de cambios sensibles.
     * @param Request $request
     * @return void
     */
    public function confirmCurrentPassword(Request $request)
    {
        //
    }
}