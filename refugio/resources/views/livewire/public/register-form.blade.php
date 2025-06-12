{{-- resources/views/livewire/public/register-form.blade.php --}}
<div class="modal-backdrop" x-show="true" x-cloak>
  <section class="form-card">
    <header class="form-card__header">
      <h2>Crear cuenta</h2>
    </header>

    <form wire:submit.prevent="register" novalidate>
      {{-- Nombre --}}
      <div class="form-card__field">
        <label for="name" class="form-card__label">Nombre completo</label>
        <input id="name"
               type="text"
               wire:model.defer="name"
               class="form-card__input"
               placeholder="Tu nombre"
               required
               autofocus>
        @error('name')
          <span class="form-card__error">{{ $message }}</span>
        @enderror
      </div>

      {{-- Email --}}
      <div class="form-card__field">
        <label for="email" class="form-card__label">Correo electrónico</label>
        <input id="email"
               type="email"
               wire:model.defer="email"
               class="form-card__input"
               placeholder="tú@correo.com"
               required>
        @error('email')
          <span class="form-card__error">{{ $message }}</span>
        @enderror
      </div>

      {{-- Contraseña --}}
      <div class="form-card__field" x-data="{ show: false }" x-cloak>
        <label for="password" class="form-card__label">Contraseña</label>
        <div class="password-wrapper" style="position: relative;">
          <input id="password"
                 :type="show ? 'text' : 'password'"
                 wire:model.defer="password"
                 class="form-card__input"
                 placeholder="••••••••"
                 required>
          <button type="button"
                  @click="show = ! show"
                  aria-label="Alternar visibilidad de contraseña"
                  style="position:absolute; right:.75rem; top:50%; transform:translateY(-50%); background:none; border:none; padding:0; cursor:pointer;">
            <img x-show="!show"
                 src="{{ asset('media/icons/mostrar.png') }}"
                 alt="Mostrar contraseña"
                 style="width:1.5rem; height:auto;">
            <img x-show="show"
                 src="{{ asset('media/icons/ocultar.png') }}"
                 alt="Ocultar contraseña"
                 style="width:1.5rem; height:auto;">
          </button>
        </div>
        @error('password')
          <span class="form-card__error">{{ $message }}</span>
        @enderror
      </div>

      {{-- Confirmación de contraseña --}}
      <div class="form-card__field">
        <label for="password_confirmation" class="form-card__label">Confirmar contraseña</label>
        <input id="password_confirmation"
               type="password"
               wire:model.defer="password_confirmation"
               class="form-card__input"
               placeholder="••••••••"
               required>
      </div>

      {{-- Footer con botones --}}
      <div class="form-card__footer">
        <button type="submit" class="btn-generic">Registrarse</button>
        <p>¿Ya tienes cuenta?</p>
        <a href="{{ route('public.user.login') }}" class="btn-generic">Iniciar sesión</a>
      </div>
    </form>
  </section>
</div>
