<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion de usuario</title>
</head>

<body>

    @section('content')
    <div class="container mt-4">
        <h2>Detalles del Usuario</h2>

        @if(session('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Nombre:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Rol:</strong> {{ $user->role }}</p>
                <p><strong>Teléfono:</strong> {{ $user->phone ?? 'No proporcionado' }}</p>
                <p><strong>DNI:</strong> {{ $user->dni ?? 'No proporcionado' }}</p>
                <p><strong>Estado:</strong> {{ $user->active ? 'Activo' : 'Inactivo' }}</p>
                <p><strong>Fecha de creación:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
    </div>
</body>

</html>