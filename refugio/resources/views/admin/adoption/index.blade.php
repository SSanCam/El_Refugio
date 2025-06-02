<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopciones</title>
</head>

<body>

    <h1>Adopciones</h1>

    @if ($adoptions->isEmpty())
    <p>No hay adopciones registradas aún.</p>
    @else
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Usuario</th>
                <th>Fecha de adopción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adoptions as $adoption)
            <tr>
                <td>{{ $adoption->id }}</td>
                <td>{{ $adoption->animal->nombre ?? 'Sin nombre' }}</td>
                <td>{{ $adoption->user->name ?? 'Usuario no disponible' }}</td>
                <td>{{ $adoption->created_at->format('d/m/Y') }}</td>
                <td>{{ $adoption->status->label() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginación --}}
    <div>
        {{ $adoptions->links() }}
    </div>
    @endif

</body>

</html>