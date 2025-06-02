<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar nueva adopción</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <h1>Registrar nueva adopción</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.adoptions.store') }}">
        @csrf

        <!-- ANIMAL -->
        <label for="animal_id">Animal:</label>
        <select name="animal_id" required>
            <option value="">-- Selecciona un animal --</option>
            @foreach ($animalesDisponibles as $animal)
                <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
            @endforeach
        </select>
        <br><br>

        <!-- EMAIL del usuario -->
        <label for="email">Correo electrónico del adoptante:</label>
        <input type="email" name="email" required placeholder="ejemplo@email.com" value="{{ old('email') }}">
        <br><br>

        <p><strong>Si el usuario no existe, se creará automáticamente con los siguientes datos:</strong></p>

        <label for="name">Nombre completo:</label>
        <input type="text" name="name" placeholder="Nombre del adoptante" value="{{ old('name') }}">
        <br><br>

        <label for="phone">Teléfono:</label>
        <input type="text" name="phone" placeholder="Ej: 600123456" value="{{ old('phone') }}">
        <br><br>

        <label for="address">Dirección:</label>
        <input type="text" name="address" placeholder="Dirección del adoptante" value="{{ old('address') }}">
        <br><br>

        <!-- FECHA DE ADOPCIÓN -->
        <label for="adoption_date">Fecha de adopción:</label>
        <input type="date" name="adoption_date" required value="{{ old('adoption_date') }}">
        <br><br>

        <!-- NOTAS -->
        <label for="notes">Notas adicionales:</label>
        <textarea name="notes" rows="4" cols="40" placeholder="Comentarios u observaciones...">{{ old('notes') }}</textarea>
        <br><br>

        <button type="submit">Registrar adopción</button>
        <a href="{{ route('admin.adoptions.index') }}">Cancelar</a>
    </form>

</body>
</html>
