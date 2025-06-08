<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnimalSpecies;

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
        'parent_id', 
        'image',
    ];

    /**
     * Relación con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function images()
    {
        return $this->hasMany(AnimalImage::class);
    }

}