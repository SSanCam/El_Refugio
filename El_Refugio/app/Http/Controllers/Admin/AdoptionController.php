<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\User;
use App\Models\Animal;
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
     */
    public function create()
    {
        $animals = Animal::where('status', 'available')->get();

        return view('admin.adoptions.create', compact('animals'));
    }

    /**
     * Guardar una nueva adopción en la base de datos.
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
            // Crear usuario nuevo con contraseña aleatoria
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

        // Actualizar el estado del animal a 'adopted'
        $adoption->animal->update(['status' => 'adopted']);

        return redirect()
            ->route('admin.adoptions.index')
            ->with('success', 'Adopción registrada correctamente.');
    }

    /**
     * Muestra los detalles de una adopción específica.
     */
    public function show(Adoption $adoption)
    {
        $adoption->load(['animal', 'user']);

        return view('admin.adoptions.show', compact('adoption'));
    }

    /**
     * Muestra el formulario para editar una adopción específica.
     */
    public function edit(Adoption $adoption)
    {
        $animals = Animal::all();
        $users = User::all();

        return view('admin.adoptions.edit', compact('adoption', 'animals', 'users'));
    }

    /**
     * Actualiza los datos de una adopción específica.
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
     */
    public function destroy(Adoption $adoption)
    {
        $adoption->delete();

        return redirect()
            ->route('admin.adoptions.index')
            ->with('success', 'Adopción eliminada correctamente.');
    }

}