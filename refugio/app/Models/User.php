<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * Atributos que deben ocultarse cuando el modelo se convierte a array o JSON.
     * Atributos que deben ser ocultados cuando el modelo se convierte en array o JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con el modelo Adopción.
     */
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    /**
     * Relación con el modelo Acogida.
     */
    public function fosters()
    {
        return $this->hasMany(Foster::class);
    }

    /**
     * Relación con el modelo Apadrinamiento.
     */
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
}
