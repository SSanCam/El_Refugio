<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar nueva adopción</title>
</head>
<body>
    <h1>Nueva Adopción</h1>

    <form action="{{ route('admin.adoption.store') }}" method="POST">
        @csrf

        <label>Animal:</label>
        <select name="animal_id">
            @foreach ($animals as $animal)
                <option value="{{ $animal->id }}">{{ $animal->name }}</option>
            @endforeach
        </select><br><br>

        <label>Email del adoptante:</label>
        <input type="email" name="email" required><br><br>

        <label>Nombre:</label>
        <input type="text" name="name"><br><br>

        <label>Teléfono:</label>
        <input type="text" name="phone"><br><br>

        <label>Dirección:</label>
        <input type="text" name="address"><br><br>

        <label>Fecha de adopción:</label>
        <input type="date" name="adoption_date" required><br><br>

        <label>Notas:</label>
        <textarea name="notes"></textarea><br><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
