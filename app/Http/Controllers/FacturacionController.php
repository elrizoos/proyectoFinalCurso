<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function mostrarFacturacion($tiempoTranscurrido, $segundosDesdeCreacion){
        $productos = [
            ['id' => 1, 'nombre' => 'Producto 1', 'descripcion' => 'Descripción del producto 1', 'precio' => 'xx por mes'],
            ['id' => 2, 'nombre' => 'Producto 2', 'descripcion' => 'Descripción del producto 2', 'precio' => 'xx por mes'],
            ['id' => 3, 'nombre' => 'Producto 3', 'descripcion' => 'Descripción del producto 3', 'precio' => 'xx por mes'],
        ];

        return view("facturaciones.index", compact('tiempoTranscurrido', 'segundosDesdeCreacion', 'productos'));
    }
    
    public function masTarde(Request $request) {
        $request->session()->put('masTarde', true);
        //dd($request->session());
        return redirect()->route('inicioAlumno');
    }


    public function mostrarCheckout(Request $request) {
        $producto = $request->input('producto');
        
   
    }
}
