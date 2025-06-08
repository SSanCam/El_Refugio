<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorshipNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $animalName;
    public $userName;
    public $event;
    public $animalStatus;

    public function __construct(string $animalName, string $userName, string $event, string $animalStatus)
    {
        $this->animalName = $animalName;
        $this->userName = $userName;
        $this->event = $event;
        $this->animalStatus = $animalStatus;
    }

    public function build()
    {
        $animalName = $this->animalName;
        $userName = $this->userName;

        switch ($this->event) {
            case 'inicio':
                return $this->subject("¡Gracias por apadrinar a {$animalName}!")
                    ->html("<p>Hola {$userName},</p><p>Gracias por iniciar el apadrinamiento de <strong>{$animalName}</strong>.</p>");
            
            case 'fin':
                if ($this->animalStatus === 'adopted') {
                    return $this->subject("¡Tu apadrinamiento ha finalizado!")
                        ->html("<p>Hola {$userName},</p><p>Nos complace informarte que el animal <strong>{$animalName}</strong> ha sido adoptado gracias a tu apoyo.</p>");
                } elseif ($this->animalStatus === 'deceased') {
                    return $this->subject("Tu apadrinamiento ha finalizado")
                        ->html("<p>Hola {$userName},</p><p>Lamentamos comunicarte que <strong>{$animalName}</strong> a quién apadrinabas ha fallecido.</p>");
                } else {
                    return $this->subject("Tu apadrinamiento ha finalizado")
                        ->html("<p>Hola {$userName},</p><p>Tu apadrinamiento de <strong>{$animalName}</strong> ha finalizado.</p>");
                }

            default:
                return $this->subject("Notificación de apadrinamiento")
                    ->html("<p>Hola {$userName},</p><p>Hay una novedad en tu apadrinamiento de <strong>{$animalName}</strong>.</p>");
        }
    }


}