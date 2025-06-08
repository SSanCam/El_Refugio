<?php 
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Mail\SponsorshipNotificationMail;
use Stripe\StripeClient;
use Exception;

/**
 * Controlador para gestionar el envío de correos de apadrinamiento.
 */
class SponsorshipController extends Controller
{
    /**
     * Crea un nuevo apadrinamiento y envía un correo de notificación.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSponsorship(Request $request)
{
    
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'animal' => 'required|string',
            'evento' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $request->input('amount') * 100, // en centavos
                    'currency' => 'eur',
                    'payment_method_types' => ['card'],
                    'receipt_email' => $request->input('email'),
                    'description' => "Apadrinamiento de " . $request->input('animal'),
            ]);
        

            // Enviar correo de notificación
            Mail::to($validated['email'])->send(
                new SponsorshipNotificationMail($validated['animal'], $validated['name'], $validated['evento'], '')
            );

            return response()->json([
                'message' => 'Apadrinamiento creado y correo enviado correctamente.',
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret, 
            ], 200);

        } catch (Exception $e) {
            Log::error('Error al crear apadrinamiento o enviar correo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo completar el proceso. Intenta más tarde.'], 500);
        }
    }


    /**
     * Actualiza un apadrinamiento existente.
     */
    public function actualizarApadrinamiento(Request $request, $id)
    {
        // TODO: Validar request y actualizar datos en BD

        // TODO: Actualizar pago en Stripe si aplica

        // TODO: Enviar notificación si es relevante

        return response()->json(['message' => 'Apadrinamiento actualizado (simulado).'], 200);
    }
      /**
     * Finaliza un apadrinamiento.
     */
    public function finalizarApadrinamiento(Request $request, $id)
    {
        // TODO: Marcar apadrinamiento como finalizado en BD
        // TODO: Cancelar pago recurrente en Stripe si aplica

        // Enviar notificación de fin
        try {
            $userEmail = $request->input('email');
            $userName = $request->input('name');
            $animalName = $request->input('animal');
            $animaStatus = $request->input('animalStatus', '');

            Mail::to($userEmail)->send(
                new SponsorshipNotificationMail($animalName, $userName, 'fin', $animaStatus)
            );
        } catch (Exception $e) {
            Log::error('Error al enviar correo de finalización de apadrinamiento: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Apadrinamiento finalizado (simulado).'],200);
    }

}
