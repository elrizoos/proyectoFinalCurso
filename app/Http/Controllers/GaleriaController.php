<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    public function index()
    {
        $imagenes = Imagen::all();
        return view('galeria.index', compact('imagenes'));
    }

    public function show($id)
    {
    }

    public function create()
    {
        return view('galeria.create');
    }

    public function store(Request $request)
    {
        //dd('hola');
        $campos = [
            'nombre' => 'required|string',
            'ruta' => 'required|image|mimes:jpeg,png,jpg'
        ];

        $mensaje = [
            'required' => 'El :attribute es obligatorio',
            'image' => 'La :attribute debe ser una imagen (jpeg, png, jpg)'
        ];

        $this->validate($request, $campos, $mensaje);

        // Manejar la subida de la imagen
        if ($request->hasFile('ruta')) {
            $imagen = $request->file('ruta');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('uploads'), $nombreImagen);
        } else {
            // Manejar el caso en que no se proporciona una imagen
            return redirect()->back()->with('error', 'No se proporcionó ninguna imagen');
        }

        // Insertar datos en la base de datos
        Imagen::create([
            'nombre' => $request->nombre,
            'ruta' => 'uploads/' . $nombreImagen,
        ]);

        return redirect()->back()->with('success', 'Imagen almacenada correctamente');
    }

    
}
