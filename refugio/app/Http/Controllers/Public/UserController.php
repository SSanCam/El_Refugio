<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;    
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * UserController
 *
 * Controlador para manejar las operaciones relacionadas con los usuarios.
 */

class UserController extends Controller
{

    /**
     * Muestra el formulario de registro de usuario.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('public.user.register');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // Lógica para almacenar un nuevo usuario
        // Validación y creación del usuario
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

         try {
            $data['password'] = Hash::make($data['password']);
            User::create($data);

            return redirect()->route('login')->with('success', 'Usuario registrado exitosamente.');
        } catch (QueryException $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'El correo ya está en uso o ha ocurrido un error inesperado.',
            ])->withInput();
        }
    }   

    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function logIn()
    {
        return view('public.user.login');
    }

    /**
     * Maneja el inicio de sesión del usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); 
            return redirect()->intended('profile')->with('success', 'Has iniciado sesión correctamente.');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.'
        ])->onlyInput('email');
    }
}