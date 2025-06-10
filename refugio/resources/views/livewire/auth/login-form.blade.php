<div x-show.transition.opacity="@entangle('show')" class="modal-backdrop">
  <div class="modal">
    <form wire:submit.prevent="submit">
      <label>Email: <input wire:model.defer="email" type="email"></label>
      <label>Contraseña: <input wire:model.defer="password" type="password"></label>
      <label><input wire:model="remember" type="checkbox"> Recordarme</label>
      <button type="submit">Entrar</button>
      <button type="button" @click="$wire.show = false">Cerrar</button>
    </form>
  </div>
</div>
