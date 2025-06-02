<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @extends('layouts.admin')

    @section('content')
    <div class="container">
        <h1>Editar Animal</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.animals.update', $animal->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $animal->name) }}" required>
            </div>

            {{-- Especie --}}
            <div class="mb-3">
                <label for="species" class="form-label">Especie</label>
                <input type="text" name="species" class="form-control" value="{{ old('species', $animal->species) }}"
                    required>
            </div>

            {{-- Raza --}}
            <div class="mb-3">
                <label for="breed" class="form-label">Raza</label>
                <input type="text" name="breed" class="form-control" value="{{ old('breed', $animal->breed) }}">
            </div>

            {{-- Edad --}}
            <div class="mb-3">
                <label for="age" class="form-label">Edad</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $animal->age) }}" required>
            </div>

            {{-- Tamaño --}}
            <div class="mb-3">
                <label for="size" class="form-label">Tamaño</label>
                <select name="size" class="form-select" required>
                    @foreach (['small' => 'Pequeño', 'medium' => 'Mediano', 'large' => 'Grande'] as $value => $label)
                    <option value="{{ $value }}" {{ old('size', $animal->size) === $value ? 'selected' : '' }}>
                        {{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sexo --}}
            <div class="mb-3">
                <label for="sex" class="form-label">Sexo</label>
                <select name="sex" class="form-select" required>
                    @foreach (['male' => 'Macho', 'female' => 'Hembra', 'unknown' => 'Desconocido'] as $value => $label)
                    <option value="{{ $value }}" {{ old('sex', $animal->sex) === $value ? 'selected' : '' }}>
                        {{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Peso --}}
            <div class="mb-3">
                <label for="weight" class="form-label">Peso (kg)</label>
                <input type="number" step="0.01" name="weight" class="form-control"
                    value="{{ old('weight', $animal->weight) }}">
            </div>

            {{-- Estado --}}
            <div class="mb-3">
                <label for="status" class="form-label">Estado</label>
                <select name="status" class="form-select" required>
                    @foreach ([
                    'available' => 'Disponible',
                    'adopted' => 'Adoptado',
                    'fostered' => 'Acogido',
                    'sponsored' => 'Apadrinado',
                    'sheltered' => 'En refugio',
                    'intake' => 'Ingreso',
                    'deceased' => 'Fallecido'
                    ] as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $animal->status) === $value ? 'selected' : '' }}>
                        {{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Microchip --}}
            <div class="mb-3">
                <label for="microchip" class="form-label">Microchip</label>
                <input type="text" name="microchip" class="form-control"
                    value="{{ old('microchip', $animal->microchip) }}">
            </div>

            {{-- Imagen --}}
            <div class="mb-3">
                <label for="imag

</body>
</html>