@extends('layouts.app') {{-- o el layout que uses en tu panel admin --}}

@section('content')
    <div class="container">
        <h1>Listado de Animales</h1>

        {{-- Mostrar mensaje flash si lo hay --}}
        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        {{-- Mostrar mensaje de error si lo hay --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Mostrar los animales si existen --}}
        @if ($animals->count())
            <ul>
                @foreach ($animals as $animal)
                    <li>{{ $animal->name }} - {{ $animal->species }}</li>
                @endforeach
            </ul>

            {{-- Paginación --}}
            {{ $animals->links() }}
        @else
            <p>No hay animales registrados.</p>
        @endif
    </div>
@endsection

