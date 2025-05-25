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

        } catch (\Exception $e) {
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
            $animal = Animal::findOrFail($validated['animal_id']);
            $user = User::findOrFail($validated['user_id']);
            $validated = $request->validate([
                'animal_id' => 'required|exists:animals,id',
                'user_id' => 'required|exists:users,id',
                'adoption_date' => 'required|date',
                'notes' => 'nullable|string|max:255',
            ]);

        DB::transaction(function () use ($validated, $animal) {
            Adoption::create($validated);
            $animal->update(['status' => 'adopted']);
        });

            session()->flash('success', 'Adopción registrada correctamente.');
            return redirect()->route('admin.adoptions.index');

        } catch (\Exception $e) {
            Log::error('Error al registrar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al registrar la adopción.']);
        }
    }
}