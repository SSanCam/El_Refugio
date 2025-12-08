<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AnimalImage;
use App\Models\Adoption;
use App\Models\Foster;
use App\Enums\AnimalStatus;
use App\Enums\AnimalAvailability;
use App\Enums\AnimalSpecies;
use App\Enums\AnimalSex;
use App\Enums\AnimalSize;
use Carbon\Carbon;

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
        'availability',
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
            'birth_date'  => 'date',
            'entry_date'  => 'date',
            'featured_at' => 'datetime',
            'neutered'    => 'boolean',
            'is_featured' => 'boolean',

            'status'       => AnimalStatus::class,
            'availability' => AnimalAvailability::class,
            'species'      => AnimalSpecies::class,
            'sex'          => AnimalSex::class,
            'size'         => AnimalSize::class,
        ];
    }

    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }

        return Carbon::parse($this->birth_date)->age;
    }

    public function getDaysAttribute()
    {
        if (!$this->entry_date) {
            return null;
        }

        return Carbon::parse($this->entry_date)
            ->startOfDay()
            ->diffInDays(Carbon::now()->startOfDay());
    }

    public function images()
    {
        return $this->hasMany(AnimalImage::class);
    }
    /*    
    public function getMainImageAttribute()
    {
           if ($this->images->isNotEmpty()) {
            return $this->images->first()->url;
        }

        return $this->species === 'cat'
            ? 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765144900/image-removebg-preview_5_y1jx6s.png'
            : 'https://res.cloudinary.com/dkfvic2ks/image/upload/v1765144900/image-removebg-preview_6_pgkr4k.png';     
    }
     */
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function fosters()
    {
        return $this->hasMany(Foster::class);
    }
}