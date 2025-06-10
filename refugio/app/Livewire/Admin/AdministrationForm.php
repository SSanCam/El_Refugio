<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class AdministrationForm extends Component
{
    public function setSection (string $section){
        if (in_array($section, ['users', 'animals'])){
            $this->$section = $section;
        }
    }

    public function render()
    {
        return view('livewire.admin.administration-form');
    }
}
