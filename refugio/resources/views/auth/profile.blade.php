<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Usuario</title>
</head>
<body>

    <h1>Mi perfil</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Teléfono:</strong> {{ $user->phone ?? '—' }}</p>
    <p><strong>Dirección:</strong> {{ $user->address ?? '—' }}</p>
    <p><strong>Estado:</strong> {{ $user->is_active ? 'Activo' : 'Inactivo' }}</p>

    {{-- Botones de acciones --}}
    <form method="POST" action="{{ route('auth.profile.delete') }}">
        @csrf
        <button type="submit" onclick="return confirm('¿Estás segura de que deseas desactivar tu cuenta?')">Desactivar cuenta</button>
    </form>

    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>

    {{-- Adopciones activas --}}
    <h3>Adopciones activas</h3>
    <ul>
        @forelse($adoptions as $adoption)
            <li>{{ $adoption->animal->name }} - Estado: {{ $adoption->status }}</li>
        @empty
            <li>No tienes adopciones activas.</li>
        @endforelse
    </ul>

    {{-- Acogidas activas --}}
    <h3>Acogidas activas</h3>
    <ul>
        @forelse($fosters as $foster)
            <li>{{ $foster->animal->name }} - Estado: {{ $foster->status }}</li>
        @empty
            <li>No tienes acogidas activas.</li>
        @endforelse
    </ul>

</body>
</html>
