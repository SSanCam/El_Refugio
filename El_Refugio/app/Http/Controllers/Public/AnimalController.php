<?php
namespace App\Http\Controllers\Public;

use App\Enums\AnimalAvailability;
use App\Http\Controllers\Controller;
use App\Models\Animal;

/**
 * Controlador público para la visualización de animales.
 * Permite listar y ver detalles de los animales disponibles para adopción.
 */
class AnimalController extends Controller{

  
    /**
     * listado público de animales disponibles para adopción
     * @return \Illuminate\Contracts\View\View
     */
    public function index(){
        
        $animals = Animal::select([
            'id',
            'species',
            'name', 
            'sex', 
            'size', 
            'birth_date'
            ])
            ->where('availability', AnimalAvailability::AVAILABLE->value)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

    return view('public.animals.peludos', compact('animals'));
    }

        /**
         * Muestra la información de un animal concreto 
         * @param mixed $id
         * @return \Illuminate\Contracts\View\View
         */
        public function show($id)
    {
        $animal = Animal::select([
                'id',
                'species',
                'name',
                'sex',
                'size',
                'birth_date'
            ])
            ->where('id', $id)
            ->where('availability', AnimalAvailability::AVAILABLE->value)
            ->firstOrFail();
        
    return view('public.animals.peludo', compact('animal'));
    }

}