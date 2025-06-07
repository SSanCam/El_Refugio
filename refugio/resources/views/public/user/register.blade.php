{{-- resources/views/public/user/register.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
</head>

<body>
    <h1>Crea una cuenta</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('public.user.register.store') }}">
        @csrf

        <label for="name">Nombre completo:</label><br>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required><br><br>

        <label for="email">Correo electrónico:</label><br>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirmation">Confirmar contraseña:</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" required><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('public.user.login') }}">Inicia sesión</a></p>
</body>

</html>
