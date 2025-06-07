{{-- resources/views/public/user/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>

<body>
    <h2>Iniciar sesión</h2>

    {{-- Mensajes de error --}}
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

    <form method="POST" action="{{ route('public.user.login.authenticate') }}">
        @csrf

        <div>
            <label for="email">Correo electrónico</label><br>
            <input id="email" type="email" name="email" placeholder="ejemplo@correo.com" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Contraseña</label><br>
            <input id="password" type="password" name="password" placeholder="********" required>
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Recuérdame</label>
        </div>

        <button type="submit">Iniciar sesión</button>
    </form>

    <p>
        ¿No tienes cuenta? <a href="{{ route('public.user.register') }}">Regístrate aquí</a>
    </p>

    <p>
        <a href="{{ url('/') }}">Volver al inicio</a>
    </p>
</body>

</html>
