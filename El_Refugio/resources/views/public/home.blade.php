{{-- resources/views/public/home.blade.php --}}
@extends('layouts.public')

@section('title', 'Inicio | El Refugio')

@section('content')
<section class="page-container">

    @section('content')
    <section class="page-container">

        {{-- Hero / bienvenida --}}
        <header class="section-block">
            <h1 class="section-title">Bienvenida a El Refugio</h1>
            <h3>
                Esta aplicación ayuda a gestionar los animales del refugio, sus adopciones y acogidas,
                y a conectar a las personas interesadas con el equipo responsable.
            </h3>
            <p>
                El objetivo es ofrecer una herramienta sencilla y centralizada para que cualquier refugio
                pueda mantener actualizada la información de sus animales, organizar solicitudes y
                mejorar la comunicación con las personas interesadas en adoptar o acoger.
            </p>
        </header>

        {{-- Sobre el refugio / proyecto --}}
        <section class="section-block section-grid section-grid--center">
            <article class="info-card">
                <h2 class="section-subtitle">Sobre nosotros</h2>
                <p>
                    El Refugio se presenta como un proyecto de código abierto pensado para refugios
                    pequeños y medianos. La plataforma permite registrar animales, hacer seguimiento
                    de su historia y mostrar solo la información relevante en la web pública.
                </p>
                <p>
                    Aunque los datos y las imágenes de esta web pertenecen a un entorno de pruebas,
                    el flujo de trabajo simula el día a día real de un refugio: entrada de animales,
                    valoración veterinaria, difusión responsable y gestión de solicitudes.
                </p>
            </article>

            <aside class="info-card">
                <figure>
                    <img src="https://images.pexels.com/photos/5731865/pexels-photo-5731865.jpeg"
                        alt="Vista general de un refugio de animales"
                        style="width: 100%; border-radius: 12px; display:block;">

                </figure>
            </aside>
        </section>

        {{-- Separador visual entre secciones --}}
        <hr class="section-divider">

        {{-- Accesos rápidos --}}

        <section class="section-block section-grid section-grid--with-dividers">

            <article class="info-card">
                <h2 class="section-subtitle">Quiero conocer a los peludos</h2>
                <p>Consulta los animales que están actualmente disponibles en el refugio.</p>
                <p>
                    <a href="{{ route('public.animals.index') }}">
                        Ver animales en adopción y acogida
                    </a>
                </p>
            </article>

            <article class="info-card">
                <h2 class="section-subtitle">Quiero contactar con el refugio</h2>
                <p>Si tienes dudas o consultas generales, puedes escribirnos desde el formulario de contacto.</p>
                <p>
                    <a href="{{ route('public.forms.contact') }}">
                        Ir al formulario de contacto
                    </a>
                </p>
            </article>

            <article class="info-card">
                <h2 class="section-subtitle">Acceso para personas registradas</h2>
                <p>
                    El personal del refugio y las personas usuarias pueden acceder con su cuenta
                    para gestionar datos y solicitudes.
                </p>
                <p>
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                    @if (Route::has('register'))
                    &nbsp;|&nbsp;
                    <a href="{{ route('register') }}">Crear cuenta</a>
                    @endif
                </p>
            </article>
        </section>

        {{-- Separador visual entre secciones --}}
        <hr class="section-divider">

        {{-- Explicación del flujo --}}
        <section class="section-block">
            <h2 class="section-subtitle">¿Cómo funciona El Refugio?</h2>
            <ol class="steps-list">
                <li>El refugio registra los animales y su situación en el sistema.</li>
                <li>Las personas interesadas consultan la ficha de cada animal desde la web pública.</li>
                <li>Desde la ficha o los formularios, se registran solicitudes de adopción o acogida.</li>
                <li>El equipo administrativo gestiona las solicitudes y actualiza el estado de cada animal.</li>
            </ol>
        </section>

        {{-- Separador visual entre secciones --}}
        <hr class="section-divider">

        {{-- Explicación de la plataforma --}}
        <section class="section-block">
            <h2 class="section-subtitle">Una herramienta abierta para refugios</h2>
            <div class="section-cta">
                <a href="{{ route('public.animals.index') }}" class="btn-cta">
                    Ver animales en adopción
                </a>
                <a href="{{ route('login') }}" class="btn-cta btn-cta--outline">
                    Acceso para refugios
                </a>
            </div>
        </section>

        {{-- Características principales --}}
        <section class="section-block section-grid">
            <article class="info-card">
                <h3 class="section-subtitle">Para refugios</h3>
                <ul class="steps-list">
                    <li>Listado de animales con estado y disponibilidad.</li>
                    <li>Registro de adopciones y acogidas.</li>
                    <li>Gestión de usuarios y roles (admin / usuario).</li>
                </ul>
            </article>

            <article class="info-card">
                <h3 class="section-subtitle">Para personas adoptantes</h3>
                <ul class="steps-list">
                    <li>Consulta de fichas detalladas de cada animal.</li>
                    <li>Formularios de contacto y solicitud.</li>
                    <li>Comunicación centralizada con el refugio.</li>
                </ul>
            </article>
        </section>

    </section>
    @endsection