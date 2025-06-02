<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
</head>

<body>
    <h1>Crea una cuenta</h1>

    @extends('layouts.app') 

    @section('content')
    <div class="container">
        <h2>Registro de usuario</h2>

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Mensaje de éxito --}}
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name">Nombre completo</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Registrarse</button>

            <p class="mt-3">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </form>
    </div>
    @endsection

</body>

</html>