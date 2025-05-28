<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Indice de apadrinamientos</h1>

    <h1>Lista de Apadrinamientos</h1>

    @if(session('success'))
    <div>{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sponsorships as $sponsorship)
            <tr>
                <td>{{ $sponsorship->id }}</td>
                <td>{{ $sponsorship->animal->name }}</td>
                <td>{{ $sponsorship->user ? $sponsorship->user->name : 'No registrado' }}</td>
                <td>{{ $sponsorship->status }}</td>
                <td>
                    <a href="{{ route('admin.sponsorships.show', $sponsorship->id) }}">Ver</a>
                    <a href="{{ route('admin.sponsorships.edit', $sponsorship->id) }}">Editar</a>
                    <form action="{{ route('admin.sponsorships.destroy', $sponsorship->id) }}" method="POST"
                        style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('¿Eliminar este apadrinamiento?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sponsorships->links() }}

</body>

</html>