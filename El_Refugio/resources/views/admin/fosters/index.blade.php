@extends('layouts.public')

@section('title', 'Acogidas | Panel Admin')

@section('content')
<section class="page-container">

    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">Gestión de Acogidas</h1>
        <hr class="section-divider">

        <div class="dashboard-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-cta--global">Gestionar usuarios</a>
            <a href="{{ route('admin.animals.index') }}" class="btn-cta--global">Gestionar animales</a>
            <a href="{{ route('admin.adoptions.index') }}" class="btn-cta--global">Ver adopciones</a>
            <a href="{{ route('admin.fosters.index') }}" class="btn-cta--global">Ver acogidas</a>
        </div>
    </header>

    <a href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
    <hr class="section-divider">

    {{-- Barra de filtros --}}
    <section class="filter-bar">
        <form method="GET" action="{{ route('admin.fosters.index') }}" class="filter-bar__form">

            <input 
                type="text"
                name="search"
                class="filter-input"
                placeholder="Buscar por animal o tutor..."
                value="{{ $search ?? '' }}"
            >

            <button type="submit" class="filter-btn">
                Buscar
            </button>

            @if(request('search'))
            <a href="{{ route('admin.fosters.index') }}" class="filter-btn filter-btn--clear">
                Limpiar
            </a>
            @endif

        </form>
    </section>

    {{-- Tabla --}}
    <section class="section-block">
        <div class="admin-table-wrapper">

            @if ($fosters->count())

            <table class="table-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Animal</th>
                        <th>Tutor</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Contrato</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($fosters as $foster)
                    <tr>
                        <td>{{ $foster->id }}</td>
                        <td>{{ $foster->animal->name }}</td>
                        <td>{{ $foster->user->name }} {{ $foster->user->last_name }}</td>
                        <td>{{ $foster->start_date }}</td>
                        <td>{{ $foster->end_date ?? 'En curso' }}</td>

                        {{-- ENLACE A CONTRATO --}}
                        <td>
                            @if ($foster->contract_file)
                                <a href="{{ $foster->contract_file }}" target="_blank">Ver contrato</a>
                            @else
                                No disponible
                            @endif
                        </td>

                        <td>
                            <div class="table-actions">

                                {{-- EDITAR --}}
                                <button
                                    class="btn-cta--global btn-sm"
                                    data-toggle="edit-foster-{{ $foster->id }}"
                                    data-label-open="Editar"
                                    data-label-close="Cerrar edición">
                                    Editar
                                </button>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('admin.fosters.destroy', $foster) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar esta acogida?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-cta--global btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    {{-- FORMULARIO OCULTO EDITAR --}}
                    <tr class="form-row" data-target="edit-foster-{{ $foster->id }}" hidden>
                        <td colspan="7">

                            <div class="contact-form-card" style="margin-top: 1rem;">
                                <h3 class="section-subtitle">Editar acogida</h3>

                                <form method="POST"
                                      action="{{ route('admin.fosters.update', $foster) }}"
                                      class="contact-form">
                                    @csrf
                                    @method('PUT')

                                    {{-- Animal --}}
                                    <div class="form-group">
                                        <label class="form-label">Animal *</label>
                                        <select name="animal_id" class="form-input" required>
                                            @foreach ($animals = App\Models\Animal::where('status','sheltered')->orWhere('id',$foster->animal_id)->get() as $animal)
                                                <option value="{{ $animal->id }}"
                                                    {{ $animal->id == $foster->animal_id ? 'selected' : '' }}>
                                                    {{ $animal->name }} ({{ ($animal->species) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Fechas --}}
                                    <div class="form-group">
                                        <label class="form-label">Fecha inicio *</label>
                                        <input type="date" name="start_date" class="form-input"
                                               value="{{ old('start_date', $foster->start_date) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Fecha fin</label>
                                        <input type="date" name="end_date" class="form-input"
                                               value="{{ old('end_date', $foster->end_date) }}">
                                    </div>

                                    <hr class="section-divider">
                                    <h4>Datos del tutor de acogida</h4>

                                    {{-- Tutor --}}
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="name" class="form-input"
                                               value="{{ old('name', $foster->user->name) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Apellidos *</label>
                                        <input type="text" name="last_name" class="form-input"
                                               value="{{ old('last_name', $foster->user->last_name) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-input"
                                               value="{{ old('email', $foster->user->email) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">DNI / NIE</label>
                                        <input type="text" name="national_id" class="form-input"
                                               value="{{ old('national_id', $foster->user->national_id) }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="phone" class="form-input"
                                               value="{{ old('phone', $foster->user->phone) }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" name="address" class="form-input"
                                               value="{{ old('address', $foster->user->address) }}">
                                    </div>

                                    {{-- Datos del refugio --}}
                                    <div class="form-group">
                                        <label class="form-label">Contrato (URL o identificador)</label>
                                        <input type="text" name="contract_file" class="form-input"
                                               value="{{ old('contract_file', $foster->contract_file) }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Comentarios</label>
                                        <textarea name="comments" class="form-input">{{ old('comments', $foster->comments) }}</textarea>
                                    </div>

                                    <button type="submit" class="btn-cta--global">
                                        Guardar cambios
                                    </button>

                                </form>
                            </div>

                        </td>
                    </tr>

                    @endforeach
                </tbody>

            </table>

            <div style="margin-top: 1rem;">
                {{ $fosters->links() }}
            </div>

            @else
            <p>No hay acogidas registradas todavía.</p>
            @endif

        </div>
    </section>

    {{-- Crear adopción --}}
    <div class="section-block" style="text-align:center; margin-top:2rem;">
        <button class="btn-cta--global"
                data-toggle="create-foster"
                data-label-open="Registrar nueva acogida"
                data-label-close="Cerrar formulario">
            Crear nueva acogida
        </button>
    </div>

    {{-- FORMULARIO OCULTO CREAR --}}
    <section class="section-block" data-target="create-foster" hidden>
        <div class="contact-form-card">
            <h3 class="section-subtitle">Registrar nueva acogida</h3>

            <form method="POST" action="{{ route('admin.fosters.store') }}" class="contact-form">
                @csrf

                {{-- Animal --}}
                <div class="form-group">
                    <label class="form-label">Animal *</label>
                    <select name="animal_id" class="form-input" required>
                        @foreach (App\Models\Animal::where('status','sheltered')->get() as $animal)
                            <option value="{{ $animal->id }}">
                                {{ $animal->name }} ({{ ($animal->species) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fechas --}}
                <div class="form-group">
                    <label class="form-label">Fecha inicio *</label>
                    <input type="date" name="start_date" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha fin</label>
                    <input type="date" name="end_date" class="form-input">
                </div>

                <hr class="section-divider">
                <h4>Datos del tutor de acogida</h4>

                {{-- Tutor --}}
                <div class="form-group">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Apellidos *</label>
                    <input type="text" name="last_name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">DNI / NIE</label>
                    <input type="text" name="national_id" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-input">
                </div>

                {{-- Datos internos --}}
                <div class="form-group">
                    <label class="form-label">Contrato (URL o identificador)</label>
                    <input type="text" name="contract_file" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Comentarios</label>
                    <textarea name="comments" class="form-input"></textarea>
                </div>

                <button type="submit" class="btn-cta--global">
                    Registrar acogida
                </button>

            </form>

        </div>
    </section>

</section>
@endsection
