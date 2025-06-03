<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verifica tu correo</title>
</head>
<body>
    <h1>Verificación de correo</h1>
    <p>Por favor, revisa tu correo y haz clic en el enlace de verificación.</p>

    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Reenviar correo de verificación</button>
    </form>
</body>
</html>
