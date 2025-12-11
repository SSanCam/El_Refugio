{{-- resources/views/public/home.blade.php --}}
@extends('layouts.public')
@section('title', 'Inicio | El Refugio')

@section('meta_description', 'El Refugio es una plataforma para gestionar refugios de animales, adopciones y acogidas.')
@section('meta_keywords', 'el refugio, gestión refugios, adopción online, acogida animales')

@section('content')
<section class="page-container">

    {{-- Hero / bienvenida --}}
    <header class="section-block">
        <h1 class="section-title">Te damos la bienvenida a El Refugio</h1>
        <div class="hero-banner">
            <img src="https://res.cloudinary.com/dkfvic2ks/image/upload/v1764654037/ChatGPT_Image_2_dic_2025_06_40_22_r37dyx.png"
                alt="Vista general de un refugio de animales" class="hero-banner__img">
        </div>

        <p>
            Esta aplicación ayuda a gestionar los animales del refugio, sus adopciones y acogidas,
            y a conectar a las personas interesadas con el equipo responsable.
        </p>
        <p>
            El objetivo es ofrecer una herramienta sencilla y centralizada para que cualquier refugio
            pueda mantener actualizada la información de sus animales, organizar solicitudes
            y mejorar la comunicación con las personas interesadas en adoptar o acoger.
        </p>
    </header>
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
            <figure class="about-photo">
                <img src="https://images.pexels.com/photos/5731865/pexels-photo-5731865.jpeg"
                    alt="Perro pequeño posando en un fondo claro" class="about-photo__img">
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

            <div class="section-cta">
                <a href="{{ route('login') }}" class="btn-cta--global">
                    Iniciar sesión
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-cta--global">
                    Crear cuenta
                </a>
                @endif
            </div>
        </article>
    </section>

    {{-- Separador visual entre secciones --}}
    <hr class="section-divider">

    {{-- Explicación de la plataforma --}}
    <section class="section-block">
        <h2 class="section-subtitle">Una herramienta abierta para refugios</h2>

        <div class="section-cta">
            <a href="{{ route('public.animals.index') }}" class="btn-cta--global">
                Ver animales en adopción
            </a>
            <a href="{{ route('login') }}" class="btn-cta--global">
                Acceso al refugio
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