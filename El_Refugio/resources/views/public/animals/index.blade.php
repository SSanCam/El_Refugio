{{-- resources/views/public/animals/index.blade.php --}}
@extends('layouts.public')

@section('title', 'Peludos | El Refugio')
@section('meta_description', 'Consulta los animales que actualmente están disponibles en el refugio para adopción o
acogida.')
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

        {{-- Barra de filtros públicos --}}
        <section class="animals-filters-bar">
            <form method="GET" action="{{ route('public.animals.index') }}" class="animals-filters-bar__form">
                {{-- Ver todos --}}
                <a href={{ '/peludos' }}>Ver todos</a>
                {{-- Especie --}}
                <select name="species" class="animals-filter-select">
                    <option value="">Especie</option>
                    <option value="dog" {{ ($species ?? '') === 'dog' ? 'selected' : '' }}>Perros</option>
                    <option value="cat" {{ ($species ?? '') === 'cat' ? 'selected' : '' }}>Gatos</option>
                </select>

                {{-- Tamaño --}}
                <select name="size" class="animals-filter-select">
                    <option value="">Tamaño</option>
                    <option value="small" {{ ($size ?? '') === 'small' ? 'selected' : '' }}>Pequeños</option>
                    <option value="medium" {{ ($size ?? '') === 'medium' ? 'selected' : '' }}>Medianos</option>
                    <option value="large" {{ ($size ?? '') === 'large' ? 'selected' : '' }}>Grandes</option>
                </select>

                {{-- Sexo --}}
                <select name="sex" class="animals-filter-select">
                    <option value="">Sexo</option>
                    <option value="female" {{ ($sex ?? '') === 'female' ? 'selected' : '' }}>Hembra</option>
                    <option value="male" {{ ($sex ?? '') === 'male' ? 'selected' : '' }}>Macho</option>
                </select>

                <button type="submit" class="btn-cta--global">
                    Filtrar
                </button>

                @if(request()->anyFilled(['search','species','size','sex']))
                <a href="{{ route('public.animals.index') }}" class="btn-cta--global-outline">
                    Limpiar
                </a>
                @endif
            </form>
        </section>

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

    {{-- Paginacion --}}
    <section class="section-block" style="margin-top: 1rem;">
        <x-pagination :currentPage="$animals->currentPage()" :lastPage="$animals->lastPage()"
            :prevPageUrl="$animals->previousPageUrl()" :nextPageUrl="$animals->nextPageUrl()" />
    </section>

    @endif

</section>
@endsection