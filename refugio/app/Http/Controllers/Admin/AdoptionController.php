<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

/**
 * AdoptionController
 */
class AdoptionController extends Controller
{
    /**
     * ==========================================================
     * Funcionalidades básicas para la gestión de adopciones 
     * ==========================================================
    */
    
    /**
     * Muestra un listado de adopciones.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {

            $adoptions = Adoption::paginate(10);

            if ($adoptions->isEmpty()) {
                session()->flash('info', 'No hay adopciones registradas aún.');
            }

            return view('admin.adoption.index', compact('adoptions'));

        } catch (Exception $e) {
            Log::error('Error al cargar el listado de adopciones: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el listado de adopciones.']);
        }
    }


    /**
     * Muestra el formulario para crear una nueva adopción.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse 
     */
    public function create()
    {
        try {

            $animals = Animal::where('status', 'available')->get();
            $users = User::where('active', true)->get();
            
            return view('admin.adoptions.create', compact('animals', 'users'));

        } catch (Exception $e) {
            Log::error('Error al cargar el formulario de creación de adopciones: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el formulario de creación de adopciones.']);
        }
    }

    /**
     * Registra una nueva adopción.
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        
        try {

            $validated = $request->validate([
                'animal_id' => 'required|exists:animals,id',
                'user_id' => 'required|exists:users,id',
                'adoption_date' => 'required|date',
                'notes' => 'nullable|string|max:255',
            ],
        [
            'animal_id.required' => 'El campo "Animal" es obligatorio.',
            'user_id.required' => 'El campo "Usuario" es obligatorio.',
            'adoption_date.required' => 'La fecha de adopción es obligatoria.',
            'adoption_date.date' => 'La fecha de adopción debe ser una fecha válida.',
            'notes.max' => 'Las notas no pueden exceder los 255 caracteres.',
            ]);

            $validated = $request->validate([
                'animal_id' => 'required|exists:animals,id',
                'user_id' => 'required|exists:users,id',
                'adoption_date' => 'required|date',
                'notes' => 'nullable|string|max:255',
            ]);

            $newAdoption = new Adoption();
            $newAdoption->animal_id = $validated['animal_id'];
            $newAdoption->user_id = $validated['user_id'];
            $newAdoption->adoption_date = $validated['adoption_date'];
            $newAdoption->notes = $validated['notes'] ?? null;
            $newAdoption->save();

            Animal::find($validated['animal_id'])->update(['status' => 'adopted']);



            return redirect()->route('admin.adoptions.index')->with('success', 'Adopción registrada correctamente.');

        
        } catch (Exception $e) {
            Log::error('Error al registrar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al registrar la adopción.']);
        }
    }

    /**
     * Muestra los detalles de una adopción específica.
     *
     * @param int $id ID de la adopción
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {

            $adoption = Adoption::with(['animal', 'user'])->findOrFail($id);

            return view('admin.adoption.show', compact('adoption'));

        } catch (ModelNotFoundException $e) {
            Log::error('Adopción no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Adopción no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al mostrar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al mostrar la adopción.']);
        }
    }

    /**
     * Muestra el formulario para editar una adopción específica.
     *
     * @param int $id ID de la adopción
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {

            $adoption = Adoption::with(['animal', 'user'])->findOrFail($id);
            $animals = Animal::where('status', 'available')->orWhere('id', $adoption->animal_id)->get();
            $users = User::where('active', true)->get();

            return view('admin.adoptions.edit', compact('adoption', 'animals', 'users'));

        } catch (ModelNotFoundException $e) {
            Log::error('Adopción no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Adopción no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al cargar el formulario de edición de adopciones: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el formulario de edición de adopciones.']);
        }
    }

    /**
     * Actualiza una adopción existente.
     *
     * @param Request $request
     * @param int $id ID de la adopción
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {

            $validated = $request->validate([
                'animal_id' => 'required|exists:animals,id',
                'user_id' => 'required|exists:users,id',
                'adoption_date' => 'required|date|before_or_equal:today',
                'notes' => 'nullable|string|max:255',
            ]);

            $animal = Animal::findOrFail($validated['animal_id']);

            if ($validated['adoption_date'] < $animal->intake_date) {
                return redirect()->back()->withErrors(['adoption_date' => 'La fecha de adopción no puede ser anterior a la fecha de ingreso del animal.']);
            }

            $adoption = Adoption::findOrFail($id);
            $adoption->animal_id = $validated['animal_id'];
            $adoption->user_id = $validated['user_id'];
            $adoption->adoption_date = $validated['adoption_date'];
            $adoption->notes = $validated['notes'] ?? null;
            $adoption->save();

            return redirect()->route('admin.adoptions.index')->with('success', 'Adopción actualizada correctamente.');

        } catch (ModelNotFoundException $e) {
            Log::error('Adopción no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Adopción no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al actualizar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al actualizar la adopción.']);
        }
    }

    /**
     * Elimina una adopción existente.
     *
     * @param int $id ID de la adopción
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {

            $adoption = Adoption::findOrFail($id);
            $animal = Animal::findOrFail($adoption->animal_id);

            $adoption->delete();
            $animal->update(['status' => 'available']);

            return redirect()->route('admin.adoptions.index')->with('success', 'Adopción eliminada correctamente.');

        } catch (ModelNotFoundException $e) {
            Log::error('Adopción no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Adopción no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al eliminar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al eliminar la adopción.']);
        }
    }
}