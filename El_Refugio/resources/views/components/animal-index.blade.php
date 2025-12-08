{{-- resources/views/components/animal-index.blade.php --}}
@props([
'animal',
'showActions' => true,
])

<article class="animal-card">
    <figure class="animal-card__image-wrapper">
        @if ($animal->images->isNotEmpty())
        <img src="{{ $animal->images->first()->url }}"
            alt="{{ $animal->images->first()->alt_text ?? 'Foto de ' . $animal->name }}" class="animal-card__image">
        @else
        <img src="{{ $animal->species === 'cat' 
                    ? 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765144900/image-removebg-preview_5_y1jx6s.png' 
                    : 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765144900/image-removebg-preview_6_pgkr4k.png' }}"
            alt="Imagen por defecto de {{ $animal->species }}" class="animal-card__image">
        @endif
    </figure>


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