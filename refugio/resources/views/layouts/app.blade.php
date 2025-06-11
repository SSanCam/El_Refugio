<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'El Refugio')</title>

    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/globalStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="antialiased">
    <header>
        <livewire:layout.header />
    </header>


    <main class="site-main">
        @yield('content')
    </main>

    <footer>

    </footer>
    @livewireScripts
</body>

</html>