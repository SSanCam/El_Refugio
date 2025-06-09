<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;    
use App\Mail\EmailNotifications;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;

/**
 * UserController
 *
 * Controlador para manejar las operaciones relacionadas con los usuarios no autenticados.
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
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\QueryException
     * @throws \Exception
     */
    public function store()
    {

        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^[A-Za-z\d@$!%*?&]+$/'],
        ]);

         try {

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            
            Mail::to($user->email)->send(new EmailNotifications(
                $user->email,
                'Cuenta creada'
            ));

            return redirect()->route('public.user.login')->with('success', 'Usuario registrado exitosamente.');

        } catch (QueryException $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'El correo ya está en uso o ha ocurrido un error inesperado.',
            ])->withInput();
        } catch (Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Ha ocurrido un error inesperado. Por favor, inténtalo de nuevo más tarde.',
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
     * Muestra el panel administrativo
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('admin.dashboard');
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

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenida, administradora.');
            }

            return redirect()->route('auth.profile')->with('success', 'Has iniciado sesión correctamente.');
        }

        return back()->withErrors(['email' => 'Las credenciales no son válidas.'])->onlyInput('email');
    }

} 