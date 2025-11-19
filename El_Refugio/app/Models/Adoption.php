<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    /**
     * Relaciones con otras entidades del sistema.
    */
    public function animal()
{
    return $this->belongsTo(Animal::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
    
}
