<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
   
    /**
     * Muestra el formulario del perfil del usuario.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza el perfil del usuario.
     * 
     * @param \App\Http\Requests\ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $data = $request->validated();

    // Normalizar teléfono: vacío => null
    if (empty($data['phone'] ?? null)) {
        $data['phone'] = null;
    }

    $user = $request->user();
    $user->fill($data);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Elimina la cuenta del usuario.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        //Si tiene historial, desactivar en lugar de eliminar
        if ($user->adoptions()->exists() || $user->fosters()->exists()) {
            $user->update(['is_active' => false]);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return Redirect::to('/')->with('success', 'Usuario desactivado correctamente. Se conserva su historial.');
        } else {
            // En caso de no haber historiales registrados, eliminamos el usuario físicamente
            $user->delete();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}