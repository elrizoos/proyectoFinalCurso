<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::paginate(5);
        $grupos = Grupo::paginate(5);
        return view('alumnos.index',['alumnos' => $alumnos, 'grupos' => $grupos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = Grupo::paginate(5);
        return view('alumnos.create',['grupos' => $grupos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $campos = [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|max:100',
            'email' => 'required|email',
            'fechaNacimiento' => 'required|string|max:100',
            'foto' => 'required|max:10000|mimes:jpeg,png,jpg',
            'password' => [
                'required',
                'min:6',
                'regex:/([A-Za-z0-9]+(_[A-Za-z0-9]+)+)/i',
                'confirmed'
            ],
            
        ];

        $mensaje = [
            'required' => 'El :attribute es obligatorio',
            'foto' => 'La foto es requerida'
        ];
        echo "hola";
        $this->validate($request, $campos, $mensaje);
        $datosalumno = request()->except('_token', 'password_confirmation');
        /*
         *Comprobamos si existe un archivo en el formulario
         */

        if ($request->hasFile('foto')) {
            //dd($request->file('foto'));
            $datosalumno['foto'] = 'storage/' . $request->file('foto')->store('uploads', 'public');



        }


        Alumno::insert($datosalumno);

        // return response()->json($datosalumno);
        return redirect('alumnos')->with('mensaje', 'alumno agregado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alumno = Alumno::findOrFail($id);
        $grupos = Grupo::paginate(5);
        return view('alumnos.edit', compact('alumno', 'grupos'));
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
            'foto' => 'required|max:10000|mimes:jpeg,png,jpg',
            'password' => [
                'required',
                'min:6',
                'regex:/([A-Za-z0-9]+(_[A-Za-z0-9]+)+)/i',
                'confirmed'
            ],

        ];

        $mensaje = [
            'required' => 'El :attribute es obligatorio'
        ];

        if ($request->hasFile('foto')) {
            $campos['foto'] = 'required|max:10000|mimes:jpeg,png,jpg';
            $mensaje['foto.required'] = 'La foto es requerida';
        }


        $this->validate($request, $campos, $mensaje);

        $datosalumno = request()->except(['_token', '_method', 'password_confirmation']);
        if ($request->hasFile('foto')) {
            $alumno = alumno::findOrFail($id);
            Storage::delete('public/' . $alumno->foto);
            $datosalumno['foto'] = 'storage/' . $request->file('foto')->store('uploads', 'public');
        }
       
        Alumno::where('id', '=', $id)->update($datosalumno);

        $alumno = Alumno::findOrFail($id);
        $grupos = Grupo::all();
        return view('alumnos.edit', compact('alumno', 'grupos'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alumno = Alumno::findOrFail($id);

        if (Storage::delete('public/' . $alumno->foto)) {
            Alumno::destroy($id);
        }
        return redirect('alumnos')->with('mensaje', 'alumno borrado correctamente');
    }

    /** 
     * Mostrar alumnos correspondientes a una clase
     */

     public function mostrarAlumnos($grupo){

        $alumnosClase = Alumno::where('codigoGrupo', $grupo)->get();
        $alumnosFuera = Alumno::whereNOTIn('codigoGrupo', [$grupo])->get();
        return view('alumnos.grupo',['alumnos'=> $alumnosClase, 'modo' => 'ver', 'grupo' => $grupo, 'alumnosFuera' => $alumnosFuera]);
     }

     public function buscarAlumno(Request $request) {
       $id = $request->input('id');

       $resultados = Alumno::where('id', '=', $id)->get();
       return view('alumnos.search', compact('resultados'));
     }

     public function borrarAlumno(Request $request) {
        $id = $request->input('id');
     }
}