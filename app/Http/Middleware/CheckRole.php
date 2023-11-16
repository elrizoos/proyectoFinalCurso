<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user() && $request->user()->role != $role) {
            echo $role, $request->user()->role;
            abort(403,'No tienes permisos para acceder a esta página, Por favor ponte en contacto con nosotros en el siguiente formulario');
            crearFormulario();
        }
        return $next($request);
    }

    public function crearFormulario() {

    }
}
