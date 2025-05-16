<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerRequest extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'availability',
        'motivation',
        'status',
        'admin_notes',
    ];

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
