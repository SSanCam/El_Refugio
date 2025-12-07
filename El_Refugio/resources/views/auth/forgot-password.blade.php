{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.public')
@section('title', 'Recuperar contraseña | El Refugio')

@section('content')
<section class="page-container">

    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">Revisa tu correo</h1>
    </header>

    {{-- Tarjeta de mensaje --}}
    <section class="section-block">
        <div class="contact-form-card">
            @if (session('status'))
            <p class="form-alert form-alert--success" style="margin-top: 1rem;">
                {{ session('status') }}
            </p>
            @endif

            <p>
                Se ha enviado un enlace de reestablecimiento de contraseña a tu correo electrónico.
            </p>
            <div class="contact-form__actions">
                <a href="{{ route('login') }}" class="btn-cta--global">
                    Volver a iniciar sesión
                </a>
            </div>
        </div>
    </section>

</section>
@endsection