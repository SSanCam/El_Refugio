<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Exception;

class FormController extends Controller 
{
    public function adoptionForm()
    {
        return view('public.animal.adoptionForm');
    }

    public function sendAdoptionForm(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'required|string|max:500',
                'message' => 'nullable|string|max:1000',
            ],
            'public.animal.adoptionForm',
            'New Adoption Form',
            'elrefugio@example.com'
        );
    }

    public function sponsorshipForm()
    {
        return view('public.animal.sponsorshipForm');
    }

    public function sendSponsorshipForm(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'amount' => 'required|numeric|min:1',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'message' => 'nullable|string|max:1000',
            ],
            'public.animal.sponsorshipForm',
            'New Sponsorship Form',
            'elrefugio@example.com',
            function($data) {
                return "Name: {$data['name']}\n"
                    . "Email: {$data['email']}\n"
                    . "Phone: " . ($data['phone'] ?? 'Not provided') . "\n"
                    . "Address: " . ($data['address'] ?? 'Not provided') . "\n"
                    . "Amount: {$data['amount']} €\n"
                    . "Message:\n" . strip_tags($data['message'] ?? '');
            }
        );
    }

    public function fosterForm()
    {
        return view('public.animal.fosterForm');
    }

    /**
     * Muestra el formulario de acogida.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function sendFosterForm(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'required|string|max:500',
                'message' => 'nullable|string|max:1000',
            ],
            'public.animal.fosterForm',
            'New Foster Form',
            'elrefugio@example.com'
        );
    }

    /**
     * Muestra el formulario de contacto.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function contact()
    {
        return view('public.user.contact');
    }

    /**
     * Maneja el envío del formulario de contacto.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function sendContact(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'email' => 'required|email|max:255',
                'message' => 'required|string|min:10|max:1000',
            ],
            'public.user.contact',
            'New Contact Message',
            'elrefugio@example.com'
        );
    }

      /**
     * Muestra el formulario de voluntariado.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function volunteerForm()
    {
        return view('public.user.volunteerForm');
    }

    /**
     * Maneja el envío del formulario de voluntariado.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function sendVolunteerForm(Request $request)
    {
        return $this->handleFormSubmission(
            $request,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string|min:10|max:1000',
            ],
            'public.user.volunteerForm',
            'New Volunteer Form',
            'elrefugio@example.com'
        );
    }


    /**
     * Centraliza el manejo del envío de formularios.
     *
     * @param Request $request
     * @param array $rules
     * @param string $redirectRoute
     * @param string $subject
     * @param string $recipient
     * @param \Closure|null $customMessageBuilder
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleFormSubmission(Request $request, array $rules, string $redirectRoute, string $subject, string $recipient, \Closure $customMessageBuilder = null)
    {
        $validated = $request->validate($rules);

        try {
            $messageContent = $customMessageBuilder
                ? $customMessageBuilder($validated)
                : strip_tags($validated['message'] ?? '');

            Mail::raw($messageContent, function ($message) use ($validated, $subject, $recipient) {
                $message->to($recipient)
                        ->subject($subject)
                        ->from($validated['email']);
            });

            return redirect()->route($redirectRoute)->with('success', 'Form submitted successfully.');

        } catch (Exception $e) {
            Log::error("Error sending form ($subject): " . $e->getMessage());

            return back()->withErrors([
                'email' => 'An error occurred while sending the form. Please try again later.',
            ])->withInput();
        }
    }

}
