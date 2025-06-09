<?php
namespace App\Enums;

enum AnimalStatus: string
{
    case AVAILABLE = 'available';
    case ADOPTED = 'adopted';
    case FOSTERED = 'fostered';
    case DECEASED = 'deceased';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Disponible',
            self::ADOPTED => 'Adoptado',
            self::FOSTERED => 'En acogida',
            self::DECEASED => 'Fallecido',
        };
    }
}
