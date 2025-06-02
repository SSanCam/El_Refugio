<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles de Acogida</title>
</head>

<body>
    <h1>Detalles de la Acogida #{{ $foster->id }}</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <ul>
        <li><strong>Animal:</strong> {{ $foster->animal->name ?? '—' }}</li>
        <li><strong>Usuario:</strong> {{ $foster->user->name ?? '—' }}</li>
        <li><strong>Email:</strong> {{ $foster->user->email ?? '—' }}</li>
        <li><strong>Teléfono:</strong> {{ $foster->user->phone ?? '—' }}</li>
        <li><strong>Dirección:</strong> {{ $foster->user->address ?? '—' }}</li>
        <li><strong>Estado:</strong> {{ ucfirst($foster->status) }}</li>
        <li><strong>Fecha de Inicio:</strong> {{ $foster->start_date }}</li>
        <li><strong>Fecha de Fin:</strong> {{ $foster->end_date ?? '—' }}</li>
    </ul>

    <a href="{{ route('admin.foster.index') }}">⬅ Volver al listado</a>
</body>

</html>
