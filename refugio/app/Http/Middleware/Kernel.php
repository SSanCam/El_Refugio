<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

use App\Http\Middleware\IsAdmin;
    /**
     * Los middleware globales de la aplicación.
     * Estos middleware se ejecutan en cada solicitud HTTP.
     * 
     * @var array
     */
  class Kernel extends HttpKernel
{
    protected $routeMiddleware = [

        'admin'    => IsAdmin::class,
    ];
}