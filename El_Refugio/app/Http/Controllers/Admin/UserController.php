<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
/**
 * Controlador administrativo para la gestión de usuarios
 * Permite listar, crear, actualizar y (opcionalmente) eliminar usuarios.
 */
class UserController extends Controller
{
    /**
     * Listado de usuarios.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'        => ['required', Rule::in(['user', 'admin'])],
            'national_id' => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:255'],
            'address'     => ['nullable', 'string', 'max:255'],
            'password'    => ['nullable', 'string', 'min:8'], // si no se indica, se genera aleatoria
        ]);

        // Si no se proporciona contraseña, generar una aleatoria
        $validated['password'] = $validated['password'] ?? Str::random(16);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra los detalles de un usuario concreto.
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load(['adoptions.animal', 'fosters.animal']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar un usuario concreto.
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role'        => ['required', Rule::in(['user', 'admin'])],
            'national_id' => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:255'],
            'address'     => ['nullable', 'string', 'max:255'],
            'password'    => ['nullable', 'string', 'min:8'], // si se indica, se actualiza
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario.
     * No permite eliminar al usuario autenticado ni usuarios con historial ligado (adopciones/acogidas).
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Evitar que un admin se elimine a sí mismo
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Evitar eliminar usuarios con historial de adopciones o acogidas, en su lugar desactivarlos
        if ($user->adoptions()->exists() || $user->fosters()->exists()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'No se puede eliminar un usuario con adopciones o acogidas registradas.');
        }

        $user->update(['is_active' => false]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
