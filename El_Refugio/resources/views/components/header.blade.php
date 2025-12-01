<header class="main-header">

    <div class="header-inner">

        <a href="/" class="btn-logo">
            <img src="https://res.cloudinary.com/dkfvic2ks/image/upload/v1763969655/logo_sin_fondo_ht3ppk.png"
                alt="El Refugio Logo">
        </a>

        <nav class="header-nav">
            <a href="{{ route('public.home') }}" class="header-link">Inicio</a>
            <a href="{{ route('public.animals.index') }}" class="header-link">Peludos</a>
            {{-- <a href="{{ route('home') }}" class="header-link">Finales felices</a> --}}
            <a href="{{ route('public.forms.contact') }}" class="header-link">Contacto</a>
            <a href="{{ route('login') }}" class="header-link">Iniciar Sesión</a>
        </nav>

    </div>
</header>