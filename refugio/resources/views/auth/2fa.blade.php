<!-- resources/views/2fa.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verificación en dos pasos</title>
</head>
<body>
    <h2>Verificación en dos pasos</h2>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <label for="code">Introduce el código que te hemos enviado:</label><br>
        <input type="text" id="code" name="code" required><br><br>

        <button type="submit">Verificar</button>
    </form>

    <form method="POST" action="{{ route('2fa.resend') }}">
        @csrf
        <button type="submit" style="margin-top: 10px;">Reenviar código</button>
    </form>
</body>
</html>
