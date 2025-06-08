<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Adopción</title>
</head>

<body>
    <h1>Formulario de Adopción</h1>

    <form action="{{ route('forms.adoption.submit') }}" method="POST">
        @csrf

        <label for="name">Tu nombre:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Tu correo electrónico:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="animal_nombre">Nombre del animal que deseas adoptar:</label><br>
        <input type="text" id="animal_nombre" name="animal_nombre" required><br><br>

        <label for="phone">Teléfono de contacto (opcional):</label><br>
        <input type="tel" id="phone" name="phone"><br><br>

        <button type="submit">Enviar solicitud</button>
    </form>

</body>

</html>