{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'El Refugio'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">

    {{-- Header global --}}
    <x-header />

    {{-- Contenido variable de cada página --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer global --}}
    <x-footer />

</body>
</html>
