<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Gestión de notificaciones por correo electrónico.
 * Esta clase se encarga de enviar correos electrónicos a los usuarios
 * para notificarles sobre eventos importantes relacionados con su cuenta.
 * 
 */

class EmailNotifications extends Mailable
{
    use Queueable, SerializesModels;

    public $userEmail;
    public $subject;
    public $code;

    
    public function __construct(string $userEmail, string $subject, string $code = '')
    {
        $this->userEmail = $userEmail;
        $this->subject = $subject;
        $this->code = $code;
    }

    /**
     * Construye el mensaje de correo electrónico.
     * Este método configura el destinatario, el asunto y el cuerpo del mensaje
     * según el tipo de notificación que se envía.
     * 
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        
        $contenido = match ($this->subject) {
            'Cuenta creada' => "¡Bienvenida! Tu cuenta ha sido creada con éxito.",
            'Cuenta eliminada' => "Tu cuenta ha sido eliminada correctamente.",
            'Correo electrónico actualizado' => "Tu correo electrónico ha sido actualizado correctamente.",
            'Contraseña actualizada' => "Su contraseña ha sido modificada correctamente.",
            'Solicitud de eliminación de cuenta' => "Tu cuenta ha sido desactivada y se ha solicitado su eliminación. Si no has solicitado esto, por favor contacta con el soporte.",
            'Activación de verificación en dos pasos' => "Has iniciado la activación de la verificación en dos pasos (2FA). Por favor, escanea el código QR mostrado en pantalla para completar la configuración.",
            'Código de verificación 2FA' => "Tu código de verificación en dos pasos es: <strong>{$this->code}</strong>. Este código expirará en 5 minutos.",
            'Email verificado' => "Tu correo electrónico ha sido verificado correctamente.",
            'Nueva verificación de correo electrónico' => "Tu código de verificación es: {$this->code}",
            'Restablecimiento de contraseña' => "Has solicitado un restablecimiento de contraseña. Tu nueva clave es: <strong>{$this->code}</strong>. Si no has solicitado esto, ignora este mensaje.",

            default => "Tienes una nueva notificación.",
        };

        return $this->subject($this->subject)->html("<p>{$contenido}</p>");
    }
}