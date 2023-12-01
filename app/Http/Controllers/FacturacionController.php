<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function mostrarFacturacion($tiempoTranscurrido, $segundosDesdeCreacion){
        return view("facturaciones.index", compact('tiempoTranscurrido', 'segundosDesdeCreacion'));
    }
    
    public function masTarde(Request $request) {
        $request->session()->put('masTarde', true);
        //dd($request->session());
        return redirect()->route('inicioAlumno');
    }

}
