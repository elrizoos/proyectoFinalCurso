<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Suscripcion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $routeName = null)
    {

        if (Auth::check()) {


            $currentRoute = $request->route()->getName();
            if ($currentRoute !== 'registro') {
                //dd($currentRoute);
            }

            $excludedRoutes = ['facturacionAlumno', 'masTarde', 'checkout', 'registroAlumno', 'registro', 'store', 'verificarPago', 'error', 'success'];
            //dd($currentRoute, !in_array($currentRoute, $excludedRoutes));


            //Obtengo el user
            $user = Auth::user();
            $segundosDesdeCreacion = $user->created_at->diffInSeconds(now());
            $tiempoTranscurrido = $this->mostrarTiempo($segundosDesdeCreacion);

            //dd(Auth::user()->verificado);
            if (!in_array($currentRoute, $excludedRoutes) && !Auth::user()->verificado && !$request->session()->has('masTarde')) {
                return redirect()->route('facturacionAlumno', ['tiempoTranscurrido' => $tiempoTranscurrido, 'segundosDesdeCreacion' => $segundosDesdeCreacion]);
            }
        }

        return $next($request);
    }

    public function mostrarTiempo($segundos)
    {
        $horas = floor($segundos / 3600);
        $minutos = floor(($segundos % 3600) / 60);
        $segundosRestantes = $segundos % 60;

        return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundosRestantes);

    }
}
