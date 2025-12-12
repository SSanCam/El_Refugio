@props(['animal', 'gallery'])

@php
use App\Enums\AnimalAvailability;
@endphp

<article class="animal-detail-card">
    <div class="animal-detail-card__media">
        @if ($gallery->isNotEmpty())
        <div class="animal-detail-card__image-frame">
            <img id="animal-main-image" src="{{ $gallery[0]['url'] }}" alt="{{ $gallery[0]['alt'] }}"
                class="animal-detail-card__image">

            @if ($gallery->count() > 1)
            <button type="button" class="animal-detail-card__nav animal-detail-card__nav--prev"
                aria-label="Foto anterior">
                ‹
            </button>
            <button type="button" class="animal-detail-card__nav animal-detail-card__nav--next"
                aria-label="Foto siguiente">
                ›
            </button>
            @endif
        </div>

        @if ($gallery->count() > 1)
        <div class="animal-detail-card__thumbnails">
            @foreach ($gallery as $index => $image)
            <button type="button" class="animal-detail-card__thumb-btn {{ $index === 0 ? 'is-active' : '' }}"
                data-index="{{ $index }}" aria-label="Ver foto {{ $index + 1 }}">
                <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="animal-detail-card__thumb">
            </button>
            @endforeach
        </div>
        @endif
        @else
        <p class="animal-detail__no-image">
            Este peludo todavía no tiene foto asignada.
        </p>
        @endif
    </div>

    <div class="animal-detail-card__info">
        <h2 class="animal-detail__name">{{ $animal->name }}</h2>

        <p class="animal-detail__meta">
            @php $sexLabel = $animal->sex?->label(); @endphp

            @if ($sexLabel && trim($sexLabel) !== '')
            {{ $sexLabel }}
            @endif

            @if ($animal->size)
            {{ $sexLabel && trim($sexLabel) !== '' ? ' · ' : '' }}
            {{ $animal->size?->label() }}
            @endif


        </p>

        <dl class="animal-detail__data">
            <div class="animal-detail__row">
                <dd>
                    {{ $animal->breed ?? 'Sin datos' }}
                </dd>
            </div>
        </dl>

        <dl class="animal-detail__data">
            <div class="animal-detail__row">
                <dd>
                    @if (is_null($animal->age))
                    Sin datos
                    @elseif ($animal->age === 0)
                    Cachorro
                    @else
                    {{ $animal->age }} año{{ $animal->age > 1 ? 's' : '' }}
                    @endif
                </dd>
            </div>
        </dl>

        @if ($animal->description)
        <section>
            <h3 class="animal-detail__subtitle">Descripción</h3>
            <p class="animal-detail__text">{{ $animal->description }}</p>
        </section>
        @endif

        @if ($animal->entry_date)
        @php $days = $animal->days; @endphp
        <section>
            <h3 class="animal-detail__subtitle">
                {{ $animal->name }} lleva en el refugio:
            </h3>
            <p class="animal-detail__text">
                @if (is_null($days))
                Sin datos.
                @elseif ($days === 1)
                Recién llegado.
                @else
                {{ $days }} días.
                @endif
            </p>
        </section>
        @endif

        @if ($animal->availability === AnimalAvailability::AVAILABLE)
        <div class="section-cta animal-detail__cta">
            <a href="{{ route('public.forms.request', [
                    'animal' => $animal->id,
                    'type' => 'adoption'
                ]) }}" class="btn-card">
                Adopta
            </a>

            <a href="{{ route('public.forms.request', [
                    'animal' => $animal->id
                ]) }}" class="btn-card">
                Acoge
            </a>
        </div>
        @endif
    </div>
</article>