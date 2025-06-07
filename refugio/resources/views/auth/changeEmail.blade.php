<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar email</title>
</head>
<body>
    <h1>Cambiar dirección de correo</h1>

    {{-- Éxito --}}
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Errores --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form method="POST" action="{{ route('user.changeEmail') }}">
        @csrf

        <label for="new_email">Nuevo correo electrónico:</label><br>
        <input type="email" name="new_email" id="new_email" required><br><br>

        <label for="password">Contraseña actual:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Actualizar correo</button>
    </form>
</body>
</html>
