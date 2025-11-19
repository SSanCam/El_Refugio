<?php

namespace App\Enums;

enum AnimalStatus: string
{
    case AVAILABLE   = 'available';
    case SHELTERED   = 'sheltered';
    case FOSTERED    = 'fostered';
    case ADOPTED     = 'adopted';
    case UNAVAILABLE = 'unavailable';
    case DECEASED    = 'deceased';

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE   => 'Disponible',
            self::SHELTERED   => 'En refugio',
            self::FOSTERED    => 'En acogida',
            self::ADOPTED     => 'Adoptado',
            self::UNAVAILABLE => 'No disponible',
            self::DECEASED    => 'Fallecido',
        };
    }
}
