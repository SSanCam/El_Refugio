<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Incluye Bootstrap o tus estilos si no están ya cargados --}}
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Usuario</h2>

        @if(session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group mt-3">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="phone">Teléfono</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="dni">DNI</label>
                <input type="text" name="dni" id="dni" class="form-control" value="{{ old('dni', $user->dni) }}">
                @error('dni') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="role">Rol</label>
                <select name="role" id="role" class="form-control">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-check mt-3">
                <input type="checkbox" name="active" id="active" class="form-check-input" {{ old('active', $user->active) ? 'checked' : '' }}>
                <label for="active" class="form-check-label">Activo</label>
                @error('active') <br><small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4">Actualizar Usuario</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mt-4">Cancelar</a>
        </form>
    </div>
</body>
</html>
