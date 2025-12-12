<header class="main-header">
    <div class="header-inner">

        <!-- Logo -->
        <a href="/" class="btn-logo">
            <img src="https://res.cloudinary.com/dkfvic2ks/image/upload/v1763969655/logo_sin_fondo_ht3ppk.png"
                alt="El Refugio Logo">
        </a>

        <!-- NAV -->
        <nav id="mainNav" class="header-nav">

            <a href="{{ route('public.home') }}" class="header-link">Inicio</a>
            <a href="{{ route('public.animals.index') }}" class="header-link">Peludos</a>
            <a href="{{ route('public.animals.happy') }}" class="header-link">Finales felices</a>
            <a href="{{ route('public.forms.contact') }}" class="header-link">Contacto</a>

            @guest
            <a href="{{ route('login') }}" class="header-link">Iniciar sesión</a>
            @endguest

            @auth
            @if (auth()->user()->role === 'admin')
            <a href="{{ route('profile.show') }}" class="header-link">Mi área</a>
            <a href="{{ route('admin.dashboard') }}" class="header-link">Administración</a>
            @else
            <a href="{{ route('profile.show') }}" class="header-link">Mi área</a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="header-link--profile">
                    <img src="https://res.cloudinary.com/dkfvic2ks/image/upload/v1764920697/download-removebg-preview_bqpge7.png"
                        alt="Cerrar sesión">
                </button>
            </form>
            @endauth

        </nav>
        <!-- Botón tema -->
        <button class="theme-toggle" data-theme-toggle aria-label="Cambiar tema">
            <img src="{{ asset('images/sol.png') }}" alt="Cambiar tema">
        </button>
    </div>
</header> 