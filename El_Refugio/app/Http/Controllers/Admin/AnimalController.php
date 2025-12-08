<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $animals = Animal::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('breed', 'like', "%{$search}%")
                    ->orWhere('microchip', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('admin.animals.index', compact('animals', 'search'));
    }


    /**
     * Mostrar el formulario para crear un nuevo animal.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('admin.animals.index');
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
            'species'      => ['required', Rule::in(['dog', 'cat', 'other'])],
            'breed'        => ['nullable', 'string', 'max:255'],
            'sex'          => ['nullable', Rule::in(['male', 'female', 'unknown'])],
            'size'         => ['nullable', Rule::in(['small', 'medium', 'large'])],
            'weight'       => ['nullable', 'numeric'],
            'height'       => ['nullable', 'numeric'],
            'neutered'     => ['boolean'],
            'microchip'    => ['nullable', 'string', 'max:255'],
            'birth_date'   => ['nullable', 'date'],
            'status'       => ['required', Rule::in(['sheltered', 'adopted', 'fostered', 'deceased'])],
            'availability' => ['required', Rule::in(['available', 'unavailable'])],
            'entry_date'   => ['required', 'date'],
            'description'  => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
            'is_featured'  => ['boolean'],
        ]);

        $animal = Animal::create($validated);

        if ($request->photo_url) {
            $animal->images()->create([
                'url' => $request->photo_url,
                'alt_text' => $request->photo_alt,
            ]);
        }

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Animal $animal)
    {
         return redirect()->route('admin.animals.index')->with('edit_animal_id', $animal->id);
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
                    'species' => ['required', Rule::in(['dog', 'cat', 'other'])],
                    'breed'        => ['nullable', 'string', 'max:255'],
                    'sex'          => ['nullable', Rule::in(['male', 'female', 'unknown'])],
                    'size'         => ['nullable', Rule::in(['small', 'medium', 'large'])],
                    'weight'       => ['nullable', 'numeric'],
                    'height'       => ['nullable', 'numeric'],
                    'neutered'     => ['boolean'],
                    'microchip'    => ['nullable', 'string', 'max:255'],
                    'birth_date'   => ['nullable', 'date'],
                    'status'       => ['required', Rule::in(['sheltered', 'adopted', 'fostered', 'deceased'])],
                    'availability' => ['required', Rule::in(['available', 'unavailable'])],
                    'entry_date'   => ['required', 'date'],
                    'description'  => ['nullable', 'string'],
                    'observations' => ['nullable', 'string'],
                    'is_featured'  => ['boolean'],
                ]);

                $animal->update($validated);

                if ($request->photo_url) {
                    $animal->images()->create([
                        'url' => $request->photo_url,
                        'alt_text' => $request->photo_alt,
                    ]);
                }


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

    /**
     * Metodo para agregar una fotografia a un animal concreto
     * 
     * @param Animal $animal
     * @param string $photo URL de la imagen 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPhoto(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'photo_url' => ['required', 'url'],
            'photo_alt' => ['nullable', 'string', 'max:255'],
        ]);

        $animal->photos()->create([
            'url' => $validated['photo_url'],
            'alt_text' => $validated['photo_alt'],
        ]);

        return redirect()
            ->route('admin.animals.index')
            ->with('success', 'Fotografía agregada correctamente.');
    }

}