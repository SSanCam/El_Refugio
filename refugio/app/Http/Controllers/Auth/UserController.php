<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\EmailNotifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Exception;

/**
 * UserController
 *
 * Controlador para manejar las operaciones relacionadas con los usuarios autenticados.
 */

class UserController extends Controller
{
    /**
     * =============================================
     * Funcionalidades de perfil y cuenta de usuario
     * =============================================
     */

    /**
     * Muestra el perfil del usuario autenticado.
     * 
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function showProfile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     * 
     * @return \Illuminate\Contracts\View\View| \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function editProfile()
    {
        try {
            return view('auth.profile.edit', ['user' => Auth::user()]);
        } catch (Exception $e) {
            Log::error('Error al mostrar el formulario de edición del perfil: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar el formulario de edición del perfil.']);
        }
    }

        /**
     * Actualiza el perfil del usuario autenticado.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function updateProfile(Request $request)
    {
        try {

            $user = User::findOrFail(Auth::id());

            $validated = $request->validate([
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'unique:users,email,' . $user->id,
                    'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'password' => [
                    'nullable',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/'
                ]
            ], [
                'email.regex' => 'El correo electrónico debe empezar con una letra, contener "@" y un dominio válido.',
                'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);

            
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
                Mail::to($user->email)->send(new EmailNotifications(
                    $user->email,
                    'Contraseña actualizada',
                    ''
                ));
            }

            if (!empty($validated['email'])) {
               $user->email = $validated['email'];
            }

            $user->update(array_filter($validated, function ($value) {
                            return !is_null($value) && $value !== '';
            }));

            if(!empty($validated['email'])) {
                Mail::to($user->email)->send(new EmailNotifications(
                    $user->email,
                    'Correo electrónico actualizado',
                    ''
                ));
            }
           
            return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente.');

        } catch (Exception $e) {
            Log::error('Error al actualizar el perfil del usuario: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al actualizar el perfil.']);
        }
    }


    /**
     * Cierra la sesión del usuario autenticado.
     *
     * @return \Illuminate\Contracts\View\View
     *
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function logOut()
    {
    
        try {
            
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
        } catch (Exception $e) {
            Log::error('Error al cerrar sesión: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cerrar sesión.']);
        }
    }

    /**
     * Elimina la cuenta del usuario autenticado.
     * 
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteAccount(Request $request)
    {
        try {

            $user = User::findOrFail(Auth::id());

            $user->is_active = false;
            $user->save();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Solicitud de eliminación de cuenta',
                ''            
            ));

            if (!$user->is_active) {
                return redirect('/')->with('info', 'Esta cuenta ya estaba desactivada.');
            } 

        } catch (Exception $e) {
            Log::error('Error al solicitar la eliminación de la cuenta: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al procesar la solicitud de eliminación de cuenta.']);
        }
    }

    /**
     * =============================================
     * Funcionalidades de seguridad y autenticación
     * =============================================
     */


    public function changePassword(Request $request)
    {
        //
    }

    public function confirmCurrentPassword(Request $request)
    {
        //
    }

    public function twoFactorAuthentication(Request $request)
    {
        //
    }
    public function enableTwoFactorAuthentication(Request $request)
    {
        //
    }

    /**
     * ===============================================
     * Funcionalidades de  Verificación y recuperación
     * ===============================================
     */


    public function verifyEmail(Request $request)
    {
        //
    }

    public function resendVerificationEmail(Request $request)
    {
        //
    }

    public function resetPassword(Request $request)
    {
        //
    }

    public function sendPasswordResetLink(Request $request)
    {
        //
    }

    /**
     * ===============================================
     * Relación con el refugio y sus servicios
     * ===============================================
     */


    public function showAdoptions(Request $request)
    {
        //
    }
    public function showFosters(Request $request)
    {
        //
    }
    public function showSponsorships(Request $request)
    {
        //  
    }
}