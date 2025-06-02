<?php 
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Mail\SponsorshipNotificationMail;
use Exception;

/**
 * Controlador para gestionar el envío de correos de apadrinamiento.
 */
class SponsorshipMailController extends Controller
{
    /**
     * Envía un correo de notificación de apadrinamiento sin modelo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviarCorreoDeApadrinamiento(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'animal' => 'required|string',
            'evento' => 'required|string',
        ]);

        try {
            // Se construyen los datos a mano (sin modelo)
            $userName = $request->input('name');
            $userEmail = $request->input('email');
            $animalName = $request->input('animal');
            $evento = $request->input('evento');

            // Enviar el correo
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
