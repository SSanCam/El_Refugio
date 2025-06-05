<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Acogida</title>
</head>
<body>
    <h1>Formulario de Acogida Temporal</h1>

    <form action="{{ route('foster.submit') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Tu nombre" required><br><br>
        <input type="email" name="email" placeholder="Tu correo electrónico" required><br><br>
        <input type="tel" name="phone" placeholder="Tu número de teléfono"><br><br>
        <input type="text" name="address" placeholder="Dirección completa" required><br><br>

        <textarea name="message" placeholder="Comentarios adicionales... (opcional)"></textarea><br><br>

        <p>Tipo de vivienda:</p>
        <label><input type="radio" name="vivienda" value="casa" required> Casa</label>
        <label><input type="radio" name="vivienda" value="piso" required> Piso</label><br><br>

        <p>¿Tienes jardín o zonas habilitadas para animales?</p>
        <label><input type="radio" name="jardin" value="si" required> Sí</label>
        <label><input type="radio" name="jardin" value="no" required> No</label><br><br>

        <p>¿Qué tipo de animal podrías acoger?</p>
        <label><input type="checkbox" name="animal[]" value="perro"> Perro</label>
        <label><input type="checkbox" name="animal[]" value="gato"> Gato</label><br><br>

        <button type="submit">Enviar solicitud</button>
    </form>
</body>
</html>
