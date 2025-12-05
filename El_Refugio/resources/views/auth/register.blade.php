{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.public')

@section('title', 'Crear cuenta | El Refugio')
@section('meta_robots', 'noindex,follow')

@section('content')
<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Crear una cuenta</h1>
        <p class="form-page__intro">
            Crea tu cuenta para poder gestionar solicitudes y datos del refugio, o para seguir
            el estado de tus adopciones y acogidas.
        </p>
    </header>

    <section class="section-block">
        <div class="contact-form-card">

            {{-- Errores de validación globales --}}
            @if ($errors->any())
                <div class="form-alert form-alert--error">
                    <p><strong>Ha habido algunos errores:</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="contact-form">
                @csrf

                {{-- Nombre --}}
                <div class="form-group">
                    <label for="name" class="form-label">
                        Nombre
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="form-input @error('name') is-invalid @enderror"
                    >
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">
                        Correo electrónico
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="form-input @error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="form-group">
                    <label for="password" class="form-label">
                        Contraseña
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="form-input @error('password') is-invalid @enderror"
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmación de contraseña --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        Repite la contraseña
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="form-input"
                    >
                </div>

                <div class="contact-form__actions" style="justify-content: space-between; gap:.75rem;">
                    <a href="{{ route('login') }}">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                    <button type="submit" class="btn-cta--global">
                        Registrarme
                    </button>
                </div>
            </form>
        </div>
    </section>

</section>
@endsection
