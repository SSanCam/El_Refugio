<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
   
    /**
     * Muestra el perfil del usuario autenticado.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

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

    if (empty($data['phone'] ?? null)) {
        $data['phone'] = null;
    }

    $user = Auth::user();

    if (! $user instanceof User) {
        abort(401, 'Usuario no autenticado');
    }

    $user->fill($data);

    if (array_key_exists('email', $data) && $user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.show')->with('status', 'profile-updated');
}

    /**
     * Elimina la cuenta del usuario.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
    
        $user = $request->user();

        if (! $user){
            return redirect()->route('public.home');
        }
        //Si tiene historial, desactivar en lugar de eliminar
        if ($user->adoptions()->exists() || $user->fosters()->exists()) {
            $user->update(['is_active' => false]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return Redirect()
                ->route('public.home')
                ->with('success', 'Usuario desactivado correctamente');
        } else {
            // En caso de no haber historiales registrados, eliminamos el usuario físicamente
            $user->delete();
        }

        return Redirect()->route('public.home');
    }
}