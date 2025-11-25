@extends('layouts.public')

@section('title', 'Peludos | El Refugio')

@section('content')

    <h1>Animales disponibles</h1>
    <p>Tu amigo peludo te está esperando.</p>

    @foreach ($animals as $animal)
        <div style="margin-bottom: 25px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">

            <h2>{{ $animal->name }}</h2>

            @if ($animal->images->isNotEmpty())
                <img src="{{ $animal->images->first()->url }}"
                     alt="{{ $animal->images->first()->alt_text }}"
                     style="width: 200px; height: auto; border-radius: 10px;">
            @endif

            <p>
                {{ ucfirst($animal->species) }} —
                {{ $animal->breed }} —
                Tamaño: {{ $animal->size }}
            </p>

            <a href="{{ route('public.animals.show', $animal->id) }}">Ver más</a>
        </div>
    @endforeach

@endsection
