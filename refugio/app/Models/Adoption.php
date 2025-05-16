<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'animal_id',
        'user_id',
        'adoption_date',
        'notes',
    ];

    /**
     * Relación con el modelo Animal.
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    /**
     * Relación con el modelo User (adoptante).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts = [
        'adoption_date' => 'date',
    ];
}
