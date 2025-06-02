<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Animales</title>
</head>
<body>

    <h1>Listado de Animales</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('info'))
        <p style="color: orange;">{{ session('info') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <a href="{{ route('admin.animals.create') }}">➕ Nuevo animal</a>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Tamaño</th>
                <th>Sexo</th>
                <th>Peso (kg)</th>
                <th>Microchip</th>
                <th>Estado</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($animals as $animal)
                <tr>
                    <td>{{ $animal->id }}</td>
                    <td>{{ $animal->name }}</td>
                    <td>{{ $animal->species }}</td>
                    <td>{{ $animal->breed ?? '—' }}</td>
                    <td>{{ $animal->age }} años</td>
                    <td>{{ ucfirst($animal->size) }}</td>
                    <td>{{ ucfirst($animal->sex) }}</td>
                    <td>{{ $animal->weight ?? '—' }}</td>
                    <td>{{ $animal->microchip ?? '—' }}</td>
                    <td>{{ ucfirst($animal->status) }}</td>
                    <td>{{ Str::limit($animal->description, 60) }}</td>
                    <td>
                        @if ($animal->image)
                            <img src="{{ $animal->image }}" alt="Imagen de {{ $animal->name }}" width="60">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.animals.show', $animal->id) }}">Ver</a> |
                        <a href="{{ route('admin.animals.edit', $animal->id) }}">Editar</a> |
                        <form method="POST" action="{{ route('admin.animals.destroy', $animal->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás segura de que quieres eliminar este animal?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13">No hay animales registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $animals->links() }}
    </div>

</body>
</html>
