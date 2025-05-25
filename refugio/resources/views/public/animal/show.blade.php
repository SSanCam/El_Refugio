@extends('layouts.app') {{-- o tu layout de admin --}}

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
@endsection
