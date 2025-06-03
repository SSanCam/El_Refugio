<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable implements MustVerifyEmail
{
  
    use HasFactory;

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
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser convertidos automáticamente a tipos nativos.
     */
    protected $casts =[
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
 

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
 
}
