<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Animal;
use Illuminate\Http\Request;
use Exception;

/**
 * Controlador público para el envío de formularios por email
 */
class FormController extends Controller
{

    public function contact()
    {
        return view('public.forms.contact');
    }

    public function sendContact(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'email' => ['required', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string', 'min:10', 'max:1000'],
            ],
            'public.forms.contact',
            'New Contact Message',
            'elrefugio@example.com',
            function (array $data) {
                return "Mensaje enviado desde el formulario de contacto:\n\n"
                    . $data['message'] . "\n\n"
                    . "Email de contacto: {$data['email']}";
            }
        );
    }

    public function request(Request $request)
    {
        $animalId = $request->query('animal');
        $type = $request->query('type');

        $animal = $animalId ? Animal::find($animalId) : null;

        return view('public.forms.request', [
            'animal' => $animal,
            'type' => $type,
        ]);
    }

    public function sendRequest(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'name'      => ['required', 'string', 'max:255'],
                'email'     => ['required', 'email', 'max:255'],
                'phone'     => ['nullable', 'string', 'max:20'],
                'message'   => ['nullable', 'string', 'max:1000'],
                'type'      => ['required', 'in:adoption,foster'],
                'animal_id' => ['nullable', 'integer', 'exists:animals,id'],
            ],
            'public.forms.request',                      // volvemos al mismo formulario
            'Nueva solicitud de adopción / acogida',     // asunto del email
            'elrefugio@example.com',                     // destinatario
            function (array $data) {
                $tipo = $data['type'] === 'foster' ? 'ACOGIDA' : 'ADOPCIÓN';

                $lineaAnimal = !empty($data['animal_id'])
                    ? "Peludo seleccionado (ID): {$data['animal_id']}\n"
                    : "Peludo seleccionado: no especificado\n";

                $lineaTelefono = !empty($data['phone'])
                    ? "Teléfono: {$data['phone']}\n"
                    : '';

                $lineaMensaje = !empty($data['message'])
                    ? "\nMensaje:\n{$data['message']}"
                    : "\nMensaje: (sin mensaje adicional)";

                return "Tipo de solicitud: {$tipo}\n"
                     . $lineaAnimal
                     . "Nombre: {$data['name']}\n"
                     . "Email: {$data['email']}\n"
                     . $lineaTelefono
                     . $lineaMensaje;
            }
        );
    }

    private function handleFormSubmission(Request $request, array $rules, string $redirectRoute, string $subject, string $recipient, ?\Closure $customMessageBuilder = null)
    {
        $validated = $request->validate($rules);

        try {
            $messageContent = $customMessageBuilder
                ? $customMessageBuilder($validated)
                : strip_tags($validated['message'] ?? '');

            Mail::raw($messageContent, function ($message) use ($validated, $subject, $recipient) {
                $message->to($recipient)
                    ->subject($subject)
                    ->from('no-reply@elrefugio.test', 'El Refugio')
                    ->replyTo($validated['email']);
            });

            return redirect()
                ->route($redirectRoute)
                ->with('success', 'Formulario enviado correctamente.');

        } catch (Exception $e) {
            Log::error("Error sending form ($subject): " . $e->getMessage());

            return redirect()
                ->route($redirectRoute)
                ->withErrors([
                'email' => 'Error inesperado en el envio del formulario. Inténtalo de nuevo.',
            ])->withInput();
        }
    }

}