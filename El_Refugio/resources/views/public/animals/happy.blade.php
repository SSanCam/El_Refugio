{{-- resources/views/public/animals/happy.blade.php --}}
@extends('layouts.public')
@section('title', 'Finales felices | El Refugio')

@section('content')
<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Finales felices</h1>
        <p>
            Aquí puedes ver algunos de los peludos que ya han encontrado familia.
            Gracias a las adopciones responsables, estos casos son posibles.
        </p>
    </header>

    @if ($animals->isEmpty())
        <section class="section-block">
            <p>Aún no hay finales felices registrados. ¡Pronto los habrá!</p>
        </section>
    @else
        <section class="section-block animals-grid">
            @foreach ($animals as $animal)
                {{-- Misma tarjeta que el índice, pero sin botón --}}
                <x-animal-index :animal="$animal" :show-actions="false" />
            @endforeach
        </section>

        <section class="section-block">
            {{ $animals->links() }}
        </section>
    @endif

</section>
@endsection
