# UserController (Panel de Administración)

Controlador responsable de gestionar usuarios desde el panel de administración.  
Incluye funciones CRUD, asignación de roles, activación y desactivación de cuentas, y filtros personalizados.

## Ruta del archivo

[Admin > UserController.php](../../app/Http/Controllers/Admin/UserController.php)

---

## Métodos principales

### index(Request $request)

Muestra un listado paginado de usuarios con filtros.

Por orden, éstos filtros son: 
- Por nombre
- Por email
- Si tiene adopciones activas
- Si tiene acogidas activas
- Si tiene un apadrinamiento activo
- Por **rol** de usuario.

Todo mostrado con un paginado de 10 usuarios.

```php
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

    $users = $query->paginate(10)->withQueryString();

    return view('user.index', compact('users'));
}
```

---

### create()

Muestra el formulario para crear un nuevo usuario.

```php
public function create()
{
    return view('admin.user.create');
}
```

---

### store(Request $request)

Valida y guarda un nuevo usuario en la base de datos.  
Este método es exclusivo del panel de administración. Los campos opcionales como `role`, `phone`, `dni` y `active` pueden omitirse.

```php
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
```

---

### show(string $id)

Muestra los detalles completos de un usuario.

```php
public function show(string $id)
{
    $user = \App\Models\User::findOrFail($id);
    return view('admin.user.show', compact('user'));
}
```

---

### edit(string $id)

Carga la vista del formulario de edición de usuario.

```php
public function edit(string $id)
{
    $user = \App\Models\User::findOrFail($id);
    return view('admin.user.edit', compact('user'));
}
```

---

### update(Request $request, string $id)

Actualiza los datos de un usuario. Si se modifica la contraseña, se encripta.

```php
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

    if (!empty($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update(array_filter($validated, fn($value) => !is_null($value)));

    return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
}
```

---

### destroy(string $id)

Elimina un usuario

* Un usuario **Admin** puede eliminar a cualquier usuario (que no tenga procesos abiertos), excepto a sí mismo.


```php
public function destroy(string $id)
{
    $user = \App\Models\User::findOrFail($id);

    if ($user->id === \Auth::id()) {
        return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
    }

    if ($user->adoptions()->exists() || $user->fosters()->exists() || $user->sponsorships()->exists()) {
        return redirect()->route('users.index')
            ->with('error', 'Este usuario tiene procesos activos y no puede ser eliminado.');
    }

    $user->delete();

    return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
}
```

---

## Funciones administrativas

### assignRole(Request $request, string $id)

Asigna un nuevo rol (`user` o `admin`) al usuario especificado.

```php
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
```

