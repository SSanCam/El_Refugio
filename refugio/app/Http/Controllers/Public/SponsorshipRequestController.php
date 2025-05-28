<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Sponsorship;
use App\Mail\SponsorshipNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Exception;

class SponsorshipRequestController extends Controller
{
    private const VALID_AMOUNTS = [1, 10, 20];

    /**
     * Muestra el formulario para solicitar un apadrinamiento.
     */
    public function create($animalId)
    {
        try {
            return view('public.sponsorship.create', compact('animalId'));
        } catch (QueryException $e) {
            Log::error('Error al mostrar el formulario de solicitud de apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al mostrar el formulario de solicitud de apadrinamiento.']);
        }
    }


    private function validateRequest(Request $request): bool
        {
            $validator = Validator::make($request->all(), [
                'animal_id' => 'required|exists:animals,id',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'donation_amount' => 'required|in:' . implode(',', self::VALID_AMOUNTS),
                'donation_interval' => 'required|in:mensual',
                'email' => 'required|email|max:255',
                'notes' => 'nullable|string|max:500',
                'payment_method_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return false;
            }
            return true;
        }

    private function createSponsorship(Request $request): Sponsorship
        {
            $sponsorship = new Sponsorship();
            $sponsorship->user_id = Auth::check() ? Auth::id() : null;
            $sponsorship->animal_id = $request->animal_id;
            $sponsorship->start_date = $request->start_date;
            $sponsorship->end_date = $request->end_date;
            $sponsorship->status = 'pendiente'; // pendiente hasta confirmar pago
            $sponsorship->donation_amount = $request->donation_amount;
            $sponsorship->donation_interval = 'mensual';
            $sponsorship->email = $request->email;
            $sponsorship->notes = $request->notes;
            $sponsorship->save();

            return $sponsorship;
        }

    private function createPaymentIntent(Request $request): PaymentIntent
        {
            Stripe::setApiKey(config('services.stripe.secret'));

            return PaymentIntent::create([
                'amount' => $request->donation_amount * 100, // en céntimos
                'currency' => 'eur',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'receipt_email' => $request->email,
                'description' => 'Apadrinamiento para animal ID ' . $request->animal_id,
            ]);
        }



    /**
     * Almacena una nueva solicitud de apadrinamiento y envía la notificación.
     * @param Request $request Solicitud de apadrinamiento.
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'animal_id' => 'required|exists:animals,id',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'donation_amount' => 'required|in:' . implode(',', self::VALID_AMOUNTS),
                'donation_interval' => 'required|in:mensual',
                'email' => 'required|email|max:255',
                'notes' => 'nullable|string|max:500',
                'payment_method_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $sponsorship = $this->createSponsorship($request);
                $paymentIntent = $this->createPaymentIntent($request);

                if ($paymentIntent->status == 'requires_action' && $paymentIntent->next_action->type == 'use_stripe_sdk') {
                    return redirect()->route('public.sponsorshipRequest.confirm', ['sponsorship' => $sponsorship->id])
                        ->with('requires_action', true);
                }

                if ($paymentIntent->status == 'succeeded') {
                    $sponsorship->status = 'active';
                    $sponsorship->save();

                    Mail::to($sponsorship->email)->send(new SponsorshipNotificationMail($sponsorship, 'inicio'));

                    return redirect()->route('public.sponsorshipRequest.create', ['animalId' => $request->animal_id])
                        ->with('success', 'Solicitud de apadrinamiento enviada con éxito.');
                }

                return redirect()->back()->withErrors(['error' => 'Error al procesar el pago. Por favor, inténtelo de nuevo.']);
            } catch (QueryException $e) {
                Log::error('Error al crear la solicitud de apadrinamiento: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Error al crear la solicitud de apadrinamiento.']);
            } catch (Exception $e) {
                Log::error('Error inesperado al procesar la solicitud de apadrinamiento: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Error inesperado al procesar la solicitud de apadrinamiento.']);
            }
        }


}