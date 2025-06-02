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

        <label for="animal_id">Animal:</label>
        <select name="animal_id" required>
            @foreach ($animalesDisponibles as $animal)
            <option value="{{ $animal->id }}">{{ $animal->nombre }}</option>
            @endforeach
        </select>
        <br><br>

        <label for="user_id">Usuario:</label>
        <select name="user_id" required>
            @foreach ($usuarios as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
        <br><br>

        <label for="adoption_date">Fecha de adopción:</label>
        <input type="date" name="adoption_date" required>
        <br><br>

        <label for="notes">Notas:</label>
        <textarea name="notes" rows="4" cols="40"></textarea>
        <br><br>

        <button type="submit">Registrar adopción</button>
    </form>

</body>

</html>