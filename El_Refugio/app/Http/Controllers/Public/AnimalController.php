<?php
namespace App\Http\Controllers\Public;

use App\Enums\AnimalAvailability;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use App\Enums\AnimalStatus;
/**
 * Controlador público para la visualización de animales.
 * Permite listar y ver detalles de los animales disponibles para adopción.
 */

class AnimalController extends Controller{

  
    /**
     * listado público de animales disponibles para adopción
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request){
        
        $currentSpecies = $request->query('species');
        $currentSize = $request->query('size');
        $currentSex = $request->query('sex');
        $currentBreed = $request->query('breed');

        $query = Animal::where('availability', AnimalAvailability::AVAILABLE->value);

        if ($currentSpecies && in_array($currentSpecies, ['dog', 'cat', 'other'], true)) {
            $query->where('species', $currentSpecies);
        }
        
        if ($currentSize && in_array($currentSize, ['small', 'medium', 'large'], true)) {
            $query->where('size', $currentSize);
        }
        
        if ($currentSex && in_array($currentSex, ['male', 'female'], true)) {
            $query->where('sex', $currentSex);
        }

        if ($currentBreed) {
            $query->where('breed', $currentBreed);
        }
             $animals = $query->select([
            'id',
            'species',
            'name', 
            'sex', 
            'size', 
            'birth_date',
            'description',
            'entry_date'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('public.animals.index', compact(
                'animals',
                'currentSpecies',
                'currentSize',
                'currentSex',
                'currentBreed'
            ));
    }

        /**
         * Muestra la información de un animal concreto 
         * 
         * @param mixed $id
         * @return \Illuminate\Contracts\View\View
         */
        public function show(int $id)
    {
        $animal = Animal::select([
                'id',
                'species',
                'breed',
                'name',
                'sex',
                'size',
                'birth_date',
                'availability',
                'description',
                'entry_date'
            ])
            ->where('id', $id)
            ->where('availability', AnimalAvailability::AVAILABLE->value)
            ->firstOrFail();
        
    return view('public.animals.show', compact('animal'));
    }

    public function happyEndings()
    {
        $animals = Animal::where('status', AnimalStatus::ADOPTED->value)
            ->orderBy('updated_at', 'desc')
            ->select([
                'id',
                'name'
            ])
            ->paginate(15);

        return view('public.animals.happy', compact('animals'));
    }
}