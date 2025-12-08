{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.public')
@section('title', 'Panel de administración | El Refugio')
@section('content')
<section class="page-container">
    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">El Refugio - Panel administrativo</h1>
    </header>

    {{-- Accesos rápidos --}}
    <section class="section-block">
        <h2 class="section-title" style="margin-bottom: 1rem;">
            Accesos rápidos
        </h2>
        <hr class="section-divider">
        <div class="dashboard-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-cta--global">Gestionar usuarios</a>
            <a href="{{ route('admin.animals.index') }}" class="btn-cta--global">Gestionar animales</a>
            <a href="{{ route('admin.adoptions.index') }}" class="btn-cta--global">Ver adopciones</a>
            <a href="{{ route('admin.fosters.index') }}" class="btn-cta--global">Ver acogidas</a>
        </div>

    </section>
</section>
@endsection