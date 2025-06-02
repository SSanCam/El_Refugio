<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Animal</title>
</head>
<body>

    <h1>Registrar Nuevo Animal</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.animals.store') }}">
        @csrf

        <label for="name">Nombre:</label>
        <input type="text" name="name" required><br>

        <label for="species">Especie:</label>
        <input type="text" name="species" required><br>

        <label for="breed">Raza:</label>
        <input type="text" name="breed"><br>

        <label for="age">Edad:</label>
        <input type="number" name="age" min="0" required><br>

        <label for="size">Tamaño:</label>
        <select name="size" required>
            <option value="small">Pequeño</option>
            <option value="medium">Mediano</option>
            <option value="large">Grande</option>
        </select><br>

        <label for="sex">Sexo:</label>
        <select name="sex" required>
            <option value="male">Macho</option>
            <option value="female">Hembra</option>
            <option value="unknown">Desconocido</option>
        </select><br>

        <label for="weight">Peso (kg):</label>
        <input type="number" name="weight" step="0.1"><br>

        <label for="status">Estado:</label>
        <select name="status" required>
            <option value="available">Disponible</option>
            <option value="adopted">Adoptado</option>
            <option value="fostered">Acogido</option>
            <option value="sponsored">Apadrinado</option>
            <option value="sheltered">Refugiado</option>
            <option value="intake">En ingreso</option>
            <option value="deceased">Fallecido</option>
        </select><br>

        <label for="microchip">Microchip:</label>
        <input type="text" name="microchip"><br>

        <label for="description">Descripción:</label><br>
        <textarea name="description" required></textarea><br>

        <label for="image">Imagen destacada (URL):</label>
        <input type="url" name="image"><br><br>

        <button type="submit">Guardar Animal</button>
    </form>

    <a href="{{ route('admin.animals.index') }}">← Volver al listado</a>

</body>
</html>
