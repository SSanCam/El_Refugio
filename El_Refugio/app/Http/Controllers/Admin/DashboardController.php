<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Controlador del panel de administración
 * Proporciona una visión general y acceso rápido a las funciones administrativas.
 */
class DashboardController extends Controller
{

    public function index()
    {
        return view('admin.dashboard');
    }

}