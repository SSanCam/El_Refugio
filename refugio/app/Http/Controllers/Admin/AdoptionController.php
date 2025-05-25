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
}