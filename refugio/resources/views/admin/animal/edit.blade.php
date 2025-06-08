<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Animal</title>
</head>
<body>
    <h1>Editar {{ $animal->name }}</h1>

    <form action="{{ route('admin.animal.update', $animal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $animal->name }}" required><br><br>
        <input type="text" name="species" value="{{ $animal->species }}" required><br><br>
        <input type="text" name="breed" value="{{ $animal->breed }}"><br><br>
        <input type="number" name="age" value="{{ $animal->age }}" required><br><br>
        <input type="text" name="size" value="{{ $animal->size }}" required><br><br>
        <input type="text" name="sex" value="{{ $animal->sex }}" required><br><br>
        <input type="text" name="weight" value="{{ $animal->weight }}"><br><br>
        <input type="text" name="microchip" value="{{ $animal->microchip }}"><br><br>
        <textarea name="description" required>{{ $animal->description }}</textarea><br><br>
        <input type="text" name="status" value="{{ $animal->status }}" required><br><br>
        <input type="text" name="image" value="{{ $animal->image }}"><br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
