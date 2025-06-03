<?php
namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    /**
     * Obtiene el nombre legible del rol de usuario.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::USER => 'Usuario',
            self::ADMIN => 'Administrador',
        };
    }

}
