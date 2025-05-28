<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sponsorship;

class SponsorshipNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsorship;
    public $evento; // 'inicio' o 'fin'

    public function __construct(Sponsorship $sponsorship, string $evento)
    {
        $this->sponsorship = $sponsorship;
        $this->evento = $evento;
    }

    public function build()
    {
        $animalName = $this->sponsorship->animal->name;
        $userName = $this->sponsorship->user->name;

        if ($this->evento === 'inicio') {
            return $this->subject('¡Gracias por apadrinar a ' . $animalName . '!')
                        ->html("
                            <p>Hola {$userName},</p>
                            <p>Gracias por iniciar el apadrinamiento de <strong>{$animalName}</strong>.</p>
                            <p>Nos alegra contar con tu apoyo para el bienestar de los animales del refugio.</p>
                            <p>Un saludo,</p>
                        ");
        }

        if ($this->evento === 'fin') {
            return $this->subject('Tu apadrinamiento ha finalizado')
                        ->html("
                            <p>Hola {$userName},</p>
                            <p>El animal que apadrinabas, <strong>{$animalName}</strong>, ha sido adoptado.</p>
                            <p>Tu apadrinamiento ha sido finalizado. Si estabas realizando una donación periódica, por favor considera cancelarla.</p>
                            <p>Gracias por tu apoyo.</p>
                        ");
        }

        return $this->subject('Notificación de apadrinamiento')
                    ->html("<p>Hola {$userName},</p><p>Hay una novedad en tu apadrinamiento de <strong>{$animalName}</strong>.</p>");
    }
}
