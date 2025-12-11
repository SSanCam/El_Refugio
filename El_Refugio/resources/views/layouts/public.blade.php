<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'El Refugio | Adopción y acogida de animales')</title>

    {{-- Meta descripción (SEO) --}}
    @hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
    @else
    <meta name="description"
        content="El Refugio es un proyecto de refugio de animales donde puedes adoptar, acoger o apadrinar perros y gatos en busca de un hogar.">
    @endif

    {{-- Meta palabras clave (SEO) --}}
    @hasSection('meta_keywords')
    <meta name="keywords" content="@yield('meta_keywords')">
    @else
    <meta name="keywords" content="refugio de animales, adopción, acogida, perros, gatos, protectora">
    @endif

    {{-- Robots (por si alguna vista quiere poner noindex) --}}
    <meta name="robots" content="@yield('meta_robots', 'index,follow')">

    {{-- Canonical para URL limpias --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="{{ $bodyClass ?? '' }}">

    <x-header />

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>

</html>