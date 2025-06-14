<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\User;
use App\Mail\SponsorshipNotificationMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Enums\AnimalStatus;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

/**
 * Controlador para gestionar los animales del refugio.
 */
class AnimalController extends Controller
{
    /** ==========================================================
     * Funcionalidades básicas para la gestión de animales 
     * ========================================================== */

    /**
     * Muestra un listado paginado de animales.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */

    public function index()

    {
        try {
            $animals = Animal::paginate(10);

            if ($animals->isEmpty()) {
                session()->flash('info', 'No hay animales registrados aún.');
            }

            return view('admin.animal.index', compact('animals'));

        } catch (Exception $e) {
            Log::error('Error inesperado al obtener los animales: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener los animales.']);
        }
    }

    /**
     * Muestra el formulario para crear un nuevo animal.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function create()
    {
        try {

            return view('admin.animal.create');

        } catch (Exception $e) {
            Log::error('Error al mostrar el formulario de creación de adopción: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'No se pudo mostrar el formulario. Inténtalo más tarde.']);
        }
    }

    /**
     * Almacena un nuevo animal en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\QueryException
     * @throws \Exception
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Animal::create($request->all());
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
     * @param int $id ID del animal
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function show($id)
    {
        try {
            $animal = Animal::with([
                'adoptions.user',
                'fosters.user',
                'sponsorships.user'
            ])->findOrFail($id);

            return view('admin.animal.show', compact('animal'));
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener el animal.']);
        }
    }

    /**
     * Muestra el formulario para editar un animal.
     * 
     * @param int $id ID del animal
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function edit($id)
    {
        try {
            $animal = Animal::findOrFail($id);
            return view('admin.animal.edit', compact('animal'));
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al obtener el animal.']);
        }
    }

    /**
     * Actualiza un animal existente en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id ID del animal
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\QueryException
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        try {
            $animal = Animal::findOrFail($id);

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
            ]);

            if (!empty($validated['microchip'])) {
                $existing = Animal::where('microchip', $validated['microchip'])->where('id', '!=', $id)->first();
                if ($existing) {
                    return redirect()->back()->withErrors(['microchip' => 'Este microchip ya está registrado.'])->withInput();
                }
            } else {
                $validated['microchip'] = null;
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
     * Elimina un animal.
     * 
     * @param int $id ID del animal
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     * @throws \Illuminate\Database\QueryException
     */
    public function destroy($id)
    {
        try {
            $animal = Animal::findOrFail($id);

            if (in_array($animal->status, ['adopted', 'fostered'])) {
                return redirect()->back()->withErrors(['error' => 'No se puede eliminar un animal con procesos abiertos.']);
            }

            $animal->delete();
            return redirect()->route('admin.animals.index')->with('success', 'Animal eliminado exitosamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar el animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al eliminar el animal.']);
        }
    }

    /**
     * ==================================================================
     * Funcionalidades adicionales para la gestión de estados de animales
     * ==================================================================
     */

    /**
     * Cambia el estado de un animal.
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id ID del animal
     * 
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Database\QueryException
     * @throws \Exception
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $animal = Animal::findOrFail($id);

            $request->validate([
                'status' => ['required', Rule::in(array_column(AnimalStatus::cases(), 'value'))],
            ]);

            $animal->update(['status' => $request->input('status')]);

            // Si el nuevo estado es "fallecido" o "adoptado", notificar a los padrinos
            if (in_array($request->input('status'), ['deceased', 'adopted'])) {
                $activeSponsorships = $animal->sponsorships()->where('status', 'active')->get();

                foreach ($activeSponsorships as $sponsorship) {
                    $sponsorship->status = 'finished';
                    $sponsorship->end_date = now();
                    $sponsorship->save();

                    Mail::to($sponsorship->user->email)->send(
                        new SponsorshipNotificationMail(
                            $animal->name,
                            $sponsorship->user->name,
                            'fin',
                            $request->input('status') === 'adopted' ? 'adopted' : 'deceased'
                        )
                    );
                }
            }

            return redirect()->route('admin.animals.show', $animal->id)->with('success', 'Estado actualizado correctamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Animal no encontrado: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Animal no encontrado.']);
        } catch (QueryException $e) {
            Log::error('Error de consulta al cambiar el estado del animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error de consulta al cambiar el estado del animal.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al cambiar el estado del animal: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cambiar el estado del animal.']);
        }
    }

}