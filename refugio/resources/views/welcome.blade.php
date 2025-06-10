<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>El Refugio - Inicio</title>
    {{-- Livewire styles --}}
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/globalStyles.css') }}">
    {{-- Alpine.js desde CDN (v3.x) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body class="antialiased">

    {{-- Contenido de header --}}
    <header>
        <livewire:layout.header />
    </header>

    <main>
        {{-- Contenido de tu landing --}}
        <h1>Bienvenido al Refugio</h1>
    </main>

    {{-- Contenido de footer --}}
    <footer>

    </footer>
    
</body>

</html>