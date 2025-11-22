<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Animal;

class AnimalImage extends Model
{
    use HasFactory;

    /**
     * Atributos que son asignables en masa.
     * @var array
     */
    protected $fillable = [
        'animal_id',
        'url',
        'alt_text',
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
            'profile_pic' => 'boolean',
        ];
    }

    /**
     * Relaciones con otras entidades del sistema.
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
