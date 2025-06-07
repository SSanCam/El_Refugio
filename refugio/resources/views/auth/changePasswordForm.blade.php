<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar contraseña</title>
</head>
<body>
    <h1>Cambiar contraseña</h1>

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
    <form method="POST" action="{{ route('user.changePassword') }}">
        @csrf

        <label for="current_password">Contraseña actual:</label><br>
        <input type="password" name="current_password" id="current_password" required><br><br>

        <label for="new_password">Nueva contraseña:</label><br>
        <input type="password" name="new_password" id="new_password" required><br><br>

        <label for="new_password_confirmation">Confirmar nueva contraseña:</label><br>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required><br><br>

        <button type="submit">Actualizar contraseña</button>
    </form>
</body>
</html>
