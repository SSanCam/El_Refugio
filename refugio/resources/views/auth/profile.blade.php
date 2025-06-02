<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <h1>Perfil del usuario</h1>

    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Mi perfil</h2>

        {{-- Mensajes de éxito --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Mensajes de error --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Mostrar información del usuario --}}
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Alias:</strong> {{ $user->alias ?? '—' }}</p>
                <p><strong>Teléfono:</strong> {{ $user->phone ?? '—' }}</p>
                <p><strong>Dirección:</strong> {{ $user->address ?? '—' }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($user->status) }}</p>
            </div>
        </div>

        {{-- Botones de acciones --}}
        <div>
            <a href="{{ route('user.deactivate') }}" class="btn btn-outline-danger"
                onclick="return confirm('¿Estás segura de que deseas desactivar tu cuenta?')">
                Desactivar cuenta
            </a>

            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">Cerrar sesión</button>
            </form>
        </div>
    </div>
    @endsection

</body>

</html>