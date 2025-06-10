<header class="header" x-data="{ isAuth: {{ auth()->check() ? 'true' : 'false' }} ,
isAdmin: @json(
auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN->value)}">

    <nav class="flex space-x-4">
        <!-- Botones que se muestran públicamente-->
        <div class="logo">
            a href="{{ url('/') }}" class="nav-logo">
            <img src="{{ asset('../images/logo_sin_fondo.png') }}" alt="Logo El Refugio">
            </a>
        </div>
        <div class="buttons">
            <a href="{{ route('public.user.login') }}">Iniciar sesión</a>
            <a href="{{ route('public.user.register') }}" class="btn-nav">Registrarse</a>

            <!-- Botones que se muestran bajo una condición-->
            <!-- Usuarios autenticados -->
            <template x-show="isAuth">
                <a href="{{ route('auth.profile') }}" class="btn-nav">Perfil</a>
            </template>
            <template x-show="isAuth">
                <button @click="$wire.logout().then(() => location.href='{{ url('/') }}')" class="btn-nav">Cerrar
                    sesión</button>
            </template>
            <!-- Usuarios administradores -->
            <template x-show="isAdmin">
                <a href="{{ route('admin.dashboard') }}" class="btn-nav">Panel Administrativo</a>
            </template>
        </div>

    </nav>

</header>