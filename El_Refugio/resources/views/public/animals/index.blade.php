{{-- resources/views/public/animals/index.blade.php --}}
@extends('layouts.public')

@section('title', 'Peludos | El Refugio')
@section('meta_description', 'Consulta los animales que actualmente están disponibles en el refugio para adopción o acogida.')
@section('meta_keywords', )

@endsection

@section('content')
<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Peludos en adopción y acogida</h1>
        <p>
            Consulta los animales que actualmente están disponibles en el refugio.
            Desde aquí podrás acceder a la ficha de cada peludo y, más adelante,
            iniciar una solicitud de adopción o acogida.
        </p>

        {{-- Filtros principales por especie --}}
        <nav class="animals-filters">
            <a href="{{ route('public.animals.index') }}"
                class="btn-cta--global {{ empty($currentSpecies) ? 'is-active' : '' }}">
                Todos
            </a>

            <a href="{{ route('public.animals.index', ['species' => 'dog']) }}"
                class="btn-cta--global {{ $currentSpecies === 'dog' ? 'is-active' : '' }}">
                Perros
            </a>

            <a href="{{ route('public.animals.index', ['species' => 'cat']) }}"
                class="btn-cta--global {{ $currentSpecies === 'cat' ? 'is-active' : '' }}">
                Gatos
            </a>
        </nav>

        {{-- Filtros secundarios: solo si hay especie seleccionada --}}
        @if (in_array($currentSpecies, ['dog', 'cat'], true))

        {{-- Tamaño --}}
        <nav class="animals-filters animals-filters--sub">
            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'sex'     => $currentSex,
            ])) }}" class="btn-cta--global {{ empty($currentSize) ? 'is-active' : '' }}">
                Todos los tamaños
            </a>

            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'sex'     => $currentSex,
                'size'    => 'small',
            ])) }}" class="btn-cta--global {{ $currentSize === 'small' ? 'is-active' : '' }}">
                Pequeños
            </a>

            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'sex'     => $currentSex,
                'size'    => 'medium',
            ])) }}" class="btn-cta--global {{ $currentSize === 'medium' ? 'is-active' : '' }}">
                Medianos
            </a>

            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'sex'     => $currentSex,
                'size'    => 'large',
            ])) }}" class="btn-cta--global {{ $currentSize === 'large' ? 'is-active' : '' }}">
                Grandes
            </a>
        </nav>

        {{-- Sexo --}}
        <nav class="animals-filters animals-filters--sub">
            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'size'    => $currentSize,
            ])) }}" class="btn-cta--global {{ empty($currentSex) ? 'is-active' : '' }}">
                Cualquier sexo
            </a>

            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'size'    => $currentSize,
                'sex'     => 'female',
            ])) }}" class="btn-cta--global {{ $currentSex === 'female' ? 'is-active' : '' }}">
                Hembra
            </a>

            <a href="{{ route('public.animals.index', array_filter([
                'species' => $currentSpecies,
                'size'    => $currentSize,
                'sex'     => 'male',
            ])) }}" class="btn-cta--global {{ $currentSex === 'male' ? 'is-active' : '' }}">
                Macho
            </a>
        </nav>

        @endif

    </header>

    @if ($animals->isEmpty())
    <section class="section-block">
        <p>En este momento no hay animales disponibles para adopción o acogida.</p>
    </section>
    @else
    <section class="section-block animals-grid">
        @foreach ($animals as $animal)
        <x-animal-index :animal="$animal" />
        @endforeach
    </section>

    <section class="section-block">
        {{ $animals->links() }}
    </section>
    @endif

</section>
@endsection