<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Apadrinamiento concreto</h1>

    <h1>Detalle de Apadrinamiento #{{ $sponsorship->id }}</h1>

    <p><strong>Animal:</strong> {{ $sponsorship->animal->name }}</p>
    <p><strong>Usuario:</strong> {{ $sponsorship->user ? $sponsorship->user->name : 'No registrado' }}</p>
    <p><strong>Email:</strong> {{ $sponsorship->email }}</p>
    <p><strong>Estado:</strong> {{ $sponsorship->status }}</p>
    <p><strong>Fecha Inicio:</strong> {{ $sponsorship->start_date }}</p>
    <p><strong>Fecha Fin:</strong> {{ $sponsorship->end_date ?? 'No definida' }}</p>
    <p><strong>Cantidad:</strong> {{ $sponsorship->donation_amount }} €</p>
    <p><strong>Intervalo:</strong> {{ $sponsorship->donation_interval }}</p>
    <p><strong>Notas:</strong> {{ $sponsorship->notes ?? 'Ninguna' }}</p>

    <form action="{{ route('admin.sponsorships.cancel', $sponsorship->id) }}" method="POST">
        @csrf
        @method('PATCH')
        @if($sponsorship->status !== 'canceled')
        <button type="submit" onclick="return confirm('¿Confirmar cancelación?')">Cancelar Apadrinamiento</button>
        @else
        <p>Apadrinamiento cancelado.</p>
        @endif
    </form>

    <a href="{{ route('admin.sponsorships.index') }}">Volver a la lista</a>
    <a href="{{ route('admin.sponsorships.edit', $sponsorship->id) }}">Editar</a>

</body>

</html>