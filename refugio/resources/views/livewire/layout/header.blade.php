<header x-data="{ isAuth: {{ auth()->check() ? 'true' : 'false' }} }">
  <nav class="flex space-x-4">
    <a href="{{ route('home') }}">Inicio</a>
    <template x-if="! isAuth">
      <a href="{{ route('public.user.login') }}">Iniciar sesión</a>
    </template>
    <template x-if="! isAuth">
      <a href="{{ route('public.user.register') }}">Registrarse</a>
    </template>
    <template x-if="isAuth">
      <a href="{{ route('public.user.profile') }}">Perfil</a>
    </template>
    <template x-if="isAuth">
      <button
        @click="$wire.logout().then(() => location.href='{{ route('home') }}')"
      >Cerrar sesión</button>
    </template>
  </nav>
</header>
