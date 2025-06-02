<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de animal</title>
</head>

<body>
    @extends('layouts.admin')

    @section('content')
    <div class="container">
        <h1>Detalles del Animal</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">{{ $animal->name }}</h4>
                <p><strong>ID:</strong> {{ $animal->id }}</p>
                <p><strong>Especie:</strong> {{ $animal->species }}</p>
                <p><strong>Raza:</strong> {{ $animal->breed ?? 'No especificada' }}</p>
                <p><strong>Edad:</strong> {{ $animal->age }} años</p>
                <p><strong>Tamaño:</strong> {{ ucfirst($animal->size) }}</p>
                <p><strong>Sexo:</strong> {{ ucfirst($animal->sex) }}</p>
                <p><strong>Peso:</strong> {{ $animal->weight ? $animal->weight . ' kg' : 'No especificado' }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($animal->status) }}</p>
                <p><strong>Microchip:</strong> {{ $animal->microchip ?? 'No disponible' }}</p>
                <p><strong>Descripción:</strong> {{ $animal->description ?? 'Sin descripción' }}</p>

                {{-- Imagen --}}
                @if ($animal->image)
                <div class="mt-3">
                    <label><strong>Imagen:</strong></label><br>
                    <img src="{{ $animal->image }}" alt="Imagen del animal" class="img-fluid img-thumbnail"
                        style="max-width: 400px;">
                </div>
                @else
                <p><strong>Imagen:</strong> No disponible</p>
                @endif
            </div>
        </div>

        {{-- Relaciones --}}
        <div>
            <h5>Adopciones</h5>
            @forelse ($animal->adoptions as $adoption)
            <p>Adoptado por: {{ $adoption->user->name }} ({{ $adoption->created_at->format('d/m/Y') }})</p>
            @empty
            <p>No hay adopciones registradas.</p>
            @endforelse

            <h5>Acogidas</h5>
            @forelse ($animal->fosters as $foster)
            <p>Acogido por: {{ $foster->user->name }} ({{ $foster->created_at->format('d/m/Y') }})</p>
            @empty
            <p>No hay acogidas registradas.</p>
            @endforelse

            <h5>Apadrinamientos</h5>
            @forelse ($animal->sponsorships as $sponsorship)
            <p>Apadrinado por: {{ $sponsorship->user->name }} ({{ $sponsorship->created_at->format('d/m/Y') }})</p>
            @empty
            <p>No hay apadrinamientos registrados.</p>
            @endforelse
        </div>

        <a href="{{ route('admin.animals.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
    </div>
    @endsection

</body>

</html>