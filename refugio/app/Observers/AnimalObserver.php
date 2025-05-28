<?php
namespace App\Observers;

use App\Models\Animal;

class AnimalObserver
{
    public function updated(Animal $animal)
    {
        // Lógica cuando un animal se actualiza
        // Por ejemplo, cambiar estado de apadrinamientos
    }
}
