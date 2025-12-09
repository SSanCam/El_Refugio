@extends('layouts.public')

@section('title', 'Animales | Panel Admin')

@section('content')
<section class="page-container">

    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">Gestión de Animales</h1>
        <hr class="section-divider">

        <x-admin-nav />
    </header>

    {{-- Barra de filtros --}}
    <section class="filter-bar">
        <form method="GET" action="{{ route('admin.animals.index') }}" class="filter-bar__form">

            <input type="text" name="search" class="filter-input"
                placeholder="Buscar animal por nombre, raza o microchip..." value="{{ $search ?? '' }}">

            <button type="submit" class="filter-btn">
                Buscar
            </button>

            @if(request('search'))
            <a href="{{ route('admin.animals.index') }}" class="filter-btn filter-btn--clear">
                Limpiar
            </a>
            @endif

        </form>
    </section>

    {{-- Tabla --}}
    <section class="section-block">
        <div class="admin-table-wrapper">

            @if ($animals->count())

            <table class="table-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Especie</th>
                        <th>Estado</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($animals as $animal)
                    <tr>
                        <td>{{ $animal->id }}</td>
                        <td>{{ $animal->name }}</td>
                        <td>{{ ($animal->species) }}</td>
                        <td>{{ ($animal->status) }}</td>
                        <td>{{ $animal->availability === 'available' ? 'Disponible' : 'No disponible' }}</td>

                        <td>
                            <div class="table-actions">

                                {{-- BOTÓN EDITAR --}}
                                <button class="btn-cta--global btn-sm" data-toggle="edit-animal-{{ $animal->id }}"
                                    data-label-open="Editar" data-label-close="Cerrar edición">
                                    Editar
                                </button>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('admin.animals.destroy', $animal) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este animal?');">
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
                    <tr class="form-row" data-target="edit-animal-{{ $animal->id }}" hidden>
                        <td colspan="6">

                            <div class="contact-form-card" style="margin-top: 1rem;">
                                <h3 class="section-subtitle">Editar animal</h3>

                                <form method="POST" action="{{ route('admin.animals.update', $animal) }}"
                                    class="contact-form">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nombre --}}
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="name" class="form-input"
                                            value="{{ old('name', $animal->name) }}" required>
                                    </div>

                                    {{-- Especie --}}
                                    <div class="form-group">
                                        <label class="form-label">Especie *</label>
                                        <select name="species" class="form-input" required>
                                            <option value="dog" {{ $animal->species=='dog'?'selected':'' }}>Perro
                                            </option>
                                            <option value="cat" {{ $animal->species=='cat'?'selected':'' }}>Gato
                                            </option>
                                            <option value="other" {{ $animal->species=='other'?'selected':'' }}>Otro
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Raza --}}
                                    <div class="form-group">
                                        <label class="form-label">Raza</label>
                                        <input type="text" name="breed" class="form-input"
                                            value="{{ old('breed', $animal->breed) }}">
                                    </div>

                                    {{-- Sexo --}}
                                    <div class="form-group">
                                        <label class="form-label">Sexo</label>
                                        <select name="sex" class="form-input">
                                            <option value="">Sin especificar</option>
                                            <option value="male" {{ $animal->sex=='male'?'selected':'' }}>Macho</option>
                                            <option value="female" {{ $animal->sex=='female'?'selected':'' }}>Hembra
                                            </option>
                                            <option value="unknown" {{ $animal->sex=='unknown'?'selected':'' }}>
                                                Desconocido</option>
                                        </select>
                                    </div>

                                    {{-- Tamaño --}}
                                    <div class="form-group">
                                        <label class="form-label">Tamaño</label>
                                        <select name="size" class="form-input">
                                            <option value="">No especificado</option>
                                            <option value="small" {{ $animal->size=='small'?'selected':'' }}>Pequeño
                                            </option>
                                            <option value="medium" {{ $animal->size=='medium'?'selected':'' }}>Mediano
                                            </option>
                                            <option value="large" {{ $animal->size=='large'?'selected':'' }}>Grande
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Peso --}}
                                    <div class="form-group">
                                        <label class="form-label">Peso (kg)</label>
                                        <input type="number" step="0.1" name="weight" class="form-input"
                                            value="{{ old('weight', $animal->weight) }}">
                                    </div>

                                    {{-- Altura --}}
                                    <div class="form-group">
                                        <label class="form-label">Altura (cm)</label>
                                        <input type="number" step="0.1" name="height" class="form-input"
                                            value="{{ old('height', $animal->height) }}">
                                    </div>

                                    {{-- Esterilizado --}}
                                    <div class="form-group">
                                        <label class="form-label">Esterilizado</label>
                                        <select name="neutered" class="form-input">
                                            <option value="0" {{ !$animal->neutered ? 'selected':'' }}>No</option>
                                            <option value="1" {{ $animal->neutered ? 'selected':'' }}>Sí</option>
                                        </select>
                                    </div>

                                    {{-- Microchip --}}
                                    <div class="form-group">
                                        <label class="form-label">Microchip</label>
                                        <input type="text" name="microchip" class="form-input"
                                            value="{{ old('microchip', $animal->microchip) }}">
                                    </div>

                                    {{-- Fecha nacimiento --}}
                                    <div class="form-group">
                                        <label class="form-label">Fecha nacimiento</label>
                                        <input type="date" name="birth_date" class="form-input"
                                            value="{{ old('birth_date', $animal->birth_date) }}">
                                    </div>

                                    {{-- Estado --}}
                                    <div class="form-group">
                                        <label class="form-label">Estado *</label>
                                        <select name="status" class="form-input" required>
                                            <option value="sheltered" {{ $animal->status=='sheltered'?'selected':'' }}>
                                                En refugio</option>
                                            <option value="adopted" {{ $animal->status=='adopted'?'selected':'' }}>
                                                Adoptado</option>
                                            <option value="fostered" {{ $animal->status=='fostered'?'selected':'' }}>
                                                Acogido</option>
                                            <option value="deceased" {{ $animal->status=='deceased'?'selected':'' }}>
                                                Fallecido</option>
                                        </select>
                                    </div>

                                    {{-- Disponibilidad --}}
                                    <div class="form-group">
                                        <label class="form-label">Disponibilidad *</label>
                                        <select name="availability" class="form-input" required>
                                            <option value="available"
                                                {{ $animal->availability=='available'?'selected':'' }}>Disponible
                                            </option>
                                            <option value="unavailable"
                                                {{ $animal->availability=='unavailable'?'selected':'' }}>No disponible
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Fecha entrada --}}
                                    <div class="form-group">
                                        <label class="form-label">Fecha de entrada *</label>
                                        <input type="date" name="entry_date" class="form-input"
                                            value="{{ old('entry_date', $animal->entry_date) }}" required>
                                    </div>

                                    {{-- Descripción --}}
                                    <div class="form-group">
                                        <label class="form-label">Descripción</label>
                                        <textarea name="description"
                                            class="form-input">{{ old('description', $animal->description) }}</textarea>
                                    </div>

                                    {{-- Observaciones --}}
                                    <div class="form-group">
                                        <label class="form-label">Observaciones</label>
                                        <textarea name="observations"
                                            class="form-input">{{ old('observations', $animal->observations) }}</textarea>
                                    </div>

                                    {{-- Destacado --}}
                                    <div class="form-group">
                                        <label class="form-label">Destacado</label>
                                        <select name="is_featured" class="form-input">
                                            <option value="0" {{ !$animal->is_featured?'selected':'' }}>No</option>
                                            <option value="1" {{ $animal->is_featured?'selected':'' }}>Sí</option>
                                        </select>
                                    </div>
                                    <hr class="section-divider">
                                    {{-- AÑADIR FOTO --}}
                                    <div class="form-group">
                                        <label class="form-label">Añadir foto (URL)</label>
                                        <input type="url" name="photo_url" class="form-input">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Texto alternativo</label>
                                        <input type="text" name="photo_alt" class="form-input">
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

            {{-- Paginacion de la tabla --}}
            <div style="margin-top: 1rem;">
                <x-pagination :currentPage="$animals->currentPage()" :lastPage="$animals->lastPage()"
                    :prevPageUrl="$animals->previousPageUrl()" :nextPageUrl="$animals->nextPageUrl()" />
            </div>

            @else
            <p>No hay animales registrados todavía.</p>
            @endif

        </div>
    </section>

    {{-- Crear animal --}}
    <div class="section-block" style="text-align:center; margin-top:2rem;">
        <button class="btn-cta--global" data-toggle="create-animal" data-label-open="Registrar nuevo animal"
            data-label-close="Cerrar formulario">
            Crear nuevo animal
        </button>
    </div>

    {{-- FORMULARIO OCULTO CREAR --}}
    <section class="section-block" data-target="create-animal" hidden>
        <div class="contact-form-card">
            <h3 class="section-subtitle">Registrar nuevo animal</h3>

            <form method="POST" action="{{ route('admin.animals.store') }}" class="contact-form">
                @csrf

                {{-- Nombre --}}
                <div class="form-group">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                {{-- Especie --}}
                <div class="form-group">
                    <label class="form-label">Especie *</label>
                    <select name="species" class="form-input" required>
                        <option value="dog">Perro</option>
                        <option value="cat">Gato</option>
                        <option value="other">Otro</option>
                    </select>
                </div>

                {{-- Raza --}}
                <div class="form-group">
                    <label class="form-label">Raza</label>
                    <input type="text" name="breed" class="form-input">
                </div>

                {{-- Sexo --}}
                <div class="form-group">
                    <label class="form-label">Sexo</label>
                    <select name="sex" class="form-input">
                        <option value="">Sin especificar</option>
                        <option value="male">Macho</option>
                        <option value="female">Hembra</option>
                        <option value="unknown">Desconocido</option>
                    </select>
                </div>

                {{-- Tamaño --}}
                <div class="form-group">
                    <label class="form-label">Tamaño</label>
                    <select name="size" class="form-input">
                        <option value="">No especificado</option>
                        <option value="small">Pequeño</option>
                        <option value="medium">Mediano</option>
                        <option value="large">Grande</option>
                    </select>
                </div>

                {{-- Peso --}}
                <div class="form-group">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.1" name="weight" class="form-input">
                </div>

                {{-- Altura --}}
                <div class="form-group">
                    <label class="form-label">Altura (cm)</label>
                    <input type="number" step="0.1" name="height" class="form-input">
                </div>

                {{-- Esterilizado --}}
                <div class="form-group">
                    <label class="form-label">Esterilizado</label>
                    <select name="neutered" class="form-input">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>

                {{-- Microchip --}}
                <div class="form-group">
                    <label class="form-label">Microchip</label>
                    <input type="text" name="microchip" class="form-input">
                </div>

                {{-- Fecha nacimiento --}}
                <div class="form-group">
                    <label class="form-label">Fecha nacimiento</label>
                    <input type="date" name="birth_date" class="form-input">
                </div>

                {{-- Estado --}}
                <div class="form-group">
                    <label class="form-label">Estado *</label>
                    <select name="status" class="form-input" required>
                        <option value="sheltered">En refugio</option>
                        <option value="adopted">Adoptado</option>
                        <option value="fostered">Acogido</option>
                        <option value="deceased">Fallecido</option>
                    </select>
                </div>

                {{-- Disponibilidad --}}
                <div class="form-group">
                    <label class="form-label">Disponibilidad *</label>
                    <select name="availability" class="form-input" required>
                        <option value="available">Disponible</option>
                        <option value="unavailable">No disponible</option>
                    </select>
                </div>

                {{-- Fecha entrada --}}
                <div class="form-group">
                    <label class="form-label">Fecha entrada *</label>
                    <input type="date" name="entry_date" class="form-input" required>
                </div>

                {{-- Descripción --}}
                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-input"></textarea>
                </div>

                {{-- Observaciones --}}
                <div class="form-group">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observations" class="form-input"></textarea>
                </div>

                {{-- Destacado --}}
                <div class="form-group">
                    <label class="form-label">Destacado</label>
                    <select name="is_featured" class="form-input">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>

                {{-- Foto --}}
                <div class="form-group">
                    <label class="form-label">Foto principal (URL)</label>
                    <input type="url" name="photo_url" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Texto alternativo</label>
                    <input type="text" name="photo_alt" class="form-input">
                </div>

                <button type="submit" class="btn-cta--global">
                    Registrar animal
                </button>

            </form>

        </div>
    </section>

</section>
@endsection