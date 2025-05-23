<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\NoDataFound;;

/**
 * Controlador para gestionar los usuarios del sistema.
 * Incluye operaciones básicas CRUD, gestión administrativa,
 * funcionalidades del perfil de usuario y seguridad.
 */
class UserController extends Controller
{
    // CRUD básico para la gestión de usuarios

    /**
     * Muestra un listado paginado de usuarios, paginados 10 usuarios por página.
     * 
     * @return \Illuminate\View\View Vista del listado de usuarios.
     */
    public function index(Request $request)
    {
        try{

            $users = \App\Models\User::paginate(10);

            if ($users->isEmpty()) {
            session()->flash('info', 'No hay usuarios registrados aún.');
            }
            
            return view('user.index', data: compact('users'));

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al obtener los usuarios.');
            return view('user.index', ['users' => collect()]);
        }

    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * @return \Illuminate\View\View Vista del formulario de creación de usuario.
     */
    public function create()
    {
        try {
            return view('admin.user.create');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al mostrar el formulario de creación.');
            return redirect()->route('users.index');
        }
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del formulario.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
                'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Validación regex para el emmail: empezar por letra, contener "@" y un dominio válido
            ],
            'password' => [
                'required',
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

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \App\Models\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'phone' => $request->input('phone'),
            'dni' => $request->input('dni'),
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra los detalles de un usuario específico.
     * @param string $id ID del usuario a mostrar.
     * @return \Illuminate\View\View Vista de los detalles del usuario.
     */
    public function show(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar un usuario.
     * @param string $id ID del usuario a editar.
     * @return \Illuminate\View\View Vista del formulario de edición de usuario.
     */
    public function edit(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * Valida y procesa los datos recibidos desde el formulario de edición,
     * actualiza únicamente los campos modificados, y encripta la contraseña si se ha cambiado.
     *
     * @param Request $request La solicitud HTTP con los datos del formulario.
     * @param string $id ID del usuario a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado con un mensaje de éxito.
     */
    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
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

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario del sistema.
     * @param string $id ID del usuario a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios.
     */
    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Evitar autodesactivado
        if ($user->id === Auth::user()->id) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Evitar eliminación si tiene relaciones activas
        if ($user->adoptions()->exists() || $user->fosters()->exists() || $user->sponsorships()->exists()) {
            return redirect()->route('users.index')
                ->with('error', 'Este usuario tiene procesos activos y no puede ser eliminado.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    // Funcionalidades de gestión administrativa de usuarios

    /**
     * Asigna o modifica el rol de un usuario.
     * @param Request $request La solicitud con el nuevo rol.
     * @param string $id ID del usuario a modificar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios.
     */
    public function assignRole(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update(['role' => $request->input('role')]);

        return redirect()->route('users.show', $user->id)->with('success', 'Rol asignado exitosamente.');
    }


    /**
     * Activa un usuario en el sistema.
     * @param string $id ID del usuario a activar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios.
     */
    public function activateUser(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->active = true;
        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Usuario activado exitosamente.');
    }


    /**
     * Desactiva un usuario en el sistema.
     * @param string $id ID del usuario a desactivar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios.
     */
    public function deactivateUser(string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Evitar desactivarse a sí mismo
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $user->update(['active' => false]);

        return redirect()->route('users.show', $user->id)->with('success', 'Usuario desactivado exitosamente.');
    }

}