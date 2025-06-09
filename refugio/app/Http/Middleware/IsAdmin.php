<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class IsAdmin
{
    /**
     * Maneja una solicitud entrante y verifica si el usuario es administrador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next): mixed
    {
        if (Auth::check() && Auth::user()->role === UserRole::ADMIN->value) {
            return $next($request);
        }

        abort(403, 'Acceso denegado.');
    }
}
