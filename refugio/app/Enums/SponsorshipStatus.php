<?php
namespace App\Enums;

enum SponsorshipStatus: string
{
    case ACTIVE = 'active';
    case PAUSED = 'paused';
    case ENDED = 'ended';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Activo',
            self::ENDED => 'Finalizado',
        };
    }
        public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
