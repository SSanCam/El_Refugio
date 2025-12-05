{{-- resources/views/public/forms/contact.blade.php --}}
@extends('layouts.public')

@section('title', 'Contacto | El Refugio')

@section('meta_description', 'Formulario de contacto de El Refugio para resolver dudas sobre adopciones, acogidas y la gestión del refugio.')
@section('meta_keywords', 'contacto refugio de animales, dudas adopción, formulario de contacto, acogida perros gatos')

@section('content')
<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Formulario de contacto</h1>
        <p>
            Si tienes dudas sobre el refugio, las adopciones o cualquier otra consulta,
            puedes escribirnos a través de este formulario. Te responderemos lo antes posible.
        </p>
    </header>

    <section class="section-block">
        <div class="contact-form-card">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <p class="form-alert form-alert--success">
                    {{ session('success') }}
                </p>
            @endif

            <form method="POST"
                  action="{{ route('public.forms.contact.send') }}"
                  class="contact-form">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">
                        Nombre <span class="form-label__hint">(opcional)</span>
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-input @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        Correo electrónico
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject" class="form-label">
                        Asunto
                    </label>
                    <input
                        id="subject"
                        name="subject"
                        type="text"
                        required
                        class="form-input @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}"
                    >
                    @error('subject')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">
                        Mensaje
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        class="form-textarea @error('message') is-invalid @enderror"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="contact-form__actions">
                    <button type="submit" class="btn-cta--global">
                        Enviar mensaje
                    </button>
                </div>
            </form>
        </div>
    </section>
</section>
@endsection
