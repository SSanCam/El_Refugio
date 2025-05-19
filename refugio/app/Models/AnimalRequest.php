<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalRequest extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden asignarse de forma masiva.
     */
    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'message',
        'animal_id',
        'status',
        'admin_notes',
    ];

    /**
     * Relación con el modelo Animal (opcional).
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
