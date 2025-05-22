<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden ser asignados en masa.
     */
    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'sex',
        'size',
        'weight',
        'status',
        'microchip',
        'description',
        'image',
    ];

    /**
     * Relación con el historial veterinario.
     */
    public function veterinaryHistories()
    {
        return $this->hasMany(VeterinaryHistory::class);
    }

    /**
     * Relación con la medicación de los animales.
     */
    public function animalMedications()
    {
        return $this->hasMany(AnimalMedication::class);
    }

    /**
     * Relación con las adopciones.
     */
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    /**
     * Relación con las acogidas.
     */
    public function fosters()
    {
        return $this->hasMany(Foster::class);
    }

    /**
     * Relación con los apadrinamientos.
     */
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    // Animal del que proviene (ej. madre/padre)
    public function parent()
    {
        return $this->belongsTo(Animal::class, 'parent_id');
    }

    // Animales que tienen a este como referente (cachorros)
    public function offspring()
    {
        return $this->hasMany(Animal::class, 'parent_id');
    }


}