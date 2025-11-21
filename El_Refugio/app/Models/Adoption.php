<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Adoption extends Model
{

    use HasFactory;
    protected $fillable = [
        'animal_id',
        'user_id',
        'adoption_date',
        'contract_file',
        'comments',
    ];

    protected function casts(): array
    {
        return [
            'adoption_date' => 'date',
        ];
    }

    /**
     * Relaciones con otras entidades del sistema.
    */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
