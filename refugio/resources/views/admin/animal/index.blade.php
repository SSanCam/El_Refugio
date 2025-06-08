<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Animales registrados</title>
</head>

<body>
    <h1>Listado de Animales</h1>

    @if (session('info'))
    <p>{{ session('info') }}</p>
    @endif

    @if ($errors->any())
    <div>{{ $errors->first() }}</div>
    @endif

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Especie</th>
            <th>Estado</th>
        </tr>
        @foreach ($animals as $animal)
        <tr>
            <td>{{ $animal->id }}</td>
            <td>{{ $animal->name }}</td>
            <td>{{ $animal->species }}</td>
            <td>{{ $animal->status }}</td>
        </tr>
        @endforeach
    </table>

    {{ $animals->links() }}

</body>

</html>