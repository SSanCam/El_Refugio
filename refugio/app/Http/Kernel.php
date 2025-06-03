<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Los middleware globales de la aplicación.
     * Estos middleware se ejecutan en cada solicitud HTTP.
     * 
     * @var array
     */
    protected $routeMiddleware = [
        'is_admin' => \App\Http\Middleware\IsAdmin::class,
    ];
}
