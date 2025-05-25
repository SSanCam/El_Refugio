<?php   
 namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\Foster;
    use App\Models\Animal;
    use App\Models\User;

    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Database\QueryException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Exception;

/**
 * FosterController
 * Controlador para la gestión de acogidas de animales.
 */
class FosterController extends Controller
{
    /**
     * ==========================================================
     * Funcionalidades básicas para la gestión de acogidas 
     * ==========================================================
     */
        
    /**
     * Muestra un listado de acogidas.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $fosters = Foster::paginate(10);

            if ($fosters->isEmpty()) {
                session()->flash('info', 'No hay acogidas registradas aún.');
            }

            return view('admin.foster.index', compact('fosters'));

        } catch (Exception $e) {
            Log::error('Error al cargar el listado de acogidas: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el listado de acogidas.']);
        }
    }
    /**
     * Muestra el formulario para crear una nueva acogida.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse 
     */
    public function create()
    {
        try {
            $animals = Animal::where('status', 'available')->get();
            $users = User::where('role', 'foster')->get();

            return view('admin.foster.create', compact('animals', 'users'));

        } catch (Exception $e) {
            Log::error('Error al cargar el formulario de acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el formulario de acogida.']);
        }
    }

    /**
     * Almacena una nueva acogida en la base de datos.
     *
     * @param \Illuminate\Http\Request $request Parametros de la solicitud
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
        {
            try {
                $validated = $request->validate([
                    'animal_id' => 'required|exists:animals,id',
                    'user_id' => 'required|exists:users,id',
                    'status' => 'required|in:pending,fostering,finished',
                    'start_date' => 'required|date',
                    'end_date' => 'nullable|date|after_or_equal:start_date',
                ]);

                Animal::find($validated['animal_id'])->update(['status' => 'fostered']);
                Foster::create($validated);

                session()->flash('success', 'Acogida registrada correctamente.');
                return redirect()->route('admin.foster.index');

            } catch (QueryException $e) {
                Log::error('Error al registrar la acogida: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Error al registrar la acogida.']);
            } catch (Exception $e) {
                Log::error('Error inesperado al registrar la acogida: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'Error inesperado al registrar la acogida.']);
            }
        }


    /**
     * Muestra los detalles de una acogida específica.
     *
     * @param int $id ID de la acogida
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $foster = Foster::with(['animal', 'user'])->findOrFail($id);

            return view('admin.foster.show', compact('foster'));

        } catch (ModelNotFoundException $e) {
            Log::error('Acogida no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Acogida no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al mostrar la acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al mostrar la acogida.']);
        }
    }

    /**
     * Muestra el formulario para editar una acogida específica.
     *
     * @param int $id ID de la acogida
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            $foster = Foster::with(['animal', 'user'])->findOrFail($id);
            $animals = Animal::where('status', 'available')->get();
            $users = User::where('role', 'foster')->get();

            return view('admin.foster.edit', compact('foster', 'animals', 'users'));

        } catch (ModelNotFoundException $e) {
            Log::error('Acogida no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Acogida no encontrada.']);
        } catch (Exception $e) {
            Log::error('Error al cargar el formulario de edición de acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al cargar el formulario de edición de acogida.']);
        }
    }

    /**
     * Actualiza una acogida existente en la base de datos.
     *
     * @param \Illuminate\Http\Request $request Parametros de la solicitud
     * @param int $id ID de la acogida
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'animal_id' => 'required|exists:animals,id',
                'user_id' => 'required|exists:users,id',
                'status' => 'required|in:pending,fostering,finished',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $foster = Foster::findOrFail($id);
            $foster->update($request->all());

            session()->flash('success', 'Acogida actualizada correctamente.');
            return redirect()->route('admin.foster.index');

        } catch (ModelNotFoundException $e) {
            Log::error('Acogida no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Acogida no encontrada.']);
        } catch (QueryException $e) {
            Log::error('Error al actualizar la acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al actualizar la acogida.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al actualizar la acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al actualizar la acogida.']);
        }
    }

    /**
     * Elimina una acogida existente de la base de datos.
     *
     * @param int $id ID de la acogida
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $foster = Foster::findOrFail($id);
            $foster->delete();

            session()->flash('success', 'Acogida eliminada correctamente.');
            return redirect()->route('admin.foster.index');

        } catch (ModelNotFoundException $e) {
            Log::error('Acogida no encontrada: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Acogida no encontrada.']);
        } catch (QueryException $e) {
            Log::error('Error al eliminar la acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la acogida.']);
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar la acogida: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error inesperado al eliminar la acogida.']);
        }
    }
}