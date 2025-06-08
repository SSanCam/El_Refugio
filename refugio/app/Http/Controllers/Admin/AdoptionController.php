<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\User;
use App\Enums\AnimalStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

/**
 * AdoptionController
 * Controlador para la gestión de adopciones de animales.
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
     * 
     * @throws Exception
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
     * 
     * @throws Exception
     */
    public function create()
    {
            try {
                $animals = Animal::where('status', AnimalStatus::AVAILABLE->value)->get();
                $users = User::where('active', true)->get();

                return view('admin.adoption.create', compact('animals', 'users'));
            } catch (Exception $e) {
                Log::error('Error al cargar el formulario de creación de adopciones: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el formulario de creación de adopciones.']);
            }
    }

    /**
     * Registra una nueva adopción.
     * 
     * @return mixed|\Illuminate\Http\RedirectResponse
     * 
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            // Validar los campos básicos
            $validated = $request->validate([
                'animal_id' => 'required|exists:animals,id',
                'email' => 'required|email',
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'adoption_date' => 'required|date',
                'notes' => 'nullable|string|max:255',
            ], [
                'animal_id.required' => 'El campo "Animal" es obligatorio.',
                'email.required' => 'El correo electrónico del usuario es obligatorio.',
                'email.email' => 'Debes proporcionar un correo electrónico válido.',
                'adoption_date.required' => 'La fecha de adopción es obligatoria.',
                'adoption_date.date' => 'La fecha debe ser válida.',
                'notes.max' => 'Las notas no pueden exceder los 255 caracteres.',
            ]);

            // Verificar si el usuario ya existe por email
            $usuario = User::where('email', $validated['email'])->where('active', true)->first();

            // Si no existe, lo creamos con los datos disponibles
            if (!$usuario) {
                $usuario = User::create([
                    'name' => $validated['name'] ?? 'Nombre pendiente',
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'role' => 'user',
                    'password' => bcrypt('temporal_' . uniqid()), // contraseña temporal
                ]);
            }

            $animal = Animal::find($validated['animal_id']);
            // Verificar que el animal esté disponible para adopción
            if (!in_array($animal->status, [
                AnimalStatus::AVAILABLE->value,
                AnimalStatus::FOSTERED->value,
                AnimalStatus::SHELTERED->value
            ])) {
                return redirect()->back()->withErrors(['animal_id' => 'El animal seleccionado no está disponible para adopción.']);
            }
            // Verificar que la fecha de adopción no sea anterior a la fecha de ingreso del animal
            if ($validated['adoption_date'] < $animal->intake_date) {
                return redirect()->back()->withErrors(['adoption_date' => 'La fecha de adopción no puede ser anterior a la fecha de ingreso del animal.']);
            }

            // Crear la adopción
            $adopcion = new Adoption();
            $adopcion->animal_id = $validated['animal_id'];
            $adopcion->user_id = $usuario->id;
            $adopcion->adoption_date = $validated['adoption_date'];
            $adopcion->notes = $validated['notes'] ?? null;
            $adopcion->save();

            // Cambiar estado del animal
            Animal::find($validated['animal_id'])->update(['status' => 'adopted']);

            return redirect()->route('admin.adoption.index')->with('success', 'Adopción registrada correctamente.');
        } catch (Exception $e) {
            Log::error('Error al registrar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al registrar la adopción.']);
        }
    }


    /**
     * Muestra los detalles de una adopción específica.
     *
     * @param int $id ID de la adopción
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * 
     * @throws ModelNotFoundException     
     * @throws Exception
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
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * 
     * @throws ModelNotFoundException     
     * @throws Exception
     */
    public function edit($id)
    {
        try {

            $adoption = Adoption::with(['animal', 'user'])->findOrFail($id);
            $animals = Animal::where('status', 'available')->orWhere('id', $adoption->animal_id)->get();
            $users = User::where('active', true)->get();

            return view('admin.adoption.edit', compact('adoption', 'animals', 'users'));
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
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws ModelNotFoundException     
     * @throws Exception
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

            return redirect()->route('admin.adoption.index')->with('success', 'Adopción actualizada correctamente.');
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
     * 
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function destroy($id)
    {
        try {

            $adoption = Adoption::findOrFail($id);
            $animal = Animal::findOrFail($adoption->animal_id);

            $adoption->delete();
            $animal->update(['status' => 'available']);

            return redirect()->route('admin.adoption.index')->with('success', 'Adopción eliminada correctamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Adopción no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Adopción no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al eliminar la adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al eliminar la adopción.']);
        }
    }
}
