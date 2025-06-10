<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     */
    public function index()
        {
            $users = User::paginate(10);

            return view('admin.user.index', compact('users'));
        }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * 
     * @return \Illuminate\View\View| \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del formulario.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirige al listado con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email:rfc,dns|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',     // al menos una mayúscula
                'regex:/[0-9]/',     // al menos un número
                'regex:/[@$!%*?&]/',  // al menos un carácter especial
            ],
            'role'     => 'nullable|in:' . UserRole::USER->value . ',' . UserRole::ADMIN->value,
            'phone'    => 'nullable|string|max:20',
            'dni'      => 'nullable|string|max:20',
            'active'   => 'sometimes|boolean',
        ], [
            'email.unique'    => 'Ya existe un usuario con ese correo electrónico.',
            'password.regex'  => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
            'active.boolean'  => 'El estado activo debe ser verdadero o falso.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['active']   = $request->boolean('active', false);
        $validated['role']     = $validated['role'] ?? UserRole::USER->value;

        try {
                User::create($validated);

                return redirect()
                ->route('admin.user.index')
                ->with('success', 'Usuario creado exitosamente.');

           } catch (QueryException $e) {
                Log::error('Error en base de datos al crear usuario: ' . $e->getMessage());
                return redirect()
                ->back()
                ->with('error', 'Error al guardar en la base de datos.')->withInput();

            } catch (Exception $e) {
                Log::error('Error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
            }
        
    }

    /**
     * Muestra los detalles de un usuario específico.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Si tuvieras autorización más fina, podrías hacer $this->authorize('view', $user);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar un usuario.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User          $user
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Database\QueryException
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'    => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',    // al menos una mayúscula
                'regex:/[0-9]/',    // al menos un número
                'regex:/[@$!%*?&]/' // al menos un símbolo especial
            ],
            'role'     => 'nullable|in:' . UserRole::USER->value . ',' . UserRole::ADMIN->value,
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
            $validated['password'] = HasH::make(value: $validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['active'] = $request->boolean('active', false);
        $validated['role']   = $validated['role'] ?? UserRole::USER->value;

        try {

            $user->update(array_filter($validated, fn($value) => !is_null($value)));

            return redirect()
                ->route('admin.user.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (QueryException $e) {
            Log::error('Error en base de datos al actualizar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar en la base de datos.')->withInput();
        }catch (Exception $e) {
            Log::error('Error general al actualizar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
        
    }

    /**
     * Elimina o desactiva un usuario según relaciones activas.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Database\QueryException
     */
    public function destroy(User $user)
    {
        // Evitar autodesactivado de un admionistrador
        if ($user->id === Auth::user()->id) {
            return redirect()
            ->route('admin.user.index')
            ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        try {
            // Evitar eliminación si tiene relaciones activas
            if ($user->adoptions()->exists() || $user->fosters()->exists() || $user->sponsorships()->exists()) {
                $user->active = false; // Desactivar en lugar de eliminar
                $user->save();
                return redirect()->route('admin.user.index')
                    ->with('error', 'Este usuario tiene procesos activos y no puede ser eliminado.');
            }

            $user->delete();

            return redirect()
            ->route('admin.user.index')
            ->with('success', 'Usuario eliminado exitosamente.');
        
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User          $user
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Database\QueryException
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in' . UserRole::USER ->value . ',' . UserRole::ADMIN->value,
        ]);

        try {

            $user->update(['role' => $request->input('role')]);

            return redirect()
                ->route('admin.user.show', $user->id)
                ->with('success', 'Rol asignado exitosamente.');
        
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
     * @throws \Illuminate\Database\QueryException Si ocurre un error al guardar en la base de datos.
     * @throws \Exception Si ocurre un error inesperado durante el proceso.
     */
    public function updateActivationStatus(Request $request, User $user)
    {
        $status = $request->boolean('status');

        if (! $status && $user->role === UserRole::ADMIN->value && auth()) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        try {
            $user->update(['active' => $status]);

            $mensaje = $status ? 'Usuario activado exitosamente.' : 'Usuario desactivado exitosamente.';
            return redirect()->route('admin.user.show', $user->id)->with('success', $mensaje);

        } catch (QueryException $e) {
            Log::error('Error en base de datos al cambiar estado de usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar en la base de datos.')->withInput();
        } catch (Exception $e) {
            Log::error('Error general al cambiar estado de usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }

}