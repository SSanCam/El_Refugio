<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalImage extends Model
{
      protected $fillable = ['animal_id', 'url'];

    public function animal(){
        return $this->belongsTo(\App\Models\Animal::class);
    }

}