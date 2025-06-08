<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Animal</title>
</head>
<body>
    <h1>Nuevo Animal</h1>

    <form action="{{ route('admin.animal.store') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nombre" required><br><br>
        <input type="text" name="species" placeholder="Especie" required><br><br>
        <input type="text" name="breed" placeholder="Raza"><br><br>
        <input type="number" name="age" placeholder="Edad" required><br><br>
        <input type="text" name="size" placeholder="Tamaño (small, medium, large)" required><br><br>
        <input type="text" name="sex" placeholder="Sexo (male, female, unknown)" required><br><br>
        <input type="text" name="weight" placeholder="Peso"><br><br>
        <input type="text" name="microchip" placeholder="Microchip"><br><br>
        <textarea name="description" placeholder="Descripción" required></textarea><br><br>
        <input type="text" name="status" placeholder="Estado (available, adopted...)" required><br><br>
        <input type="url" name="image" placeholder="URL de imagen"><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
