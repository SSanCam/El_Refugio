<?php
namespace App\Enums;

enum AnimalSex: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case UNKNOWN = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Macho',
            self::FEMALE => 'Hembra',
            self::UNKNOWN => 'Desconocido',
        };
    }
}
