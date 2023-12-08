<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Factura;
use Illuminate\Support\Facades\Storage;

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

        } catch (ValidationException $e) {
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
                do {
                    $fecha = date('Ymd'); // Fecha actual en formato año-mes-día
                    $numeroAleatorio = rand(1000, 9999); // Número aleatorio entre 1000 y 9999
                    $numeroReferencia = $fecha . $numeroAleatorio;

                    $existe = Factura::where('referencia', $numeroReferencia)->exists();
                } while ($existe);
                Factura::insert([
                    'referencia' => $numeroReferencia,
                    'id_usuario' => $user->id,
                    'fecha' => now(),
                    'importe' => $precio,
                ]);
                $datosFactura = [
                    'referencia' => $numeroReferencia,
                    'id_usuario' => $user->id,
                    'fecha' => now(),
                    'importe' => $precio,
                    'producto' => $producto,
                ];
                return $this->descargarFactura($datosFactura);
                //return redirect('/success');
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
        $user = Auth::user();
        if(!$user->verificado){
            $producto = $request->input('producto');
            session(['producto' => $producto]);
            return view('facturaciones.checkout', ['stripeKey' => env('STRIPE_KEY')]);
        } else {
            return redirect()->route('inicioAlumno', $user->email);
        }

    }

    public function descargarFactura($datosFactura)
    {
        //dd($datosFactura);
        $pdf = PDF::loadView('facturaciones.generadorFactura', $datosFactura);
        $content = $pdf->output();
        try {
           
            $nombreArchivo = 'factura-' . $datosFactura['referencia'] . '.pdf';
            Storage::disk('local')->put('pdf/' . $nombreArchivo, $content);
            return $pdf->download($nombreArchivo);
        } catch (\Throwable $th) {
            dd("error");
        }

    }

    public function mostrarFacturas()
    {
        $archivos = collect(Storage::disk('local')->files('pdf'))
            ->map(function ($archivo) {
                return [
                    'nombre' => basename($archivo),
                    'referencia' => $this->extraerReferencia($archivo)
                ];
            });

        return view('facturaciones.facturas', ['facturas' => $archivos]);
    }

    public function descargaFactura($nombre)
    {
        $path = 'pdf/' . $nombre;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }
    private function extraerReferencia($archivo)
    {
        // Elimina la extensión '.pdf'
        $archivoSinExtension = substr($archivo, 0, -4);

        // Encuentra la posición del guion después de 'factura-'
        $posicionGuion = strpos($archivoSinExtension, '-') + 1;

        // Extrae la referencia desde la posición del guion hasta el final
        return substr($archivoSinExtension, $posicionGuion);
    }

}
