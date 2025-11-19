<?php

namespace App\Enums;

enum AnimalSpecies: string
{
    case DOG   = 'dog';
    case CAT   = 'cat';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::DOG   => 'Perro',
            self::CAT   => 'Gato',
            self::OTHER => 'Otro',
        };
    }
}
