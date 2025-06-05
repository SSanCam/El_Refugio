<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Adopción</title>
</head>

<body>
    <h1>Formulario de Adopción</h1>

    <form action="{{ route('adoption.submit') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Tu nombre" required><br><br>
        <input type="email" name="email" placeholder="Tu correo electrónico" required><br><br>
        <input type="tel" name="phone" placeholder="Tu número de teléfono"><br><br>
        <input type="text" name="address" placeholder="Tu dirección completa" required><br><br>
        <textarea name="message" placeholder="Comentarios opcionales..."></textarea><br><br>

        <!-- Todos estos campos adicionales puedes dejarlos si quieres procesarlos después -->
        <input type="text" name="animal_nombre" placeholder="Nombre del animal (opcional)"><br><br>
        <!-- ... resto de checkboxes ... -->

        <button type="submit">Enviar solicitud</button>
    </form>

</body>

</html>