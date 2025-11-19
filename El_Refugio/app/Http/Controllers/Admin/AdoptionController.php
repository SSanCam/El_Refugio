<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\User;
use App\Models\Animal;
use App\Enums\AnimalStatus;
use App\Enums\AnimalAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


/**
 * Controlador administrativo para la gestión de adopciones.
 * Permite listar, crear, actualizar y revisar adopciones.
 * Las operaciones afectan directamente al estado del animal.
 */

class AdoptionController extends Controller
{
    /**
     * Listado general de adopciones.
     * Incluye datos del animal y del usuario adoptante.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $adoptions = Adoption::with(['animal', 'user'])
            ->orderBy('adoption_date', 'desc')
            ->paginate(20);

        return view('admin.adoptions.index', compact('adoptions'));
    }

    /**
     * Formulario para registrar una nueva adopción.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $animals = Animal::where('status', AnimalStatus::SHELTERED->value || AnimalStatus::FOSTERED->value)
                ->where('availability', AnimalAvailability::AVAILABLE->value)
                ->get();
        return view('admin.adoptions.create', compact('animals'));
    }

    /**
     * Guardar una nueva adopción en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id'     => ['required', 'exists:animals,id'],
            'adoption_date' => ['required', 'date'],

            // Datos del adoptante (formulario manual)
            'name'        => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:255'],
            'address'     => ['nullable', 'string', 'max:255'],

            'contract_file' => ['nullable', 'string'],
            'comments'      => ['nullable', 'string'],
        ]);

        // Verificar que el animal sigue siendo adoptable (servidor, no solo en el formulario)
        $animal = Animal::where('id', $validated['animal_id'])
            ->where('status', AnimalStatus::SHELTERED->value)
            ->where('availability', AnimalAvailability::AVAILABLE->value)
            ->firstOrFail();

        // Buscar usuario existente por email o documento
        $user = User::query()
            ->where('email', $validated['email'])
            ->when($validated['national_id'] ?? null, function ($q, $dni) {
                $q->orWhere('national_id', $dni);
            })
            ->first();

        if ($user) {
            // Actualizar datos incompletos / desactualizados
            $user->fill([
                'name'        => $validated['name'],
                'last_name'   => $validated['last_name'],
                'national_id' => $validated['national_id'] ?? $user->national_id,
                'phone'       => $validated['phone'] ?? $user->phone,
                'address'     => $validated['address'] ?? $user->address,
            ])->save();
        } else {
            // Crear usuario nuevo con contraseña aleatoria en caso de no estar registrado
            $user = User::create([
                'name'        => $validated['name'],
                'last_name'   => $validated['last_name'],
                'email'       => $validated['email'],
                'password'    => Str::random(16), 
                'role'        => 'user',
                'national_id' => $validated['national_id'] ?? null,
                'phone'       => $validated['phone'] ?? null,
                'address'     => $validated['address'] ?? null,
            ]);
        }
        // Se crea el registro de la adopción
        $adoption = Adoption::create([
            'animal_id'     => $validated['animal_id'],
            'user_id'       => $user->id,
            'adoption_date' => $validated['adoption_date'],
            'contract_file' => $validated['contract_file'] ?? null,
            'comments'      => $validated['comments'] ?? null,
        ]);

        // Actualizar estado y disponibilidad del animal
        $adoption->animal->update([
            'status'       => AnimalStatus::ADOPTED->value,
            'availability' => AnimalAvailability::UNAVAILABLE->value,
        ]);

        return redirect()
            ->route('admin.adoptions.index')
            ->with('success', 'Adopción registrada correctamente.');
    }

    /**
     * Muestra los detalles de una adopción específica.
     * 
     * @param \App\Models\Adoption $adoption
     * @return \Illuminate\View\View
     */
    public function show(Adoption $adoption)
    {
        $adoption->load(['animal', 'user']);

        return view('admin.adoptions.show', compact('adoption'));
    }

    /**
     * Muestra el formulario para editar una adopción específica.
     * 
     * @param \App\Models\Adoption $adoption
     * @return \Illuminate\View\View
     */
    public function edit(Adoption $adoption)
    {
        $animals = Animal::all();
        $users = User::all();

        return view('admin.adoptions.edit', compact('adoption', 'animals', 'users'));
    }

    /**
     * Actualiza los datos de una adopción específica.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Adoption $adoption
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Adoption $adoption)
    {
        $validated = $request->validate([
            'animal_id' => ['required', 'exists:animals,id'],
            'user_id' => ['required', 'exists:users,id'],
            'adoption_date' => ['required', 'date'],
            'contract_file' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
        ]);

        $adoption->update($validated);

        return redirect()
            ->route('admin.adoptions.index')
            ->with('success', 'Adopción actualizada correctamente.');
    }

    /**
     * Elimina una adopción específica.
     * No cambia el estado del animal: se gestiona desde el panel del propio animal.
     * 
     * @param \App\Models\Adoption $adoption
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

        return redirect()
            ->route('admin.adoptions.index')
            ->with('success', 'Adopción eliminada correctamente.');
    }

}