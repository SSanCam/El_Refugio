{{-- resources/views/auth/forgot-password-confirm.blade.php (por ejemplo) --}}
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
            <p>
                Se ha enviado una clave de acceso temporal a tu correo electrónico.
            </p>
            <div class="contact-form__actions" style="margin-top: 1.5rem;">
                <a href="{{ route('login') }}" class="btn-cta--global">
                    Volver a iniciar sesión
                </a>
            </div>
        </div>
    </section>

</section>
@endsection
