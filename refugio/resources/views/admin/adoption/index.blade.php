<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Adopciones</title>
</head>
<body>
    <h1>Adopciones registradas</h1>

    @if(session('info'))
        <p>{{ session('info') }}</p>
    @endif

    @foreach ($adoptions as $adopcion)
        <p>ID: {{ $adopcion->id }} | Animal ID: {{ $adopcion->animal_id }} | Usuario ID: {{ $adopcion->user_id }}</p>
    @endforeach
</body>
</html>
