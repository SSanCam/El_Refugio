{{-- resources/views/components/animal-index.blade.php (o animal-card) --}}
@props([
    'animal',
    'showActions' => true,   // NUEVO: por defecto muestra el botón
])

<article class="animal-card">
    @if ($animal->images->isNotEmpty())
        <figure class="animal-card__image-wrapper">
            <img
                src="{{ $animal->images->first()->url }}"
                alt="{{ $animal->images->first()->alt_text ?? 'Foto de ' . $animal->name }}"
                class="animal-card__image"
            >
        </figure>
    @endif

    <div class="animal-card__body">
        <h2 class="animal-card__name">{{ $animal->name }}</h2>

        <p class="animal-card__meta">
            @php $sexLabel = $animal->sex?->label(); @endphp
            @if ($sexLabel && trim($sexLabel) !== '')
                {{ $sexLabel }}
            @endif
            @if ($animal->size)
                {{ $sexLabel && trim($sexLabel) !== '' ? ' · ' : '' }}{{ $animal->size->label() }}
            @endif
        </p>

        <p class="animal-card__age">
            @if (is_null($animal->age))
                Sin datos
            @elseif ($animal->age === 0)
                Cachorro
            @else
                {{ $animal->age }} año{{ $animal->age > 1 ? 's' : '' }}
            @endif
        </p>

        @if ($showActions)
            <div class="animal-card__actions">
                <a href="{{ route('public.animals.show', $animal->id) }}" class="btn-card">
                    Ver ficha
                </a>
            </div>
        @endif
    </div>
</article>
