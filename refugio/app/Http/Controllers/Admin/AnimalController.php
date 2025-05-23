<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar los animales del refugio.
 */
class AnimalController extends Controller
{
 // CRUD básico para la gestión de animales
    /**
     * Muestra un listado paginado de animales, con filtro por nombre, especie,
     * raza, sexo y estado de adopción.
     * 
     * @param Request $request Solicitud HTTP con los parámetros de búsqueda.
     * @return \Illuminate\View\View Vista del listado de animales.
     */
    public function index(Request $request)
    {
      //
    }

    /**
     * Muestra el formulario para crear un nuevo animal.
     * 
     * @return \Illuminate\View\View Vista del formulario de creación de animal.
     */
    public function create()
    {
        //
    }

    /**
     * Almacena un nuevo animal en la base de datos.
     * 
     * @param Request $request Solicitud HTTP con los datos del nuevo animal.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de animales.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra los detalles de un animal específico.
     * 
     * @param int $id ID del animal a mostrar.
     * @return \Illuminate\View\View Vista de los detalles del animal.
     */
    public function show($id)
    {
        //
    }

    /**
     * Muestra el formulario para editar un animal existente.
     * 
     * @param int $id ID del animal a editar.
     * @return \Illuminate\View\View Vista del formulario de edición de animal.
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Elimina un animal de la base de datos.
     * 
     * @param int $id ID del animal a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de animales.
     */
    public function destroy($id)
    {
        //
    }
    
}