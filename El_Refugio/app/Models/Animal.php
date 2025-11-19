<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AnimalImage;
use App\Models\Adoption;
use App\Models\Foster;

class Animal extends Model
{
    use HasFactory;
    /**
     * Atributos que son asignables en masa.
     * @var array
     */
    protected $fillable = [
        'name',
        'species',
        'breed',
        'sex',
        'size',
        'weight',
        'height',
        'neutered',
        'microchip',
        'birth_date',
        'status',
        'entry_date',
        'description',
        'observations',
        'is_featured',
        'featured_at'
    ];

    /**
     * Atributos que deben estar ocultos para la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        // Ninguno necesario
    ];

    /**
     * Obtener los atributos que deben ser casteados.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date'   => 'date',
            'entry_date'   => 'date',
            'featured_at'  => 'datetime',
            'neutered'     => 'boolean',
            'is_featured'  => 'boolean',
        ];
    }

    public function images()
    {
        return $this->hasMany(AnimalImage::class);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function fosters()
    {
        return $this->hasMany(Foster::class);
    }
}