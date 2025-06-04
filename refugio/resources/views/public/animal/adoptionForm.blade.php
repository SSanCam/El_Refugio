<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Adopción</title>
</head>
<body>
    <h1>Formulario de Adopción</h1>

    <form action="{{ route('adoption.submit') }}" method="POST">
        @csrf
        <input type="text" name="nombre" placeholder="Tu nombre" required><br><br>
        <input type="email" name="email" placeholder="Tu correo electrónico" required><br><br>
        <input type="tel" name="telefono" placeholder="Tu número de teléfono" required><br><br>
        <input type="text" name="animal_nombre" placeholder="Nombre del animal (opcional)"><br><br>

        <p>¿Qué tipo de animal buscas?</p>
        <label><input type="checkbox" name="tipo[]" value="perro"> Perro</label>
        <label><input type="checkbox" name="tipo[]" value="gato"> Gato</label><br><br>

        <p>Preferencias:</p>
        <label><input type="checkbox" name="sexo[]" value="macho"> Macho</label>
        <label><input type="checkbox" name="sexo[]" value="hembra"> Hembra</label><br>

        <label><input type="checkbox" name="tamano[]" value="pequeño"> Pequeño</label>
        <label><input type="checkbox" name="tamano[]" value="mediano"> Mediano</label>
        <label><input type="checkbox" name="tamano[]" value="grande"> Grande</label><br>

        <label><input type="checkbox" name="edad[]" value="cachorro"> Cachorro</label>
        <label><input type="checkbox" name="edad[]" value="adulto"> Adulto</label>
        <label><input type="checkbox" name="edad[]" value="senior"> Senior</label><br><br>

        <input type="text" name="raza" placeholder="Raza preferida (opcional)"><br><br>

        <button type="submit">Enviar solicitud</button>
    </form>
</body>
</html>
