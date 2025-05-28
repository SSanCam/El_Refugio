<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Enums\SponsorshipStatus;
use Exception;

/**
 * SponsorshipController
 * Controlador para la gestión de apadrinamientos de animales.
 */
class SponsorshipController extends Controller
{
    /**
     * Muestra un listado de apadrinamientos.
     */
    public function index()
    {
        try {
            $sponsorships = Sponsorship::with(['user', 'animal'])->paginate(10);
            return view('admin.sponsorship.index', compact('sponsorships'));
        } catch (QueryException $e) {
            Log::error('Error al obtener los apadrinamientos: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al obtener los apadrinamientos.']);
        }
    }

    /**
     * Muestra los detalles de un apadrinamiento específico.
     */
    public function show($id)
    {
        try {
            $sponsorship = Sponsorship::with(['user', 'animal'])->findOrFail($id);
            return view('admin.sponsorship.show', compact('sponsorship'));
        } catch (QueryException $e) {
            Log::error('Error al obtener el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al obtener el apadrinamiento.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener el apadrinamiento.']);
        }
    }
    /**
     * Muestra el formulario para editar un apadrinamiento.
     */
    public function edit($id)
    {
        try {
            $sponsorship = Sponsorship::findOrFail($id);
            $animal = $sponsorship->animal;
            return view('admin.sponsorship.edit', compact('sponsorship', 'animal'));
        } catch (QueryException $e) {
            Log::error('Error al mostrar el formulario de edición de apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al mostrar el formulario de edición de apadrinamiento.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al mostrar el formulario de edición de apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al mostrar el formulario de edición de apadrinamiento.']);
        }
    }

    /**
     * Actualiza un apadrinamiento existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'animal_id' => 'required|exists:animals,id',
            'email' => 'required|email|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:' . implode(',', SponsorshipStatus::values()),
            'donation_amount' => 'required|numeric|min:0',
            'donation_interval' => 'required|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $sponsorship = Sponsorship::findOrFail($id);
            $sponsorship->update($request->only([
                'user_id',
                'start_date',
                'end_date',
                'status',
                'donation_amount',
                'donation_interval',
                'notes',
                'email'
            ]));

 
            return redirect()->route('admin.sponsorships.index')->with('success', 'Apadrinamiento actualizado exitosamente.');

        } catch (QueryException $e) {
            Log::error('Error al actualizar el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al actualizar el apadrinamiento.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al actualizar el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al actualizar el apadrinamiento.']);
        }
    }
    /**
     * Elimina un apadrinamiento de la base de datos.
     */
    public function destroy($id)
    {
        try {
            $sponsorship = Sponsorship::findOrFail($id);
            $sponsorship->delete();

            return redirect()->route('admin.sponsorships.index')->with('success', 'Apadrinamiento eliminado exitosamente.');
        } catch (QueryException $e) {
            Log::error('Error al eliminar el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al eliminar el apadrinamiento.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al eliminar el apadrinamiento.']);
        }
    }

    /**
     * Cancela un apadrinamiento.
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        try {
            $sponsorship = Sponsorship::findOrFail($id);
            $sponsorship->status = SponsorshipStatus::CANCELED;
            $sponsorship->save();

            return redirect()->route('admin.sponsorships.index')->with('success', 'Apadrinamiento cancelado exitosamente.');
        } catch (QueryException $e) {
            Log::error('Error al cancelar el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cancelar el apadrinamiento.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al cancelar el apadrinamiento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cancelar el apadrinamiento.']);
        }
    }

}