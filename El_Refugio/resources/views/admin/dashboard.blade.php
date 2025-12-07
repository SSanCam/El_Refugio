{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.public')
@section('title', 'Panel de administración | El Refugio')

@section('content')
<section class="page-container">
    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">Panel de administración</h1>
        <p>
            Bienvenida, {{ Auth::user()->name }}. Desde aquí puedes gestionar los animales,
            usuarios y casos de adopción y acogida del refugio.
        </p>
    </header>

    {{-- Resumen de métricas principales: ANIMALES --}}
    <section class="section-block">
        <div class="dashboard-summary">
            {{-- Animales que han ingresado recientemente al refugio --}}
            <div class="contact-form-card dashboard-card">
                <p class="dashboard-card__label">Animales en el refugio</p>
                <p class="dashboard-card__value">
                    {{ $animalsSheltered ?? '-' }}
                </p>
            </div>
            {{-- Animales recientemente en acogida --}}
            <div class="contact-form-card dashboard-card">
                <p class="dashboard-card__label">Animales en acogida</p>
                <p class="dashboard-card__value">
                    {{ $animalsFostered ?? '-' }}
                </p>
            </div>
            {{-- Animales recientemente adoptados --}}
            <div class="contact-form-card dashboard-card">
                <p class="dashboard-card__label">Animales adoptados</p>
                <p class="dashboard-card__value">
                    {{ $animalsAdopted ?? '-' }}
                </p>
            </div>
        </div>
    </section>

    {{-- Resumen y manejo de los usuarios --}}

    {{-- Resumen y manejo de adopciones --}}

    {{-- Resumen y manejo de acogidas --}}

    {{-- Accesos rápidos --}}
    <section class="section-block">
        <h2 class="section-title" style="margin-bottom: 1rem;">
            Accesos rápidos
        </h2>

        <div class="dashboard-actions">
            <a href="{{ route('admin.animals.index') }}" class="btn-cta--global">
                Gestionar animales
            </a>

            <a href="{{ route('admin.users.index') }}" class="btn-cta--global">
                Gestionar usuarios
            </a>

            <a href="{{ route('admin.adoptions.index') }}" class="btn-cta--global">
                Ver adopciones
            </a>

            <a href="{{ route('admin.fosters.index') }}" class="btn-cta--global">
                Ver acogidas
            </a>
        </div>
    </section>
</section>
@endsection