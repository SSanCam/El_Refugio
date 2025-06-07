<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
</head>

<body>
    <h1>Mi perfil</h1>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div style="color: green; border: 1px solid green; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Información del usuario --}}
    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Teléfono:</strong> {{ $user->phone ?? '—' }}</p>
        <p><strong>Dirección:</strong> {{ $user->address ?? '—' }}</p>
        <p><strong>Estado:</strong> {{ $user->is_active ? 'Activo' : 'Inactivo' }}</p>
    </div>

    {{-- Acciones --}}
    <div>
        <form method="POST" action="{{ route('user.deleteAccount') }}" style="display: inline;">
            @csrf
            <button type="submit" onclick="return confirm('¿Estás segura de que deseas desactivar tu cuenta?')">Desactivar cuenta</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 10px;">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </div>
</body>

</html>
