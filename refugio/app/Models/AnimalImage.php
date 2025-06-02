<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class AnimalImage extends Model
{
    protected $fillable = ['animal_id', 'url', 'alt_text', 'caption'];

    public function animal(){
        return $this->belongsTo(Animal::class);
    }

}