<header class="header" x-data="{
          isAuth: @json(Auth::check()),
          isAdmin: @json(Auth::check() && Auth::user()->role === \App\Enums\UserRole::ADMIN->value)
        }">
    <nav class="header__nav" aria-label="Menú principal">
        <section class="header__logo" aria-label="Logotipo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('media/icons/logo_sin_fondo.png') }}" alt="El Refugio">
            </a>
        </section>

        <section class="header__buttons" aria-label="Accesos rápidos">
            <ul class="buttons-list" role="menubar">
                <li role="none" x-show="!isAuth">
                    <a role="menuitem" href="{{ route('public.user.login') }}" class="btn-nav">
                        Iniciar sesión
                    </a>
                </li>
                <li role="none" x-show="!isAuth">
                    <a role="menuitem" href="{{ route('public.user.register') }}" class="btn-nav">
                        Registrarse
                    </a>
                </li>

                <li role="none" x-show="isAuth">
                    <a role="menuitem" href="{{ route('auth.profile') }}" class="btn-nav">
                        Perfil
                    </a>
                </li>
                <li role="none" x-show="isAuth">
                    <button role="menuitem" type="button" class="btn-nav"
                        @click="$wire.logout().then(() => window.location='{{ url('/') }}')">
                        Cerrar sesión
                    </button>
                </li>

                <li role="none" x-show="isAdmin">
                    <a role="menuitem" href="{{ route('admin.dashboard') }}" class="btn-nav">
                        Panel Admin
                    </a>
                </li>
            </ul>
        </section>
    </nav>
</header>