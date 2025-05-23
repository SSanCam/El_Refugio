<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * @param Request $request Solicitud HTTP con los parámetros de búsqueda.
     * @return \Illuminate\View\View Vista del listado de usuarios.
     */
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'role' => 'nullable|in:user,admin',
            'has_adoptions' => 'nullable|boolean',
            'has_fosters' => 'nullable|boolean',
            'has_sponsorships' => 'nullable|boolean',
        ]);

        $users = $this->applyFilters($request)->paginate(10)->withQueryString();

        return view('user.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * @return \Illuminate\View\View Vista del formulario de creación de usuario.
     */
    public function create()
    {
        return view('admin.user.create');
    }

      /**
       * Almacena un nuevo usuario en la base de datos.
       * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del formulario.
       * @return \Illuminate\Http\RedirectResponse Redirige al listado con un mensaje de éxito.
       */
      public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:user,admin',
            'phone' => 'nullable|string|max:20',
            'dni' => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
        ]);

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
     * @return \Illuminate\View\View
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
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|in:user,admin',
            'phone' => 'nullable|string|max:20',
            'dni' => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
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
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Rol asignado exitosamente.');
    }


    /**
     * Aplica filtros al listado de usuarios según los parámetros de la solicitud.
     *
     * Filtra por nombre, email, rol, y relaciones activas (adopciones, acogidas, apadrinamientos).
     * Devuelve un objeto Builder con la consulta preparada para ser paginada o ejecutada.
     *
     * @param \Illuminate\Http\Request $request Solicitud con los parámetros de filtrado.
     * @return \Illuminate\Database\Eloquent\Builder Consulta con filtros aplicados.
     */

    private function applyFilters(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        if ($request->boolean('has_adoptions')) {
            $query->whereHas('adoptions');
        }

        if ($request->boolean('has_fosters')) {
            $query->whereHas('fosters');
        }

        if ($request->boolean('has_sponsorships')) {
            $query->whereHas('sponsorships');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        return $query;
    }

}