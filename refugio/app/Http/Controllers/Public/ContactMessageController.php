<?php 
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageNotificationMail;
use Exception;

class ContactMessageController extends Controller
{
    /**
     * Muestra el formulario de contacto.
     */
    public function create()
    {
        return view('public.contact.create');
    }

    /**
     * Almacena un nuevo mensaje de contacto.
     */
    public function store(Request $request)
    {
        try {
            $this->validateRequest($request);

            $message = new ContactMessage();
            $message->name = $request->name;
            $message->email = $request->email;
            $message->subject = $request->subject;
            $message->message = $request->message;
            $message->save();

            Mail::to(config('mail.admin_email'))->send(new ContactMessageNotificationMail($message));

            return redirect()->route('contact.create')->with('success', 'Mensaje enviado correctamente.');
        } catch (Exception $e) {
            Log::error('Error al enviar el mensaje de contacto: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al enviar el mensaje.']);
        }
    }

    private function validateRequest(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ])->validate();
    }
}