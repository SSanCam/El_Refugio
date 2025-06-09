<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sponsorship;
use App\Models\Adoption;
use App\Models\Foster;
use App\Mail\EmailNotifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

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
        $user = Auth::user();

        /*
        $adoptions = Adoption::with('animal')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'rejected')
            ->get();

        $fosters = Foster::with('animal')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'fostering'])
            ->get();
        */
        $user = Auth::user();
        $adoptions = $user->adoptions ?? [];
        $fosters = $user->fosters ?? [];
        return view('auth.profile', compact('user', 'adoptions', 'fosters'));
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

            return redirect('/')->with('success', 'Tu cuenta ha sido desactivada.');

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


    public function changePasswordForm(Request $request)
    {
        return view('auth.changePasswordForm', ['user' => Auth::user()]);
    }

    public function changePassword(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::id());

            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/'
                ]
            ], [
                'new_password.regex' => 'La nueva contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
                'new_password.confirmed' => 'Las contraseñas no coinciden.',
            ]);

            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }

            if (Hash::check($validated['new_password'], $user->password)) {
                return redirect()->back()->withErrors(['new_password' => 'La nueva contraseña no puede ser igual a la actual.']);
            }

            $user->password = bcrypt($validated['new_password']);
            $user->save();

            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Contraseña actualizada',
                ''
            ));

            Auth::logoutOtherDevices($validated['current_password']);
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('profile.show')->with('success', 'Contraseña actualizada correctamente.');
        } catch (Exception $e) {
            Log::error('Error al validar la contraseña actual: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Contraseña actual incorrecta.']);
        }
    }

    /**
     * Habilita la autenticación de dos factores para el usuario autenticado.
     *
     * @param \Illuminate\Http\Request $request
     * 
     */
    public function enableTwoFactorAuthentication(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::id());
            $user->two_factor_expires_at = now()->addMinutes(5);
            // Generar código aleatorio de 6 dígitos
            $code = random_int(100000, 999999);
            $user->two_factor_enabled = true;
            $user->two_factor_code = $code;
            $user->save();

            // Enviar email con el código 2FA
            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Código de verificación 2FA',
                (string) $code
            ));

            
            return response()->json(['message' => 'Autenticación en dos pasos habilitada con éxito.',], 200);
        
        } catch (Exception $e) {
            Log::error('Error al habilitar la autenticación de dos factores: ' . $e->getMessage());
            return response()->json(['error' => 'Error al habilitar la autenticación de dos factores.'], 500);
        }
    }

    /**
     * Muestra el formulario para la autenticación de dos factores.
     *
     * @return \Illuminate\Contracts\View\View
     */
   
    public function twoFactorAuthentication()
    {
        return view('2fa');
    }

    /**
     * Verifica el código de autenticación de dos factores ingresado por el usuario.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyTwoFactorCode(Request $request)
    {
        
        try{
            $request->validate([
                'two_factor_code' => 'required|string',
            ]);

            $user = User::findOrFail(Auth::id());
        

            if ($user->two_factor_code !== $request->input('two_factor_code')) {
                return redirect()->back()->withErrors(['two_factor_code' => 'El código de verificación es incorrecto.']);
            }

            if (now()->greaterThan($user->two_factor_expires_at)) {
              return redirect()->back()->withErrors(['two_factor_code' => 'El código ha expirado. Solicita uno nuevo.']);
            }

            $user->two_factor_code = null;
            $user->save();

            return redirect()->route('profile.show')->with('success', 'Verificación en dos pasos completada con éxito.');

        } catch (Exception $e) {
            Log::error('Error al verificar el código de autenticación de dos factores: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al verificar el código de autenticación de dos factores.']);
        }
    
    }

    /**
     * ===============================================
     * Funcionalidades de  Verificación y recuperación
     * ===============================================
     */


    /**
     * Summary of verifyEmail
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function verifyEmail(Request $request)
    {
        try {
            $user = User::findOrFail($request->user()->id);

            if (!hash_equals($user->email_verification_code, $request->input('code'))) {
                return redirect()->back()->withErrors(['code' => 'El código de verificación es incorrecto.']);
            }

            if($user->email_verified_at) {
                return redirect()->route('profile.show')->with('info', 'Tu correo electrónico ya ha sido verificado.');
            }

            $user->markEmailAsVerified();

            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Email verificado',
                ''
            ));

            return redirect()->route('profile.show')->with('success', 'Correo electrónico verificado correctamente.');

        } catch (Exception $e) {
            Log::error('Error al verificar el correo electrónico: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al verificar el correo electrónico.']);
        }
    }

    /**
     * Summary of resendVerificationEmail
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function resendVerificationEmail(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::id());

            if ($user->email_verified_at) {
                return redirect()->route('profile.show')->with('info', 'Tu correo electrónico ya ha sido verificado.');
            }

            $user->email_verification_code = bin2hex(random_bytes(16));
            $user->save();

            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Nueva verificación de correo electrónico',
                $user->email_verification_code
            ));

            return redirect()->route('profile.show')->with('success', 'Correo electrónico de verificación enviado correctamente.');

        } catch (Exception $e) {
            Log::error('Error al reenviar el correo electrónico de verificación: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al reenviar el correo electrónico de verificación.']);
        }
    }

    /**
     * Muestra el formulario para restablecer la contraseña.
     * 
     * @return \Illuminate\Contracts\View\View| \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function resetPassword()
    {
        try {
            return view('auth.resetPassword');
        } catch (Exception $e) {
            Log::error('Error al mostrar el formulario de restablecimiento de contraseña: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar el formulario de restablecimiento de contraseña.']);
        }
    }

    /**
     * Envía un enlace para restablecer la contraseña al correo electrónico del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception
     */
    public function sendPasswordReset(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', $request->input('email'))->firstOrFail();
            
            $newPassword = bin2hex(random_bytes(10));
            $user->password = Hash::make($newPassword);
            $user->save();

            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Restablecimiento de contraseña',
                $newPassword
            ));

            return redirect()->route('login')->with('success', 'Se ha enviado un enlace para restablecer la contraseña a tu correo electrónico.');

        } catch (Exception $e) {
            Log::error('Error al enviar el enlace de restablecimiento de contraseña: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al enviar el enlace de restablecimiento de contraseña.']);
        }
    }

  
}