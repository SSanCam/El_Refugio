<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Gestión de notificaciones por correo electrónico.
 */

class EmailNotifications extends Mailable
{
    use Queueable, SerializesModels;

    public $userEmail;
    public $subject;
    public function __construct(string $userEmail, string $subject, string $message)
    {
        $this->userEmail = $userEmail;
        $this->subject = $subject;
    }

    public function build()
    {
        $to = $this->userEmail;
        $subject = $this->subject;
        $message = [
            'Cuenta creada' => "¡Bienvenida! Tu cuenta ha sido creada con éxito.",
            'Cuenta eliminada' => "Tu cuenta ha sido eliminada correctamente.",
            'Correo electrónico actualizado' => "Tu correo electrónico ha sido actualizado correctamente.",
            'Contraseña actualizada' => "Su contraseña ha sido modificada correctamente.",
            'Solicitud de eliminación de cuenta' => "Tu cuenta ha sido desactivada y se ha solicitado su eliminación. Si no has solicitado esto, por favor contacta con el soporte.",
        ];

        $message = $mensajes[$this->subject] ?? "Tienes una nueva notificación.";

        mail($to, $subject, $message);

    }
}