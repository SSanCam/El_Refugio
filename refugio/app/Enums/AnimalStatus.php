<?php
namespace App\Enums;

enum AnimalStatus: string
{
    case AVAILABLE = 'available';
    case ADOPTED = 'adopted';
    case FOSTERED = 'fostered';
    case SPONSORED = 'sponsored';
    case SHELTERED = 'sheltered';
    case INTAKE = 'intake';
    case DECEASED = 'deceased';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Disponible',
            self::ADOPTED => 'Adoptado',
            self::FOSTERED => 'En acogida',
            self::SPONSORED => 'Apadrinado',
            self::SHELTERED => 'En refugio',
            self::INTAKE => 'Entrada reciente',
            self::DECEASED => 'Fallecido',
        };
    }
}
