<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function inicio(Request $request)
    {
        $empleados = Empleado::all();
        return view("Empleado.index", compact('empleados'));
    }
    public function index()
    {
        $datos['empleados']=Empleado::paginate(5);
        
        return view('empleados.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clases = Clase::all();
        return view('empleados.create', compact('clases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $campos = [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|max:100',
            'telefono' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'fechaNacimiento' => 'required|string|max:100',
            'direccion' => 'required|string|max:100',
            'foto' => 'required|max:10000|mimes:jpeg,png,jpg',
            'password' => [
                'required',
                'min:6',
                'regex:/([A-Za-z0-9]+(_[A-Za-z0-9]+)+)/i',
                'confirmed'
            ],
        ];
        
        $mensaje=[
            'required'=>'El :attribute es obligatorio',
            'foto' => 'La foto es requerida'
        ];
        echo "hola";
        $this->validate($request,$campos, $mensaje);
        $datosEmpleado = request()->except('_token','password_confirmation');
    /*
    *Comprobamos si existe un archivo en el formulario
    */

    if ($request->hasFile('foto')){
        $datosEmpleado['foto']=$request->file('foto')->store('uploads','public');
    }


        Empleado::insert($datosEmpleado);

       // return response()->json($datosEmpleado);
       return redirect('empleados')->with('mensaje', 'Empleado agregado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        $clases = Clase::all();
        return view('empleados.edit', compact('empleado', 'clases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $campos = [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|max:100',
            'email' => 'required|email',
            'fechaNacimiento' => 'required|string|max:100',
            'password' => [
                'required',
                'min:6',
                'regex:/([A-Za-z0-9]+(_[A-Za-z0-9]+)+)/i',
                'confirmed'
            ],
        ];

        $mensaje = [
            'required' => 'El :attribute es obligatorio',
        ];

        if ($request->hasFile('foto')) {
            $campos['foto'] = 'required|max:10000|mimes:jpeg,png,jpg';
            $mensaje['foto.required'] = 'La foto es requerida';
        }

        $this->validate($request, $campos, $mensaje);

        $datosEmpleado = request()->except(['_token','_method','password_confirmation']);
        if ($request->hasFile('foto')) {
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->foto);
            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        
        Empleado::where('id','=',$id)->update($datosEmpleado);

        $empleado=Empleado::findOrFail($id);
        $clases = Clase::all();
        return view('empleados.edit', compact('empleado', 'clases'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empleado=Empleado::findOrFail($id);

        if(Storage::delete('public/'.$empleado->foto)){
        Empleado::destroy($id);
        }
        return redirect('empleados')->with('mensaje', 'Empleado borrado correctamente');
    }

    public function buscarEmpleado(Request $request)
    {
        //dd($request->query('id'));
        $id = $request->input('id');
        $nombre = $request->input('nombre');

        //dd($id != "");
        if ($id != "" && $nombre != "") {
            $resultados = Empleado::where('id', '=', $id)
                ->where('nombre', '=', $nombre)
                ->get();
            dd("uno");
        } else if ($id != "") {
            $resultados = Empleado::where('id', '=', $id)
                ->get();
            //dd("dos");
        } else {
            $resultados = Empleado::where('nombre', '=', $nombre)
                ->get();
            //dd("tres");
        }
        //dd($resultados);
        return view('empleados.search', compact('resultados'));
    }
}