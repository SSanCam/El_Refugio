{{-- resources/views/public/animals/show.blade.php --}}
@extends('layouts.public')

@section('title', $animal->name . ' | El Refugio')

@section('content')
    <section style="padding: 2rem; max-width: 960px; margin: 0 auto;">

        <h1>Conoce a {{ $animal->name }}</h1>

        <div style="display: flex; flex-wrap: wrap; gap: 2rem; margin-top: 1.5rem;">

            {{-- Imagen principal --}}
            <div style="flex: 1 1 260px;">
                @if ($animal->images->isNotEmpty())
                    <img src="{{ $animal->images->first()->url }}"
                         alt="{{ $animal->images->first()->alt_text }}"
                         style="max-width: 100%; height: auto; border-radius: 10px;">
                @else
                    <p>Este peludo todavía no tiene foto asignada.</p>
                @endif
            </div>

            {{-- Datos básicos --}}
            <div style="flex: 1 1 260px;">
                <p><strong>Especie:</strong> {{ $animal->species }}</p>
                <p><strong>Sexo:</strong> {{ $animal->sex }}</p>
                <p><strong>Tamaño:</strong> {{ $animal->size }}</p>

                @if (!empty($animal->birth_date))
                    <p><strong>Fecha de nacimiento aproximada:</strong> {{ $animal->birth_date }}</p>
                @endif

                <p><strong>Estado:</strong> {{ $animal->status }} / {{ $animal->availability }}</p>

                {{-- Aquí más adelante podremos añadir descripción y observaciones
                     cuando las incluyamos en el select del controlador --}}
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <a href="{{ route('public.animals.index') }}">← Volver al listado de peludos</a>
        </div>

    </section>
@endsection
