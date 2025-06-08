<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de adopción</title>
</head>
<body>
    <h1>Adopción #{{ $adoption->id }}</h1>

    <p>Animal: {{ $adoption->animal->name ?? 'Desconocido' }}</p>
    <p>Usuario: {{ $adoption->user->name ?? 'Desconocido' }}</p>
    <p>Fecha de adopción: {{ $adoption->adoption_date }}</p>
    <p>Notas: {{ $adoption->notes }}</p>
</body>
</html>
