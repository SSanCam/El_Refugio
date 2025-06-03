<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de bienvenida</title>
</head>

<body>
    <h1>Bienvenida</h1>

    <a href="{{ route('register') }}">
        <button>Crear cuenta</button>
    </a>

    <a href="{{ route('login') }}">
        <button>Iniciar sesión</button>
    </a>
</body>

</html>