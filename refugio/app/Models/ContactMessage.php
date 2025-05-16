<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     */
    protected $table = 'contact_requests';

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Relación con el modelo User (opcional).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
