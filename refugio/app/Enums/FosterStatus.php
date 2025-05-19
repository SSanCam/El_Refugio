<?php 
namespace App\Enums;

enum FosterStatus: string
{
    case PENDING = 'pending';
    case FOSTERING = 'fostering';
    case FINISHED = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendiente',
            self::FOSTERING => 'En acogida',
            self::FINISHED => 'Finalizada',
        };
    }
}
