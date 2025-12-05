{{-- resources/views/public/animals/show.blade.php --}}
@extends('layouts.public')

@section('title', 'Conoce a ' . $animal->name . ' | El Refugio')

@section('meta_description', 'Conoce a ' . $animal->name . ', uno de los peludos en adopción de El Refugio. Consulta su ficha, características y cómo iniciar una solicitud.')
@section('meta_keywords', 'conoce a ' . $animal->name . ', ficha animal, adopción, acogida, refugio de animales')

@section('content')

<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Conoce a {{ $animal->name }}</h1>
    </header>

    @php
        $gallery = $animal->images->map(function ($img) use ($animal) {
            return [
                'url' => $img->url,
                'alt' => $img->alt_text ?? ('Foto de ' . $animal->name),
            ];
        });
    @endphp

    <section class="section-block animal-detail">
        <x-animal-show :animal="$animal" :gallery="$gallery" />

        <div class="animal-detail__back">
            <a href="{{ route('public.animals.index') }}" class="animal-detail__back-link">
                ← Volver al listado de peludos
            </a>
        </div>
    </section>

</section>
@endsection
