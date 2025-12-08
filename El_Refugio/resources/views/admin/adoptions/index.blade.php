@extends('layouts.public')

@section('title', 'Adopciones | Panel Admin')

@section('content')
<section class="page-container">

    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">Gestión de Adopciones</h1>
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
        <form method="GET" action="{{ route('admin.adoptions.index') }}" class="filter-bar__form">

            <input type="text" name="search" class="filter-input"
                placeholder="Buscar por nombre de animal o adoptante..." value="{{ $search ?? '' }}">

            <button type="submit" class="filter-btn">
                Buscar
            </button>

            @if(request('search'))
            <a href="{{ route('admin.adoptions.index') }}" class="filter-btn filter-btn--clear">
                Limpiar
            </a>
            @endif

        </form>
    </section>
    
    {{-- Tabla --}}
    <section class="section-block">
        <div class="admin-table-wrapper">

            @if ($adoptions->count())

            <table class="table-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Animal</th>
                        <th>Adoptante</th>
                        <th>Fecha</th>
                        <th>Contrato</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($adoptions as $adoption)
                    <tr>
                        <td>{{ $adoption->id }}</td>
                        <td>{{ $adoption->animal->name }}</td>
                        <td>{{ $adoption->user->name }} {{ $adoption->user->last_name }}</td>
                        <td>{{ $adoption->adoption_date }}</td>
                        <td>
                            @if ($adoption->contract_file)
                            <a href="{{ $adoption->contract_file }}" target="_blank" class="link">
                                Ver contrato
                            </a>
                            @else
                            No disponible
                            @endif
                        </td>

                        <td>
                            <div class="table-actions">

                                {{-- EDITAR --}}
                                <button class="btn-cta--global btn-sm" data-toggle="edit-adoption-{{ $adoption->id }}"
                                    data-label-open="Editar" data-label-close="Cerrar edición">
                                    Editar
                                </button>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('admin.adoptions.destroy', $adoption) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta adopción?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-cta--global btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    {{-- FORMULARIO EDITAR --}}
                    <tr class="form-row" data-target="edit-adoption-{{ $adoption->id }}" hidden>
                        <td colspan="6">

                            <div class="contact-form-card" style="margin-top: 1rem;">
                                <h3 class="section-subtitle">Editar adopción</h3>

                                <form method="POST" action="{{ route('admin.adoptions.update', $adoption) }}"
                                    class="contact-form">
                                    @csrf
                                    @method('PUT')

                                    {{-- Fecha --}}
                                    <div class="form-group">
                                        <label class="form-label">Fecha de adopción *</label>
                                        <input type="date" name="adoption_date" class="form-input"
                                            value="{{ old('adoption_date', $adoption->adoption_date) }}" required>
                                    </div>

                                    {{-- Contrato --}}
                                    <div class="form-group">
                                        <label class="form-label">Contrato (URL o identificador)</label>
                                        <input type="text" name="contract_file" class="form-input"
                                            value="{{ old('contract_file', $adoption->contract_file) }}">
                                    </div>

                                    {{-- Comentarios --}}
                                    <div class="form-group">
                                        <label class="form-label">Comentarios</label>
                                        <textarea name="comments"
                                            class="form-input">{{ old('comments', $adoption->comments) }}</textarea>
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
                {{ $adoptions->links() }}
            </div>

            @else
            <p>No hay adopciones registradas todavía.</p>
            @endif

        </div>
    </section>

    {{-- Crear adopción --}}
    <div class="section-block" style="text-align:center; margin-top:2rem;">
        <button class="btn-cta--global" data-toggle="create-adoption" data-label-open="Registrar nueva adopción"
            data-label-close="Cerrar formulario">
            Crear nueva adopción
        </button>
    </div>

    {{-- FORMULARIO OCULTO CREAR --}}
    <section class="section-block" data-target="create-adoption" hidden>
        <div class="contact-form-card">
            <h3 class="section-subtitle">Registrar nueva adopción</h3>

            <form method="POST" action="{{ route('admin.adoptions.store') }}" class="contact-form">
                @csrf

                {{-- Animal --}}
                <div class="form-group">
                    <label class="form-label">Animal *</label>
                    <select name="animal_id" class="form-input" required>
                        @foreach (App\Models\Animal::where('availability','available')->get() as $animal)
                        <option value="{{ $animal->id }}">
                            {{ $animal->name }} ({{($animal->species) }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha --}}
                <div class="form-group">
                    <label class="form-label">Fecha de adopción *</label>
                    <input type="date" name="adoption_date" class="form-input" required>
                </div>

                <hr class="section-divider">
                <h4>Datos del adoptante</h4>

                {{-- Nombre --}}
                <div class="form-group">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                {{-- Apellidos --}}
                <div class="form-group">
                    <label class="form-label">Apellidos *</label>
                    <input type="text" name="last_name" class="form-input" required>
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-input" required>
                </div>

                {{-- DNI / NIE --}}
                <div class="form-group">
                    <label class="form-label">DNI / NIE</label>
                    <input type="text" name="national_id" class="form-input">
                </div>

                {{-- Teléfono --}}
                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-input">
                </div>

                {{-- Dirección --}}
                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-input">
                </div>

                {{-- Contrato --}}
                <div class="form-group">
                    <label class="form-label">Contrato (URL o identificador)</label>
                    <input type="text" name="contract_file" class="form-input">
                </div>

                {{-- Comentarios --}}
                <div class="form-group">
                    <label class="form-label">Comentarios</label>
                    <textarea name="comments" class="form-input"></textarea>
                </div>

                <button type="submit" class="btn-cta--global">
                    Registrar adopción
                </button>

            </form>

        </div>
    </section>

</section>
@endsection