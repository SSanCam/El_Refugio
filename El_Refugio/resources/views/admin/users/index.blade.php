{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.public')

@section('title', 'Usuarios | Panel Admin')

@section('content')
<section class="page-container">

    {{-- Cabecera --}}
    <header class="section-block">
        <h1 class="section-title">Gestión de Usuarios</h1>
        <hr class="section-divider">
        <x-admin-nav />
    </header>


    {{-- Barra de filtros discreta --}}
    <section class="filter-bar">
        <form method="GET" action="{{ route('admin.users.index') }}" class="filter-bar__form">

            <input type="text" name="search" class="filter-input" placeholder="Buscar por nombre, email o teléfono..."
                value="{{ $search ?? '' }}">
            <button type="submit" class="filter-btn">
                Buscar
            </button>

            @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="filter-btn filter-btn--clear">
                Limpiar
            </a>
            @endif

        </form>
    </section>

    {{-- Tabla de usuarios --}}
    <section class="section-block">
        <div class="admin-table-wrapper">

            @if ($users->count())

            <table class="table-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->is_active ? 'Activo' : 'Desactivado' }}</td>

                        <td>
                            <div class="table-actions">

                                {{-- BOTÓN EDITAR (abre formulario oculto) --}}
                                <button class="btn-cta--global btn-sm" data-toggle="edit-user-{{ $user->id }}"
                                    data-label-open="Editar" data-label-close="Cerrar edición">
                                    Editar
                                </button>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar/desactivar este usuario?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-cta--global btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    {{-- FORMULARIO OCULTO PARA EDITAR ESTE USUARIO --}}
                    <tr class="form-row" data-target="edit-user-{{ $user->id }}" hidden>
                        <td colspan="6">
                            <div class="contact-form-card" style="margin-top: 1rem;">

                                <h3 class="section-subtitle">Editar usuario</h3>

                                <form method="POST" action="{{ route('admin.users.update', $user) }}"
                                    class="contact-form">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nombre --}}
                                    <div class="form-group">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" name="name" class="form-input"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    {{-- Apellidos --}}
                                    <div class="form-group">
                                        <label class="form-label">Apellidos</label>
                                        <input type="text" name="last_name" class="form-input"
                                            value="{{ old('last_name', $user->last_name) }}">
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-input"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>

                                    {{-- Rol --}}
                                    <div class="form-group">
                                        <label class="form-label">Rol *</label>
                                        <select name="role" class="form-input" required>
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario
                                            </option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                Administrador</option>
                                        </select>
                                    </div>

                                    {{-- DNI / NIE --}}
                                    <div class="form-group">
                                        <label class="form-label">DNI / NIE</label>
                                        <input type="text" name="national_id" class="form-input"
                                            value="{{ old('national_id', $user->national_id) }}">
                                    </div>

                                    {{-- Teléfono --}}
                                    <div class="form-group">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="phone" class="form-input"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>

                                    {{-- Dirección --}}
                                    <div class="form-group">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" name="address" class="form-input"
                                            value="{{ old('address', $user->address) }}">
                                    </div>

                                    {{-- Contraseña --}}
                                    <div class="form-group">
                                        <label class="form-label">Nueva contraseña (opcional)</label>
                                        <input type="text" name="password" class="form-input"
                                            placeholder="Dejar vacío para mantener la actual">
                                    </div>
                                    <hr class="section-divider">

                                    {{-- Imagen de perfil --}}
                                    <div class="form-group">
                                        <label class="form-label">Imagen de perfil (URL)</label>
                                        <input type="url" name="profile_picture" class="form-input"
                                            value="{{ old('profile_picture', $user->profile_picture) }}">
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
                <x-pagination :currentPage="$users->currentPage()" :lastPage="$users->lastPage()"
                    :prevPageUrl="$users->previousPageUrl()" :nextPageUrl="$users->nextPageUrl()" />
            </div>

            @else
            <p>No hay usuarios registrados todavía.</p>
            @endif

        </div>
    </section>

    {{-- BOTÓN CREAR USUARIO (abre formulario oculto) --}}
    <div class="section-block" style="text-align:center; margin-top:2rem;">
        <button class="btn-cta--global" data-toggle="create-user" data-label-open="Crear nuevo usuario"
            data-label-close="Cerrar formulario">
            Crear nuevo usuario
        </button>
    </div>

    {{-- FORMULARIO OCULTO PARA CREAR USUARIO --}}
    <section class="section-block" data-target="create-user" hidden>
        <div class="contact-form-card">
            <h3 class="section-subtitle">Crear usuario</h3>

            <form method="POST" action="{{ route('admin.users.store') }}" class="contact-form">
                @csrf

                {{-- Nombre --}}
                <div class="form-group">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                {{-- Apellidos --}}
                <div class="form-group">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="last_name" class="form-input">
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-input" required>
                </div>

                {{-- Rol --}}
                <div class="form-group">
                    <label class="form-label">Rol *</label>
                    <select name="role" class="form-input" required>
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
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

                {{-- URL imagen perfil --}}
                <div class="form-group">
                    <label class="form-label">Imagen de perfil (URL)</label>
                    <input type="url" name="profile_picture" class="form-input">
                </div>

                {{-- Contraseña --}}
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="text" name="password" class="form-input"
                        placeholder="Se generará una aleatoria si no pones nada">
                </div>

                <button type="submit" class="btn-cta--global">
                    Crear usuario
                </button>

            </form>
        </div>
    </section>


    <hr class="section-divider">

</section>
@endsection