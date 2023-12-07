<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FacturacionController extends Controller
{
    public function mostrarFacturacion($tiempoTranscurrido, $segundosDesdeCreacion)
    {
        $productos = [
            ['id' => 1, 'nombre' => 'Pilates Básico', 'descripcion' => 'La opción básica para principiantes', 'precioMensual' => 19.99, 'precioAnual' => '239,89'],
            ['id' => 2, 'nombre' => 'Pilates Medio', 'descripcion' => 'Si ya tienes experiencia en esta materia', 'precioMensual' => 24.99, 'precioAnual' => '299,89'],
            ['id' => 3, 'nombre' => 'Pilates Plus', 'descripcion' => 'Para obtener una experiencia mas profunda', 'precioMensual' => 29.99, 'precioAnual' => '359,89'],
        ];

        return view("facturaciones.index", compact('tiempoTranscurrido', 'segundosDesdeCreacion', 'productos'));
    }

    public function masTarde(Request $request)
    {
        $request->session()->put('masTarde', true);
        $user = Auth::user();
        return redirect()->route('inicioAlumno', ['alumno' => $user->email]);
    }

    public function verificarDatos(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        //dd($request->all());
        try {
            $producto = $request->input('producto');
            //dd($producto);
            $validacionDatos = $request->validate([
                'nombre' => 'required|max:255',
                'precio' => 'required|numeric',
                'stripeToken' => 'required'
            ]);

        } catch (ValidationException $e){
            return view('facturaciones.checkout')
                ->withErrors($e->validator)
                ->with([
                    'producto' => $producto,
                    'stripeKey' => env('STRIPE_KEY'),
            ]);
        }
        $precio = $request->input('precio') * 100;
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $precio, // El monto aquí es un ejemplo, convierte tu precio a centavos
                'currency' => 'eur', // Cambia a tu moneda según sea necesario
                'description' => 'Pago por ' . $request->input('nombre'),
                'source' => $request->input('stripeToken'), // El token de Stripe
            ]);
            //dd($charge->status);
            if ($charge->status == 'succeeded') {
                // Redirigir a la página de éxito
                $user = Auth::user();
                $user->verificado = 1;
                $user->save();
                return redirect('/success');
            } else {
                // Redirigir a la página de error
                return redirect('/error');
            }
            // Aquí puedes realizar acciones adicionales en caso de éxito, como actualizar la base de datos

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Maneja el error aquí (p. ej., mostrar un mensaje al usuario)
            dd($e->getMessage());
        }
    }

    public function mostrarCheckout(Request $request)
    {
        $producto = $request->input('producto');
        session(['producto' => $producto]);
        return view('facturaciones.checkout', ['stripeKey' => env('STRIPE_KEY')]);

    }
}
