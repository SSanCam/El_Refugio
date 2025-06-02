<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de la Adopción</title>
</head>

<body>

    <h1>Detalles de la Adopción</h1>

    <ul>
        <li><strong>ID:</strong> {{ $adoption->id }}</li>
        <li><strong>Animal:</strong> {{ $adoption->animal->name ?? 'No disponible' }}</li>
        <li><strong>Adoptante:</strong> {{ $adoption->user->name ?? 'No disponible' }}</li>
        <li><strong>Fecha de adopción:</strong> {{ $adoption->adoption_date }}</li>
        <li><strong>Notas:</strong> {{ $adoption->notes ?? 'Sin notas' }}</li>
    </ul>

    @if ($adoption->animal->image)
    <div>
        <img src="{{ $adoption->animal->image }}" alt="Imagen del animal {{ $adoption->animal->name }}" width="200">
    </div>
    @endif

    <a href="{{ route('admin.adoption.index') }}">← Volver al listado</a>

</body>

</html>