<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SponsorshipNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $animalName;
    public $userName;
    public $evento;

    public function __construct(string $animalName, string $userName, string $evento)
    {
        $this->animalName = $animalName;
        $this->userName = $userName;
        $this->evento = $evento;
    }

    public function build()
    {
        $animalName = $this->animalName;
        $userName = $this->userName;
        // Determinar el asunto y el contenido del correo según el evento

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

        // Si el evento no es ni inicio ni fin, se envía una notificación genérica
        return $this->subject('Notificación de apadrinamiento')
                    ->html("<p>Hola {$userName},</p><p>Hay una novedad en tu apadrinamiento de <strong>{$animalName}</strong>.</p>");
    }

    public function enviarCorreoDeApadrinamiento(string $userEmail, string $userName, string $animalName, string $evento)
    {
        try {
            Mail::to($userEmail)->send(
                new SponsorshipNotificationMail($animalName, $userName, $evento)
            );
            return response()->json(['message' => 'Correo enviado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de apadrinamiento: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo enviar el correo. Intenta más tarde.'], 500);
        }
    }
}
