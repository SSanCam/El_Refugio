<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

/**
 * Controlador administrativo para la gestión de animales.
 * Permite listar, crear, actualizar y eliminar animales.
 */
class AnimalController extends Controller
{
    /**
     * Mostrar un listado de los animales.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $animals = Animal::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.animals.index', compact('animals'));
    }

    /**
     * Mostrar el formulario para crear un nuevo animal.
     */
    public function create()
    {
        return view('admin.animals.create');
    }

    /**
     * Guardar un nuevo animal en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'species'      => ['required', 'string'],
            'breed'        => ['nullable', 'string', 'max:255'],
            'sex'          => ['nullable', 'string'],
            'size'         => ['nullable', 'string'],
            'weight'       => ['nullable', 'numeric'],
            'height'       => ['nullable', 'numeric'],
            'neutered'     => ['boolean'],
            'microchip'    => ['nullable', 'string', 'max:255'],
            'birth_date'   => ['nullable', 'date'],
            'status'       => ['required', 'string'],
            'availability' => ['required', 'string'],
            'entry_date'   => ['required', 'date'],
            'description'  => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
            'is_featured'  => ['boolean'],
        ]);

        Animal::create($validated);

        return redirect()
            ->route('admin.animals.index')
            ->with('success', 'Animal registrado correctamente.');
    }

    /**
     * Mostrar los detalles de un animal específico.
     * 
     * @param \App\Models\Animal $animal
     * @return \Illuminate\View\View
     */
    public function show(Animal $animal)
    {
        return view('admin.animals.show', compact('animal'));
    }

    /**
     * Mostrar el formulario para editar un animal específico.
     * 
     * @param \App\Models\Animal $animal
     * @return \Illuminate\View\View
     */
    public function edit(Animal $animal)
    {
        return view('admin.animals.edit', compact('animal'));
    }

    /**
     * Actualizar un animal específico en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Animal $animal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Animal $animal)
    {
        $validated = $request->validate([
                    'name'         => ['required', 'string', 'max:255'],
                    'species'      => ['required', 'string'],
                    'breed'        => ['nullable', 'string', 'max:255'],
                    'sex'          => ['nullable', 'string'],
                    'size'         => ['nullable', 'string'],
                    'weight'       => ['nullable', 'numeric'],
                    'height'       => ['nullable', 'numeric'],
                    'neutered'     => ['boolean'],
                    'microchip'    => ['nullable', 'string', 'max:255'],
                    'birth_date'   => ['nullable', 'date'],
                    'status'       => ['required', 'string'],
                    'availability' => ['required', 'string'],
                    'entry_date'   => ['required', 'date'],
                    'description'  => ['nullable', 'string'],
                    'observations' => ['nullable', 'string'],
                    'is_featured'  => ['boolean'],
                ]);

                $animal->update($validated);

                return redirect()
                    ->route('admin.animals.index')
                    ->with('success', 'Información del animal actualizada correctamente.');
    }

    /**
     * Eliminar un animal específico de la base de datos.
     * 
     * @param \App\Models\Animal $animal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();

        return redirect()
            ->route('admin.animals.index')
            ->with('success', 'Animal eliminado correctamente.');
    }
}
