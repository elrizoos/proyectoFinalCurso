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
    public function handle($request, Closure $next, ...$roles)
    {
        $currentRoute = $request->route()->getName();
        //dd($request->user(), $roles);
        $paginasPermitidas = ['alumnos.index', 'inicio'];

        
        // Verificar si el usuario está autenticado
        if ($request->user() /*&& !in_array($currentRoute, $paginasPermitidas)*/) {
            $userRole = $request->user()->role;
            // Verificar si el rol del usuario está en la lista de roles permitidos
            if (!in_array($userRole, $roles)) {
                abort(403, 'No tienes permisos para acceder a esta página. Por favor, ponte en contacto con nosotros en el siguiente formulario');
            }
        }

        return $next($request);
    }

    public function crearFormulario() {

    }
}
