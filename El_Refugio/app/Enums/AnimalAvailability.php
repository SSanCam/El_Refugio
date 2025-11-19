<?php 
namespace App\Enums;

Enum AnimalAvailability: string 
{ 
    case AVAILABLE = 'available'; 
    case UNAVAILABLE = 'unavailable';   

    public function label(): string 
    { 
        return match($this) { 
            self::AVAILABLE => 'Disponible', 
            self::UNAVAILABLE => 'No disponible', 
        }; 
    }

}