<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Adopción</title>
</head>

<body>

    <h1>Editar Adopción</h1>

    <form method="POST" action="{{ route('admin.adoption.update', $adoption->id) }}">
        @csrf
        @method('PUT')

        <label for="animal_id">Animal:</label>
        <select name="animal_id" required>
            @foreach ($animals as $animal)
                <option value="{{ $animal->id }}" {{ $animal->id == $adoption->animal_id ? 'selected' : '' }}>
                    {{ $animal->name }}
                </option>
            @endforeach
        </select>

        <label for="user_id">Usuario:</label>
        <select name="user_id" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $adoption->user_id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>

        <label for="adoption_date">Fecha de adopción:</label>
        <input type="date" name="adoption_date" value="{{ $adoption->adoption_date }}" required>

        <label for="notes">Notas:</label>
        <textarea name="notes">{{ $adoption->notes }}</textarea>

        <button type="submit">Actualizar adopción</button>
    </form>

    <a href="{{ route('admin.adoption.index') }}">← Volver al listado</a>

</body>

</html>
