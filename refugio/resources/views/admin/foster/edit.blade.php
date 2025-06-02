<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Acogida</title>
</head>
<body>

    <h1>Editar Acogida</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.foster.update', $foster->id) }}">
        @csrf
        @method('PUT')

        <label for="animal_id">Animal:</label><br>
        <select name="animal_id" id="animal_id" required>
            @foreach ($animals as $animal)
                <option value="{{ $animal->id }}" {{ $animal->id == $foster->animal_id ? 'selected' : '' }}>
                    {{ $animal->name }}
                </option>
            @endforeach
        </select><br><br>

        <label for="status">Estado:</label><br>
        <select name="status" id="status" required>
            <option value="pending" {{ $foster->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
            <option value="fostering" {{ $foster->status == 'fostering' ? 'selected' : '' }}>En curso</option>
            <option value="finished" {{ $foster->status == 'finished' ? 'selected' : '' }}>Finalizada</option>
        </select><br><br>

        <label for="start_date">Fecha de inicio:</label><br>
        <input type="date" name="start_date" id="start_date" value="{{ $foster->start_date->format('Y-m-d') }}" required><br><br>

        <label for="end_date">Fecha de finalización:</label><br>
        <input type="date" name="end_date" id="end_date" value="{{ $foster->end_date ? $foster->end_date->format('Y-m-d') : '' }}"><br><br>

        <button type="submit">Guardar cambios</button>
    </form>

    <br>
    <a href="{{ route('admin.foster.index') }}">← Volver al listado</a>

</body>
</html>
