<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FosterRequest extends Model
{
    use HasFactory;

    protected $table = 'animal_requests';

    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'animal_id',
        'message',
        'status',
        'admin_notes',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
