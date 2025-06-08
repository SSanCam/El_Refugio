<!-- resources/views/public/user/volunteerForm.blade.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Voluntariado</title>
</head>

<body>
    <h1>Formulario de Voluntariado</h1>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('public.user.volunteerForm.send') }}" method="POST">
        @csrf

        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required><br><br>

        <label for="email">Correo electrónico:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required><br><br>

        <label for="phone">Teléfono (opcional):</label><br>
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"><br><br>

        <label for="message">¿En qué puedes ayudar como voluntario/a?</label><br>
        <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>

</html>