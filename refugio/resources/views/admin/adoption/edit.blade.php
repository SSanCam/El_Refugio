<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar adopción</title>
</head>
<body>
    <h1>Editar Adopción #{{ $adoption->id }}</h1>

    <form action="{{ route('admin.adoption.update', $adoption->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Animal:</label>
        <select name="animal_id">
            @foreach ($animals as $animal)
                <option value="{{ $animal->id }}" @if($adoption->animal_id == $animal->id) selected @endif>
                    {{ $animal->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Usuario:</label>
        <select name="user_id">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @if($adoption->user_id == $user->id) selected @endif>
                    {{ $user->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Fecha de adopción:</label>
        <input type="date" name="adoption_date" value="{{ $adoption->adoption_date }}"><br><br>

        <label>Notas:</label>
        <textarea name="notes">{{ $adoption->notes }}</textarea><br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
