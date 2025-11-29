@extends('layouts.public')

@section('title', 'Peludos | El Refugio')

@section('content')

    <h1>Animales disponibles</h1>
    <h3>Tu amigo peludo te está esperando.</h3>

    @foreach ($animals as $animal)
        <div style="margin-bottom: 25px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">

            <h2>{{ $animal->name }}</h2>

            @if ($animal->images->isNotEmpty())
                <img src="{{ $animal->images->first()->url }}"
                     alt="{{ $animal->images->first()->alt_text }}"
                     style="width: 200px; height: auto; border-radius: 10px;">
            @endif

            {{-- Si tienes accessor getAgeAttribute en el modelo --}}
            {{-- <p>Edad: {{ $animal->age }} años</p> --}}

            <p>Especie: {{ $animal->species }}</p>
            <p>Estado: {{ $animal->status }} / {{ $animal->availability }}</p>

            {{-- En cuanto tengamos la show configurada, este enlace funcionará --}}
            {{-- <a href="{{ route('public.animals.show', $animal->id) }}">Ver más</a> --}}
        </div>
    @endforeach

@endsection
