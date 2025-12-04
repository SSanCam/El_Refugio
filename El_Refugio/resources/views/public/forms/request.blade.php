{{-- resources/views/public/forms/request.blade.php --}}
@extends('layouts.public')
@section('title', 'Solicitud de adopción o acogida | El Refugio')

@section('content')
<section class="page-container">

    <header class="section-block">
        <h1 class="section-title">Solicitud de adopción o acogida</h1>
        <p class="form-page__intro">
            Rellena este formulario para iniciar una solicitud de adopción o acogida.
            El equipo del refugio revisará tu solicitud y se pondrá en contacto contigo
            por los medios que indiques.
        </p>
        <p class="form-page__intro">
            Si tienes en mente algún peludo en concreto, indícalo en el mensaje.
            Ten en cuenta que los formularios definitivos se firman siempre de forma
            presencial en el refugio.
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

            {{-- Errores de validación --}}
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

            @php
                $selectedType = old('type', $type ?? '');
            @endphp

            <form method="POST"
                  action="{{ route('public.forms.request.send') }}"
                  class="contact-form">
                @csrf

                {{-- Tipo de solicitud --}}
                <div class="form-group">
                    <label for="type" class="form-label">
                        Tipo de solicitud
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="form-input @error('type') is-invalid @enderror"
                        required
                    >
                        <option value="">Selecciona una opción</option>
                        <option value="adoption" {{ $selectedType === 'adoption' ? 'selected' : '' }}>
                            Solicitud de adopción
                        </option>
                        <option value="foster" {{ $selectedType === 'foster' ? 'selected' : '' }}>
                            Solicitud de acogida
                        </option>
                    </select>
                    @error('type')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Peludo preseleccionado (si viene desde la ficha) --}}
                @if (!empty($animal))
                    <p class="form-label">
                        <strong>Peludo seleccionado:</strong>
                        {{ $animal->name }} (ID {{ $animal->id }})
                    </p>
                    <input type="hidden" name="animal_id" value="{{ $animal->id }}">
                @else
                    <input type="hidden" name="animal_id" value="{{ old('animal_id') }}">
                @endif

                {{-- Nombre --}}
                <div class="form-group">
                    <label for="name" class="form-label">
                        Nombre completo
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        value="{{ old('name') }}"
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
                        required
                        value="{{ old('email') }}"
                        class="form-input @error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div class="form-group">
                    <label for="phone" class="form-label">
                        Teléfono de contacto <span class="form-label__hint">(opcional)</span>
                    </label>
                    <input
                        id="phone"
                        name="phone"
                        type="text"
                        value="{{ old('phone') }}"
                        class="form-input @error('phone') is-invalid @enderror"
                    >
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mensaje --}}
                <div class="form-group">
                    <label for="message" class="form-label">
                        Mensaje <span class="form-label__hint">(opcional)</span>
                    </label>
                    <p class="form-label__hint">
                        Puedes contarnos tu situación, experiencia con animales y si te interesa
                        algún peludo en concreto.
                    </p>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        class="form-textarea @error('message') is-invalid @enderror"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="contact-form__actions">
                    <button type="submit" class="btn-cta--global">
                        Enviar solicitud
                    </button>
                </div>
            </form>
        </div>
    </section>

</section>
@endsection
