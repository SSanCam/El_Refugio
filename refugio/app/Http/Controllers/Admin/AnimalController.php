<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

/**
 * Controlador para gestionar los animales del refugio.
 */
class AnimalController extends Controller
{
    /** ==========================================================
     * Funcionalidades básicas para la gestión de animales 
     * ==========================================================
     */
    
     /**
     * Muestra un listado paginado de animales, con filtro por nombre, especie,
     * raza, sexo y estado de adopción.
     * 
     * @param Request $request Solicitud HTTP con los parámetros de búsqueda.
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse Vista con la lista de animales.
     */
    public function index(Request $request)
    {
        try {
            $animals = \App\Models\Animal::paginate(10);

            if ($animals->isEmpty()) {
                session()->flash('info', 'No hay animales registrados aún.');
            }

            return view('admin.animal.index', compact('animals'));

        } catch (QueryException $e) {
            Log::error('Error de consulta al obtener los animales: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error de consulta al obtener los animales.']);
            
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener los animales: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener los animales.']);
        }
    }


    /**
     * Muestra el formulario para crear un nuevo animal.
     * 
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse Vista del formulario de creación de animal.
     */
    public function create()
    {
        try {
            return view('admin.animal.create');
        } catch (Exception $e) {
            Log::error('Error al mostrar el formulario de creación de animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al mostrar el formulario de creación de animal.']);    
        }
    }

    /**
     * Almacena un nuevo animal en la base de datos.
     * 
     * @param Request $request Solicitud HTTP con los datos del nuevo animal.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de animales.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'size' => 'required|in:small,medium,large',
            'sex' => 'required|in:male,female,unknown',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,adopted,fostered,sponsored,sheltered,intake,deceased',
            'microchip' => 'nullable|string|max:255|unique:animals,microchip',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|url|max:255',
            ],
            [
            'name.required' => 'El nombre del animal es obligatorio.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',

            'species.required' => 'La especie del animal es obligatoria.',
            'species.max' => 'La especie no puede exceder los 255 caracteres.',

            'breed.max' => 'La raza no puede exceder los 255 caracteres.',

            'age.required' => 'La edad del animal es obligatoria.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad no puede ser negativa.',

            'size.required' => 'El tamaño del animal es obligatorio.',
            'size.in' => 'El tamaño debe ser: small, medium o large.',

            'sex.required' => 'El sexo del animal es obligatorio.',
            'sex.in' => 'El sexo debe ser: male, female o unknown.',

            'status.required' => 'El estado del animal es obligatorio.',
            'status.in' => 'El estado debe ser uno de los valores permitidos.',

            'microchip.max' => 'El microchip no puede exceder los 255 caracteres.',
            'microchip.unique' => 'Este microchip ya está registrado para otro animal.',

            'description.required' => 'La descripción del animal es obligatoria.',
            'description.max' => 'La descripción no puede exceder los 1000 caracteres.',

            'image.url' => 'La imagen debe ser una URL válida.',
            'image.max' => 'La URL de la imagen no puede exceder los 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            
            \App\Models\Animal::create([
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'breed' => $request->input('breed'),
            'age' => $request->input('age'),
            'size' => $request->input('size'),
            'sex' => $request->input('sex'),
            'weight' => $request->input('weight'),
            'status' => $request->input('status'),
            'microchip' => $request->input('microchip'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
        ]);

            return redirect()->route('admin.animals.index')->with('success', 'Animal creado exitosamente.');

        } catch (QueryException $e) {
            Log::error('Error al guardar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al guardar el animal.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al guardar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al guardar el animal.']);
        }
    }


    /**
     * Muestra los detalles de un animal específico.
     * 
     * @param int $id ID del animal a mostrar.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista con los detalles del animal.
     */
    public function show($id)
    {
        try {
            $animal = \App\Models\Animal::findOrFail($id);
            return view('admin.animal.show', compact('animal'));
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (QueryException $e) {
            Log::error('Error de consulta al obtener el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error de consulta al obtener el animal.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener el animal.']);
        }
    }

    /**
     * Muestra el formulario para editar un animal existente.
     * 
     * @param int $id ID del animal a editar.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista del formulario de edición de animal.
     */
    public function edit($id)
    {
        try {
            $animal = \App\Models\Animal::findOrFail($id);
            return view('admin.animal.edit', compact('animal'));
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (QueryException $e) {
            Log::error('Error de consulta al obtener el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error de consulta al obtener el animal.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener el animal.']);
        }
    }

    /**
     * Actualiza un animal existente en la base de datos.
     * 
     * @param Request $request Solicitud HTTP con los datos actualizados del animal.
     * @param int $id ID del animal a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de animales.
     */
    public function update(Request $request, $id)
    {
        try {
            $animal = \App\Models\Animal::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'species' => 'required|string|max:255',
                'breed' => 'nullable|string|max:255',
                'age' => 'required|integer|min:0',
                'size' => 'required|in:small,medium,large',
                'sex' => 'required|in:male,female,unknown',
                'status' => 'required|in:available,adopted,fostered,sponsored,sheltered,intake,deceased',
                'description' => 'required|string|max:1000',
                'image' => 'nullable|url|max:255',
            ], [
                'name.required' => 'El nombre del animal es obligatorio.',
                'name.max' => 'El nombre no puede exceder los 255 caracteres.',
                'species.required' => 'La especie del animal es obligatoria.',
                'species.max' => 'La especie no puede exceder los 255 caracteres.',
                'breed.max' => 'La raza no puede exceder los 255 caracteres.',
                'age.required' => 'La edad del animal es obligatoria.',
                'age.integer' => 'La edad debe ser un número entero.',
                'age.min' => 'La edad no puede ser negativa.',
                'size.required' => 'El tamaño del animal es obligatorio.',
                'size.in' => 'El tamaño debe ser: small, medium o large.',
                'sex.required' => 'El sexo del animal es obligatorio.',
                'sex.in' => 'El sexo debe ser: male, female o unknown.',
                'status.required' => 'El estado del animal es obligatorio.',
                'status.in' => 'El estado debe ser uno de los valores permitidos.',
                'description.required' => 'La descripción del animal es obligatoria.',
                'description.max' => 'La descripción no puede exceder los 1000 caracteres.',
                'image.url' => 'La imagen debe ser una URL válida.',
                'image.max' => 'La URL de la imagen no puede exceder los 255 caracteres.',
            ]);

            if (!empty ($validated['microchip'])) {
                $existingAnimal = \App\Models\Animal::where('microchip', $validated['microchip'])
                    ->where('id', '!=', $animal->id)
                    ->first();
                if ($existingAnimal) {
                    return redirect()->back()->withErrors(['microchip' => 'Este microchip ya está registrado para otro animal.'])->withInput();
                }
            } else {
                $validated['microchip'] = null; // Si no se proporciona microchip, se establece como nulo
            }

            $animal->update($validated);
            return redirect()->route('admin.animals.index')->with('success', 'Animal actualizado exitosamente.');

        } catch (QueryException $e) {
            Log::error('Error de consulta al actualizar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error de consulta al actualizar el animal.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al actualizar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al actualizar el animal.']);
        }
    }

    /**
     * Elimina un animal de la base de datos.
     * 
     * @param int $id ID del animal a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de animales.
     */
    public function destroy($id)
    {
        try {
            $animal = \App\Models\Animal::findOrFail($id);

            if ($animal->status === 'adopted' || $animal->status === 'fostered') {
                return redirect()->back()->withErrors(['error' => 'No se puede eliminar un animal con procesos abiertos.']);
            } else {
                $animal->delete();
            }

            return redirect()->route('admin.animals.index')->with('success', 'Animal eliminado exitosamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (QueryException $e) {
            Log::error('Error de consulta al eliminar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error de consulta al eliminar el animal.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al eliminar el animal.']);
        }
    }

    /**
     * ==========================================================
     * Funcionalidades de gestión de animales
     * ==========================================================
     */

    /**
     * Cambia el estado de un animal.
     * @param \Illuminate\Http\Request $request Solicitud HTTP con el nuevo estado del animal.
     * @param mixed $id ID del animal a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la vista del animal actualizado o error.
     */
    public function changeStatus(Request $request, $id)
        {
            try {
                $animal = \App\Models\Animal::findOrFail($id);
                $request->validate([
                    'status' => 'required|in:available,adopted,fostered,sponsored,sheltered,intake,deceased',
                ]);
                $animal->update(['status' => $request->input('status')]);
                return redirect()->route('admin.animals.show', $animal->id)->with('success', 'Estado actualizado correctamente.');
            } catch (Exception $e) {
                Log::error('Error al actualizar el estado del animal: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Error al actualizar el estado.']);
            }
        }

    /**
     * Desactiva un animal, cambiando su estado a "sheltered" o cualquier otro estado neutro.
     * @param int $id ID del animal a desactivar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de animales con mensaje de éxito.
     */
    public function deactivate($id)
        {
            $animal = \App\Models\Animal::findOrFail($id);
            $animal->status = 'sheltered'; // o cualquier otro estado neutro
            $animal->save();
            return redirect()->route('admin.animals.index')->with('success', 'Animal desactivado.');
        }

}