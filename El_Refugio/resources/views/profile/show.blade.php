d{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.public')
@section('title', 'Mi área | El Refugio')

@section('content')

<section class="page-container">
    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">
            Hola, {{ Auth::user()->name }}!
        </h1>
    </header>

    {{-- Tarjeta para perfil --}}
    <section class="section-block">
        <div class="contact-form-card profile-card">
            {{-- Imagen de perfil --}}
            <div class="profile-image-container">
                @if (Auth::user()->profile_picture)
                <img src="{{ Auth::user()->profile_picture }}" alt="Imagen de perfil de {{ Auth::user()->name }}"
                    class="profile-image">
                @else
                <img src="https://res.cloudinary.com/dkfvic2ks/image/upload/v1765103700/default-profile_ckhafj.png"
                    alt="Imagen de perfil por defecto" class="profile-image">
                @endif
            </div>

            {{-- Información del usuario --}}
            <div class="profile-info">
                <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>

            {{-- Mostrar/ocultar edición --}}
            <div class="contact-form__actions" style="margin-top: 1.5rem;">
                <button class="btn-cta--global" type="button" data-profile-edit-toggle
                    data-label-open="Editar mis datos" data-label-close="Cerrar edición" aria-expanded="false"
                    aria-controls="profile-edit-form">
                    Editar mis datos
                </button>
            </div>

            {{-- Contenedor de edición de perfil --}}
            <div id="profile-edit-form" class="profile-edit-container" data-profile-edit-container hidden>
                <form method="POST" action="{{ route('profile.update') }}" class="contact-form">
                    @csrf
                    @method('PATCH')

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" name="name" type="text" class="form-input @error('name') is-invalid @enderror"
                            value="{{ old('name', Auth::user()->name) }}"
                            placeholder="Tu nuevo nombre">
                        @error('name')
                        <p class="form-error"> {{ $message }} </p>
                        @enderror
                    </div>
                    {{-- Correo --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" name="email" type="email" required
                            class="form-input @error('email') is-invalid @enderror"
                            value="{{ old('email', Auth::user()->email) }}"
                            placeholder="ejemplo@correo.es">
                        @error('email')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Imagen de perfil por URL --}}
                    <div class="form-group">
                        <label for="profile-picture" class="form-label">
                            Imagen de perfil (URL)
                        </label>
                        <input
                            id="profile_picture"
                            name="profile_picture"
                            type="url"
                            class="form-input @error('profile_picture') is-invalid @enderror"
                            value="{{ old('profile_picture', Auth::user()->profile_picture) }}"
                            placeholder="https://...">
                    </div>

                    {{-- Cambiar clave --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            id="password"
                            name="password"
                            type="text"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Nueva contraseña">
                    </div>

                    <div class="contact-form__actions">
                        <button type="submit" class="btn-cta--global">
                            Guardar cambios
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </section>

</section>
@endsection