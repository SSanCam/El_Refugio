{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.public')

@section('title', 'Iniciar sesión | El Refugio')
@section('meta_robots', 'noindex,follow')

@section('content')
<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Iniciar sesión</h1>
        <p>
            Accede con tu cuenta para gestionar solicitudes, adopciones y datos del refugio.
        </p>
    </header>

    <section class="section-block">
        <div class="contact-form-card">

            {{-- Mensaje de estado (por ejemplo, “se ha enviado el enlace de contraseña”) --}}
            @if (session('status'))
                <p class="form-alert form-alert--success">
                    {{ session('status') }}
                </p>
            @endif

            <form method="POST" action="{{ route('login') }}" class="contact-form">
                @csrf

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
                        autocomplete="username"
                        autofocus
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
                        autocomplete="current-password"
                        class="form-input @error('password') is-invalid @enderror"
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <div class="form-group" style="flex-direction: row; align-items: center; gap: .4rem;">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me" class="form-label" style="font-weight: normal;">
                        Recordarme
                    </label>
                </div>

                <div class="contact-form__actions" style="justify-content: space-between; gap:.75rem;">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            ¿Has olvidado tu contraseña?
                        </a>
                    @endif

                    <button type="submit" class="btn-cta--global">
                        Iniciar sesión
                    </button>
                </div>

                <p class="form-label__hint" style="margin-top: 1rem;">
                    ¿Aún no tienes cuenta?
                    <a href="{{ route('register') }}">Regístrate</a>
                </p>
            </form>
        </div>
    </section>

</section>
@endsection
