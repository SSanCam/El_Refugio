<?php

namespace App\Enums;

enum AnimalStatus: string
{
    case SHELTERED   = 'sheltered';
    case FOSTERED    = 'fostered';
    case ADOPTED     = 'adopted';
    case DECEASED    = 'deceased';

    public function label(): string
    {
        return match($this) {
            self::SHELTERED   => 'En refugio',
            self::FOSTERED    => 'En acogida',
            self::ADOPTED     => 'Adoptado',
            self::DECEASED    => 'Fallecido',
        };
    }
}
