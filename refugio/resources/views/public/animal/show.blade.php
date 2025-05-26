<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del animal</h1>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $animal->name }}</p>
            <p><strong>Especie:</strong> {{ $animal->species }}</p>
            <p><strong>Raza:</strong> {{ $animal->breed ?? 'No especificada' }}</p>
            <p><strong>Edad:</strong> {{ $animal->age }}</p>
            <p><strong>Tamaño:</strong> {{ $animal->size }}</p>
            <p><strong>Sexo:</strong> {{ $animal->sex }}</p>
            <p><strong>Peso:</strong> {{ $animal->weight ?? 'No registrado' }}</p>
            <p><strong>Estado:</strong> {{ $animal->status }}</p>
            <p><strong>Microchip:</strong> {{ $animal->microchip ?? 'No registrado' }}</p>
            <p><strong>Descripción:</strong> {{ $animal->description }}</p>

            @if ($animal->image)
                <p><strong>Imagen:</strong></p>
                <img src="{{ $animal->image }}" alt="Imagen del animal" style="max-width: 300px;">
            @endif
        </div>
    </div>
</div>

{{-- Adopciones --}}
@if ($animal->adoptions->isNotEmpty())
    <h2>Adopciones</h2>
    <ul>
        @foreach ($animal->adoptions as $adoption)
            <li>
                Adoptado por: {{ $adoption->user->name ?? 'Usuario no disponible' }}<br>
                Fecha: {{ $adoption->adoption_date }}<br>
                Notas: {{ $adoption->notes ?? 'Sin notas' }}
            </li>
        @endforeach
    </ul>
@endif

{{-- Acogidas --}}
@if ($animal->fosters->isNotEmpty())
    <h2>Acogidas</h2>
    <ul>
        @foreach ($animal->fosters as $foster)
            <li>
                Acogido por: {{ $foster->user->name ?? 'Usuario no disponible' }}<br>
                Desde: {{ $foster->start_date }} hasta {{ $foster->end_date ?? 'actualidad' }}<br>
                Comentarios: {{ $foster->comments ?? 'Sin comentarios' }}
            </li>
        @endforeach
    </ul>
@endif

{{-- Apadrinamientos --}}
@if ($animal->sponsorships->isNotEmpty())
    <h2>Apadrinamientos</h2>
    <ul>
        @foreach ($animal->sponsorships as $sponsorship)
            <li>
                Apadrinado por: {{ $sponsorship->user->name ?? 'Usuario no disponible' }}<br>
                Fecha: {{ $sponsorship->created_at->format('Y-m-d') }}
            </li>
        @endforeach
    </ul>
@endif

@endsection


</body>
</html>


