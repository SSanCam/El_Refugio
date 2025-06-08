<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Animal</title>
</head>
<body>
    <h1>{{ $animal->name }}</h1>
    <p>Especie: {{ $animal->species }}</p>
    <p>Edad: {{ $animal->age }}</p>
    <p>Estado: {{ $animal->status }}</p>
    <p>Descripción: {{ $animal->description }}</p>
</body>
</html>
