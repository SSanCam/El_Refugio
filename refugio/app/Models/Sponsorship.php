<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'user_id',
        'animal_id',
        'start_date',
        'end_date',
        'status',
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
     * Relación con el modelo User (padrino/a).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
