<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

/**
 * Controlador para gestionar los usuarios del sistema.
 * Incluye funcionalidades CRUD, filtrado, asignación de roles y control de estado.
 */

class UserController extends Controller
{
    /**
     * ==========================================================
     * Funcionalidades básicas de los usuarios administrativos 
     * ==========================================================
    */

    /**
     * Muestra un listado paginado de usuarios, paginados 10 usuarios por página.
     * 
     * @return \Illuminate\View\View Vista del listado de usuarios.
     * 
     * @throws \Exception Si ocurre un error al obtener los usuarios.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function index(Request $request)
        {
            try {
                $user = User::paginate(10);

                if ($user->isEmpty()) {
                    session()->flash('info', 'No hay usuarios registrados aún.');
                }

                return view('admin.user.index', compact('user'));
            } catch (Exception $e) {
                session()->flash('error', 'Ocurrió un error al obtener los usuarios.');
                return view('admin.user.index', ['user' => collect()]);
            }
        }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * 
     * @return \Illuminate\View\View| \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception Si ocurre un error al mostrar el formulario.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function create()
    {
        try {
            return view('admin.user.create');
        } catch (Exception $e) {
            session()->flash('error', 'Ocurrió un error al mostrar el formulario de creación.');
            return redirect()->route('admin.user.index')->with('error', 'Ocurrió un error al mostrar el formulario de creación.');
        }
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del formulario.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirige al listado con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'email' => [
                        'required',
                        'email:rfc,dns',
                        'unique:user,email',
                        'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Validación regex para el emmail: empezar por letra, contener "@" y un dominio válido
                    ],
                    'password' => [
                        'required',
                        'min:8',
                        'confirmed',
                    ],
                    'role' => 'nullable|in:user,admin',
                    'phone' => 'nullable|string|max:20',
                    'dni' => 'nullable|string|max:20',
                    'active' => 'nullable|boolean',
                    
                    ], [
                    
                    'name.required' => 'El nombre es obligatorio.',
                    'name.max' => 'El nombre no puede exceder los 255 caracteres.',

                    'email.required' => 'El correo electrónico es obligatorio.',
                    'email.email' => 'El correo electrónico debe tener un formato válido.',
                    'email.unique' => 'Este correo electrónico ya está registrado.',
                    'email.regex' => 'El correo electrónico debe empezar con una letra, contener "@" y un dominio válido.',

                    'password.required' => 'La contraseña es obligatoria.',
                    'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                    'password.confirmed' => 'Las contraseñas no coinciden.',

                    'role.in' => 'El rol debe ser válido (user o admin).',

                    'phone.string' => 'El teléfono debe ser un texto.',
                    'phone.max' => 'El teléfono no puede exceder los 20 caracteres.',

                    'dni.string' => 'El DNI debe ser un texto.',
                    'dni.max' => 'El DNI no puede exceder los 20 caracteres.',

                    'active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
                ]);

                $validator->after(function ($validator) use ($request) {
                    $password = $request->input('password');

                    if (!preg_match('/[A-Z]/', $password)) {
                        $validator->errors()->add('password', 'La contraseña debe contener al menos una letra mayúscula.');
                    }

                    if (!preg_match('/[0-9]/', $password)) {
                        $validator->errors()->add('password', 'La contraseña debe contener al menos un número.');
                    }

                    if (!preg_match('/[@$!%*?&]/', $password)) {
                        $validator->errors()->add('password', 'La contraseña debe contener al menos un carácter especial (@, $, !, %, *, ?, &).');
                    }
                });

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

        try {
                User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role' => $request->input('role'),
                    'phone' => $request->input('phone'),
                    'dni' => $request->input('dni'),
                    'active' => $request->has('active')
                ]);

                return redirect()->route('admin.user.index')->with('success', 'Usuario creado exitosamente.');

           } catch (QueryException $e) {
        Log::error('Error en base de datos al crear usuario: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al guardar en la base de datos.')->withInput();

            } catch (Exception $e) {
                Log::error('Error general al crear usuario: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
            }
        
    }

    /**
     * Muestra los detalles de un usuario específico.
     * 
     * @param string $id ID del usuario a mostrar.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Devuelve la vista con los detalles del usuario o redirige con un mensaje de error.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no se encuentra.
     * @throws \Exception Si ocurre un error al cargar los datos del usuario.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function show(string $id)
    {
        try {
            
            $user = User::with([
            'adoptions.animal',
            'fosters.animal',
            'sponsorships.animal'
        ])->findOrFail($id);

            return view('admin.user.show', compact('user'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Usuario no encontrado con ID: $id");
            return redirect()->route('admin.user.index')->with('error', 'El usuario no fue encontrado.');

        } catch (Exception $e) {
            Log::error('Error al mostrar detalles del usuario: ' . $e->getMessage());
            return redirect()->route('admin.user.index')->with('error', 'Ocurrió un error al cargar los datos del usuario.');
        }
    }

    /**
     * Muestra el formulario para editar un usuario.
     * 
     * @param string $id ID del usuario a editar.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Devuelve la vista del formulario de edición o redirige con un mensaje de error.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no se encuentra.
     * @throws \Exception Si ocurre un error al cargar el formulario de edición.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.user.edit', compact('user'));
        } catch (ModelNotFoundException $e) {
            Log::warning("Usuario no encontrado para edición con ID: $id");
            return redirect()->route('admin.user.index')->with('error', 'El usuario no fue encontrado.');
        } catch (Exception $e) {
            Log::error('Error al mostrar el formulario de edición: ' . $e->getMessage());
            return redirect()->route('admin.user.index')->with('error', 'Ocurrió un error al cargar el formulario de edición.');
        }
        
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * Valida y procesa los datos recibidos desde el formulario de edición,
     * actualiza únicamente los campos modificados, y encripta la contraseña si se ha cambiado.
     *
     * @param Request $request La solicitud HTTP con los datos del formulario.
     * @param string $id ID del usuario a actualizar.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirige al listado con un mensaje de éxito.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no se encuentra.
     * @throws \Illuminate\Database\QueryException Si ocurre un error al guardar en la base de datos.
     * @throws \Exception Si ocurre un error inesperado durante el proceso de actualización.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function update(Request $request, string $id)
    {
        try {

            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'unique:user,email,' . $user->id,
                    'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                ],
                'password' => [
                    'nullable',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',    // al menos una mayúscula
                    'regex:/[0-9]/',    // al menos un número
                    'regex:/[@$!%*?&]/' // al menos un símbolo especial
                ],
                'role' => 'nullable|in:user,admin',
                'phone' => 'nullable|string|max:20',
                'dni' => 'nullable|string|max:20',
                'active' => 'nullable|boolean',
            ], [
                'email.regex' => 'El correo electrónico debe empezar con una letra, contener "@" y un dominio válido.',
                'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);
            
            // Si la contraseña se cambia, se encripta, sino evita sobreescribirla.
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update(array_filter($validated, fn($value) => !is_null($value)));

            return redirect()->route('admin.user.index')->with('success', 'Usuario actualizado exitosamente.');

        } catch (QueryException $e) {
            Log::error('Error en base de datos al actualizar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar en la base de datos.')->withInput();
        } catch (ModelNotFoundException $e) {
            Log::warning("Usuario no encontrado para actualización con ID: $id");
            return redirect()->route('admin.user.index')->with('error', 'El usuario no fue encontrado.');
        } catch (Exception $e) {
            Log::error('Error general al actualizar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
        
    }

    /**
     * Elimina un usuario del sistema.
     * 
     * @param string $id ID del usuario a eliminar.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no se encuentra.
     * @throws \Illuminate\Database\QueryException Si ocurre un error al eliminar el usuario.
     * @throws \Exception Si ocurre un error inesperado durante el proceso de eliminación.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Evitar autodesactivado de un admionistrador
            if ($user->id === Auth::user()->id) {
                return redirect()->route('admin.user.index')->with('error', 'No puedes eliminar tu propia cuenta.');
            }

            // Evitar eliminación si tiene relaciones activas
            if ($user->adoptions()->exists() || $user->fosters()->exists() || $user->sponsorships()->exists()) {
                $user->active = false; // Desactivar en lugar de eliminar
                $user->save();
                Log::info("Usuario con ID $id desactivado en lugar de eliminado debido a relaciones activas.");
                return redirect()->route('admin.user.index')
                    ->with('error', 'Este usuario tiene procesos activos y no puede ser eliminado.');
            }

            $user->delete();

            return redirect()->route('admin.user.index')->with('success', 'Usuario eliminado exitosamente.');
        
        } catch (ModelNotFoundException $e) {
            Log::warning("Usuario no encontrado para eliminación con ID: $id");
            return redirect()->route('admin.user.index')->with('error', 'El usuario no fue encontrado.');
        
        } catch (QueryException $e) {
            Log::error('Error en base de datos al eliminar usuario: ' . $e->getMessage());
            return redirect()->route('admin.user.index')->with('error', 'Error al eliminar el usuario.')->withInput();
        
        } catch (Exception $e) {
            Log::error('Error general al eliminar usuario: ' . $e->getMessage());
            return redirect()->route('admin.user.index')->with('error', 'Ocurrió un error inesperado al eliminar el usuario.');
        }
        
    }

    /**
     * ==========================================================
     * Funcionalidades de gestión administrativa de usuarios
     * ==========================================================
     */

    /**
     * Asigna o modifica el rol de un usuario.
     * 
     * @param Request $request La solicitud con el nuevo rol.
     * @param string $id ID del usuario a modificar.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no se encuentra.
     * @throws \Illuminate\Database\QueryException Si ocurre un error al guardar en la base de datos.
     * @throws \Exception Si ocurre un error inesperado durante el proceso de asignación de rol.
     * @throws \Illuminate\Http\RedirectResponse Si ocurre un error, redirige al listado de usuarios con un mensaje de error.
     */
    public function assignRole(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        try {

            $user = User::findOrFail($id);
            $role = strtolower($request->input('role'));
            $user->update(['role' => $role]);
            return redirect()->route('admin.user.show', $user->id)->with('success', 'Rol asignado exitosamente.');
        
        } catch (ModelNotFoundException $e) {   
            Log::warning("Usuario no encontrado para asignación de rol con ID: $id");
            return redirect()->route('admin.user.index')->with('error', 'El usuario no fue encontrado.');
        
        } catch (QueryException $e) {
            Log::error('Error en base de datos al asignar rol: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar en la base de datos.')->withInput();
        
        } catch (Exception $e) {
            Log::error('Error general al asignar rol: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
        
    }


    /**
     * Cambia el estado de activación de un usuario.
     * 
     * @param string $id ID del usuario.
     * @param bool $status Estado deseado (true = activar, false = desactivar).
     * 
     * @return \Illuminate\Http\RedirectResponse Redirige a la vista de detalle o al listado con mensaje de estado.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no se encuentra.
     * @throws \Illuminate\Database\QueryException Si ocurre un error al guardar en la base de datos.
     * @throws \Exception Si ocurre un error inesperado durante el proceso.
     */
    public function updateActivationStatus(string $id, bool $status)
    {
        try {
            $user = User::findOrFail($id);

            if (!$status && $user->id === Auth::id()) {
                return redirect()->route('admin.user.index')->with('error', 'No puedes desactivar tu propia cuenta.');
            }

            $user->active = $status;
            $user->save();

            $mensaje = $status ? 'Usuario activado exitosamente.' : 'Usuario desactivado exitosamente.';
            return redirect()->route('admin.user.show', $user->id)->with('success', $mensaje);

        } catch (ModelNotFoundException $e) {
            Log::warning("Usuario no encontrado para cambio de estado con ID: $id");
            return redirect()->route('admin.user.index')->with('error', 'El usuario no fue encontrado.');
        } catch (QueryException $e) {
            Log::error('Error en base de datos al cambiar estado de usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar en la base de datos.')->withInput();
        } catch (Exception $e) {
            Log::error('Error general al cambiar estado de usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }


}