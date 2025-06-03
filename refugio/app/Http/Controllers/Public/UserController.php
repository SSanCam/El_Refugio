<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;    
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Database\QueryException;
use Exception;

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
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\QueryException
     * @throws \Exception
     */
    public function store()
    {
        // Lógica para almacenar un nuevo usuario
        // Validación y creación del usuario
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^[A-Za-z\d@$!%*?&]+$/'],
        ]);

         try {

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $user->sendEmailVerificationNotification();

            return redirect()->route('login')->with('success', 'Usuario registrado exitosamente.');

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

    /**
     * Muestra el formulario de contacto general.
     *
     * @return \Illuminate\View\View
     * 
     */
    public function contact()
    {
        return view('public.user.contact');
    }

    /**
     * Envía un mensaje de contacto.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\QueryException
     * @throws \Exception
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:1000',
        ]);

        try {
            // Sanitiza el mensaje para evitar HTML malicioso
            $sanitizedMessage = strip_tags($validated['message']);

            Mail::raw($sanitizedMessage, function ($message) use ($validated) {
                $message->to('elrefugio@example.com')
                        ->subject('Nuevo mensaje de contacto')
                        ->from($validated['email']);
            });

            return back()->with('success', 'Mensaje enviado correctamente.');

        } catch (Exception $e) {
            Log::error('Error al enviar el mensaje de contacto: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Ha ocurrido un error al enviar el mensaje. Inténtalo de nuevo más tarde.',
            ])->withInput();
        }
    }

}