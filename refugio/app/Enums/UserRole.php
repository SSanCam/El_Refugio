<?php
namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case VOLUNTEER = 'volunteer';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'Usuario',
            self::ADMIN => 'Administrador',
            self::VOLUNTEER => 'Voluntario',
        };
    }
}
