<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sponsorship;

class SponsorshipEndedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Sponsorship instance.
     *
     * @var \App\Models\Sponsorship
     */
    public $sponsorship;

    /**
     * Crea una nueva instancia del mensaje de correo.
     */
    public function __construct(Sponsorship $sponsorship)
        {
            $this->sponsorship = $sponsorship;
        }

      /**
     * Muestra el contenido del mensaje.
     */
    public function build()
    {
        $animalName = $this->sponsorship->animal->name;
        $userName = $this->sponsorship->user->name;

        return $this->subject('Tu apadrinamiento ha finalizado')
                    ->html("
                        <p>Hola {$userName},</p>
                        <p>El animal que apadrinabas, <strong>{$animalName}</strong>, ha sido adoptado.</p>
                        <p>Tu apadrinamiento ha sido finalizado. Si estabas realizando una donación periódica, por favor considera cancelarla.</p>
                        <p>Gracias por tu apoyo.</p>
                    ");
    }

}
