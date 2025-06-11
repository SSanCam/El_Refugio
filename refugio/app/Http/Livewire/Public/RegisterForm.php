<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotifications;
use Illuminate\Database\QueryException;
use Exception;

class RegisterForm extends Component
{
    public $dummy;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $terms = false;

    protected $rules = [
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|email|unique:users,email',
        'password'              => ['required','string','min:8','confirmed','regex:/^[A-Za-z\d@$!%*?&]+$/'],
        'terms'                 => 'accepted',
    ];

    public function register()
    {
        $this->validate();

        try {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Enviar email de confirmación
            Mail::to($user->email)
                ->send(new EmailNotifications($user->email, 'Cuenta creada'));

            // Login automático o redirección a login
            return redirect()->route('public.user.login')
                             ->with('success', 'Registro exitoso. Por favor inicia sesión.');
        }
        catch (QueryException $e) {
            $this->addError('email', 'Este correo ya está en uso.');
        }
        catch (Exception $e) {
            $this->addError('name', 'Ha ocurrido un error. Inténtalo de nuevo más tarde.');
        }
    }

    public function render()
    {
        return view('livewire.public.register-form');
    }
}
