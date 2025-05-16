<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     */
    protected $table = 'animal_requests';

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'animal_id',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Relación con el modelo Animal.
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
