{{-- resources/views/livewire/public/login-form.blade.php --}}

<section class="form-page">
    <section class="form-card">
        <header class="form-card__header">
            <h2>Iniciar sesión</h2>
        </header>

        <form wire:submit.prevent="login" novalidate>
            <div class="form-card__field">
                <label for="email" class="form-card__label">Correo electrónico</label>
                <input id="email" name="email" type="email" wire:model="email" class="form-card__input" required
                    autofocus>
                @error('email')
                <span class="form-card__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-card__field">
                <label for="password" class="form-card__label">Contraseña</label>

                <div class="password-wrapper" x-data="{ show: false }" x-cloak wire:ignore style="position: relative;">
                    <input id="password" name="password" :type="show ? 'text' : 'password'" wire:model="password"
                        class="form-card__input" required />

                    <button type="button" @click="show = !show" aria-label="Alternar visibilidad de contraseña"
                        style="position:absolute; right:.75rem; top:50%; transform:translateY(-50%); background:none; border:none; padding:0; cursor:pointer;">
                        <img x-show="!show" src="{{ asset('media/icons/mostrar.png') }}" alt="Mostrar"
                            style="width:1.5rem;">
                        <img x-show="show" src="{{ asset('media/icons/ocultar.png') }}" alt="Ocultar"
                            style="width:1.5rem;">
                    </button>
                </div>

                @error('password')
                <span class="form-card__error">{{ $message }}</span>
                @enderror
            </div>



            <div class="form-card__controls">
                <input id="remember" type="checkbox" wire:model="remember">
                <label for="remember">Recuérdame</label>
            </div>

            <div class="form-card__footer">
                <button type="submit" class="btn btn--primary">Entrar</button>
                <p>¿No tienes cuenta?</p>
                <a href="{{ route('public.user.register') }}" class="btn btn--secondary">Registrarse</a>
            </div>
        </form>
    </section>
</section>