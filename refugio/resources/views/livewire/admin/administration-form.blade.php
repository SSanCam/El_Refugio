<div>


  <nav class="flex space-x-4">
    <button wire:click="setSection('users')" @class(['font-bold' => $section==='users'])>
      Usuarios
    </button>


    <button wire:click="setSection('animals')" @class(['font-bold' => $section==='animals'])>
      Animales
    </button>

  </nav>

  <div class="mt-6">
    @if($section === 'users')
      <livewire:admin.user-form />
    @elseif($section === 'animals')
      <livewire:admin.animal-form />
    @endif
    
  </div>
</div>
