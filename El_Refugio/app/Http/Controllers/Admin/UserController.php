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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%"); // ← AÑADIDO
            })
            ->orderBy('id')
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('admin.users.index', compact('users', 'search'));
    }



    /**
     * Muestra el formulario para crear un nuevo usuario.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('admin.users.index');
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
            'password'    => ['nullable', 'string', 'min:8'], 
        ]);

        // Si el telefono está vacío o ya existe en la base de datos, asignar null
        if (empty($validated['phone']) || User::where('phone', $validated['phone'])->exists()) {
            $validated['phone'] = null;
        }
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(User $user)
    {
        return redirect()->route('admin.users.index')
                        ->with('edit_user_id', $user->id);
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
            'password'    => ['nullable', 'string', 'min:8'], 
        ]);

        // Normalizar teléfono: vacío => null
        if (empty($validated['phone'])) {
            $validated['phone'] = null;
        } else {
            // Comprobar que no esté usado por otro usuario
            $phoneExists = User::where('phone', $validated['phone'])
                ->where('id', '!=', $user->id)
                ->exists();

            if ($phoneExists) {
                return back()
                    ->withInput()
                    ->withErrors(['phone' => 'Ya existe otro usuario con este teléfono.']);
            }
        }
        
        // Si la contraseña está vacía, no actualizarla
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
        $authUser = Auth::user();
        
        // Evitar que un admin se elimine a sí mismo
        if ($authUser->id === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

    // Si tiene historial, desactivar en lugar de eliminar
            if ($user->adoptions()->exists() || $user->fosters()->exists()) {
                $user->update(['is_active' => false]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuario desactivado correctamente. Se conserva su historial.');
        }

        // Si no tiene registro de adopciones o acogidas, eliminar físicamente
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}