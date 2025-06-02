<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de animales en acogida</title>
</head>

<body>
    @extends('layouts.admin')

    @section('title', 'Listado de Acogidas')

    @section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Gestión de Acogidas</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
        @elseif($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <a href="{{ route('admin.fosters.create') }}" class="btn btn-primary mb-3">➕ Nueva Acogida</a>

        @if($fosters->count())
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Animal</th>
                        <th>Usuario</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fosters as $foster)
                    <tr>
                        <td>{{ $foster->id }}</td>
                        <td>{{ $foster->animal->name ?? '—' }}</td>
                        <td>{{ $foster->user->name ?? '—' }}</td>
                        <td>{{ $foster->start_date }}</td>
                        <td>{{ $foster->end_date ?? '—' }}</td>
                        <td>{{ ucfirst($foster->status) }}</td>
                        <td>
                            <a href="{{ route('admin.fosters.show', $foster->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('admin.fosters.edit', $foster->id) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.fosters.destroy', $foster->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('¿Seguro que deseas eliminar esta acogida?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $fosters->links() }}
        </div>
        @else
        <p class="text-muted">No hay acogidas registradas aún.</p>
        @endif
    </div>
    @endsection

</body>

</html>