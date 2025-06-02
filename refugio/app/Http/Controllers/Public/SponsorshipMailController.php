<?php 
namespace App\Http\Controllers\Public;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SponsorshipNotificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

/**
 * Controlador para gestionar el envío de correos de apadrinamiento.
 */

class SponsorshipMailController extends Controller
{
    /**
     * Envia un correo de notificación de apadrinamiento.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviarCorreoDeApadrinamiento(Request $request)
    {
        $userEmail = $request->email;
        $userName = $request->name;
        $animalName = $request->animal;
        $evento = $request->evento;

        try {
            Mail::to($userEmail)->send(
                new SponsorshipNotificationMail($animalName, $userName, $evento)
            );

            return response()->json(['message' => 'Correo enviado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al enviar correo de apadrinamiento: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo enviar el correo. Intenta más tarde.'], 500);
        }
    }
}
