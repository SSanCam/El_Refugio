@extends('layouts.app') {{-- o el layout que uses --}}

@section('content')
<div class="container">
    <h1>Editar Animal</h1>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.animals.update', $animal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $animal->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="species" class="form-label">Especie:</label>
            <input type="text" name="species" id="species" class="form-control" value="{{ old('species', $animal->species) }}" required>
        </div>

        <div class="mb-3">
            <label for="breed" class="form-label">Raza:</label>
            <input type="text" name="breed" id="breed" class="form-control" value="{{ old('breed', $animal->breed) }}">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Edad:</label>
            <input type="number" name="age" id="age" class="form-control" value="{{ old('age', $animal->age) }}" required>
        </div>

        <div class="mb-3">
            <label for="size" class="form-label">Tamaño:</label>
            <select name="size" id="size" class="form-select" required>
                @foreach (['small', 'medium', 'large'] as $size)
                    <option value="{{ $size }}" @if(old('size', $animal->size) === $size) selected @endif>{{ ucfirst($size) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Agrega más campos si los necesitas (sex, status, etc.) --}}

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
