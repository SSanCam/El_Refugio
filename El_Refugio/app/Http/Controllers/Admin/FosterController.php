<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foster;
use App\Models\Animal;
use Illuminate\Http\Request;
use App\Enums\AnimalStatus;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * Controlador administrativo para la gestión de acogidas.
 * Permite listar, crear, actualizar y revisar acogidas.
 * Las operaciones afectan directamente al estado y disponibilidad del animal.
 */
class FosterController extends Controller
{
    /**
     * Listar todas las acogidas.
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $fosters = Foster::with(['animal', 'user'])
            ->when($search, function ($query) use ($search) {
                $query
                    ->whereHas('animal', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('admin.fosters.index', compact('fosters', 'search'));
    }


    /**
     * Formulario para crear una nueva acogida.
     * Animales que están en refugio; la adoptabilidad se controla con 'availability', 
     * pero aquí pueden ser acogidos aunque no estén disponibles para adopción, ya que algunas acogidas 
     * pueden ser mientras el animal está en recuperación veterinaria.  
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $animals= Animal::where('status', AnimalStatus::SHELTERED->value)
                ->orderBy('id')
                ->get();

        return view('admin.fosters.create', compact('animals'));
    }

    /**
     * Crear una nueva acogida en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id'  => ['required', 'exists:animals,id'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['nullable', 'date', 'after:start_date'],

            // Datos del tutor de acogida (formulario manual)
            'name'        => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'national_id' => ['nullable', 'string'],
            'phone'       => ['nullable', 'string'],
            'address'     => ['nullable', 'string'],
            // Datos adicionales por parte del refugio
            'contract_file' => ['nullable', 'string'],
            'comments'      => ['nullable', 'string'],
        ]);

        // Verificar que el animal sigue siendo acogible: está en refugio.
        $animal = Animal::where('id', $validated['animal_id'])
            ->where('status', AnimalStatus::SHELTERED->value)
            ->firstOrFail();

        // Evitar dos acogidas activas simultáneas para el mismo animal.
        $hasActiveFoster = Foster::where('animal_id', $animal->id)
            ->whereNull('end_date')
            ->exists();

        if ($hasActiveFoster) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal ya tiene una acogida activa.']);
        }

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

        // Crear la acogida
        Foster::create([
            'animal_id'     => $animal->id,
            'user_id'       => $user->id,
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'] ?? null,
            'contract_file' => $validated['contract_file'] ?? null,
            'comments'      => $validated['comments'] ?? null,
        ]);

        // Actualizar estado y disponibilidad del animal
        $animal->update([
            'status'       => AnimalStatus::FOSTERED->value,
        ]);

        return redirect()
            ->route('admin.fosters.index')
            ->with('success', 'Acogida registrada correctamente.');
    }
    
    /**
     * Muestra los detalles de una acogida específica.
     * 
     * @param \App\Models\Foster $foster
     * @return \Illuminate\View\View
     */
    public function show(Foster $foster)
    {
        return view('admin.fosters.show', compact('foster'));
    }

    /**
     * Mostrar el formulario para editar una acogida específica. 
     * 
     * @param \App\Models\Foster $foster
     * @return \Illuminate\View\View
     */
    public function edit(Foster $foster)
    {
        $animals= Animal::where(function($query) use ($foster) {
                $query->where('status', AnimalStatus::SHELTERED->value)
                      ->orWhere('id', $foster->animal_id);
            })->get();

        return view('admin.fosters.edit', compact('foster', 'animals'));
    }

    /**
     * Actualiza los datos de una acogida específica.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Foster $foster
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Foster $foster)
    {
        $validated = $request->validate([
            'animal_id'  => ['required', 'exists:animals,id'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['nullable', 'date', 'after:start_date'],

            // Datos del tutor de acogida (formulario manual)
            'name'        => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'national_id' => ['nullable', 'string'],
            'phone'       => ['nullable', 'string'],
            'address'     => ['nullable', 'string'],
            // Datos adicionales por parte del refugio
            'contract_file' => ['nullable', 'string'],
            'comments'      => ['nullable', 'string'],
        ]);

        // Animal seleccionado en el formulario
        $animal = Animal::findOrFail($validated['animal_id']);

        // Evitar dos acogidas activas simultáneas para el mismo animal.
        if ($animal->id !== $foster->animal_id) {
            $hasActiveFoster = Foster::where('animal_id', $animal->id)
                ->whereNull('end_date')
                ->exists();

            if ($hasActiveFoster) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['animal_id' => 'Este animal ya tiene una acogida activa.']);
            }
        }

        // Actualizar datos del usuario tutor
        $user = $foster->user;
        $user->fill([
            'name'        => $validated['name'],
            'last_name'   => $validated['last_name'],
            'email'       => $validated['email'],
            'national_id' => $validated['national_id'] ?? $user->national_id,
            'phone'       => $validated['phone'] ?? $user->phone,
            'address'     => $validated['address'] ?? $user->address,
        ])->save();

        // Actualizar la acogida
        $foster->update([
            'animal_id'     => $animal->id,
            'user_id'       => $user->id,
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'] ?? null,
            'contract_file' => $validated['contract_file'] ?? null,
            'comments'      => $validated['comments'] ?? null,
        ]);

        return redirect()
            ->route('admin.fosters.index')
            ->with('success', 'Acogida actualizada correctamente.');
    }

    /**
     * Eliminar una acogida específica de la base de datos.
     */
    public function destroy(Foster $foster)
    {
        $foster->delete();

        return redirect()
            ->route('admin.fosters.index')
            ->with('success', 'Acogida eliminada correctamente.');
    }
}
