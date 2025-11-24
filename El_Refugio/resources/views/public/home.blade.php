{{-- resources/views/public/home.blade.php --}}
@extends('layouts.public')

@section('title', 'Inicio | El Refugio')

@section('content')
<section>
    <x-header />
</section>
<section class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-4">
        Bienvenida a El Refugio
    </h1>

    <p class="mb-6">
        Esta es la landing pública de la aplicación. Aquí luego mostraremos
        animales destacados, llamadas a la acción, etc.
    </p>

    <p class="text-sm text-gray-600">
        (Ahora mismo es solo una vista de prueba usando el layout público
        con <code>&lt;x-header /&gt;</code> y <code>&lt;x-footer /&gt;</code>.)
    </p>
</section>
<section>
    <x-footer />
</section>
@endsection