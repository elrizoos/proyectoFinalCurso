<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function inicio(Request $request){
        return view('alumnos.perfil');
    }

    public function registroAlumno(Request $request) {
        
        $user = $request->input('user');
        return view('Alumno.register', compact('user'));
    }

    public function registrarAlumno(Request $request) {
        if($request->session()->has('user')){
            $user = $request->session()->get('user');
        }
        $emailUser = $user->email;
        //dd($idUser);
        $user = User::where('email', '=', $emailUser)->first();
        //dd($user);
       
        $nombre = $user->name;
        $password = $user->password;
    
        $data = [
            'nombre' => $nombre,
            'apellidos' => $request->input('apellidos'),
            'dni' => $request->input('dni'),
            'telefono' => $request->input('telefono'),
            'email' => $emailUser,
            'fechaNacimiento' => $request->input('fechaNacimiento'),
            'direccion' => $request->input('direccion'),
            'foto' => 'storage/' . $request->file('foto')->store('uploads', 'public'),
            'codigoGrupo' => 0,
            'password' => $password,

        ];
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads', 'public');
            $data['foto'] = 'storage/' . $fotoPath;
        }
        //dd($data);
        Alumno::insert($data);
        return redirect()->route('inicioAlumno', ['alumno' => $emailUser]);
    }

    public function mostrarPerfil($alumno){
        $alumno = Alumno::where('email', '=', $alumno)->first();
        $asistencias = $alumno->obtenerAsistencias();
        //dd($alumno->codigoGrupo);
        if($alumno->codigoGrupo === 0){
            $horariosMañana = 0;
        } else {
            $horariosMañana = Horario::where('codigoGrupo', '=', $alumno->codigoGrupo)->get();
        }
        //dd($horariosMañana);
        return view('Alumno.perfil', compact('alumno', 'asistencias', 'horariosMañana'));
    }

    
    public function index(Request $request)
    {
        $column = $request->input('columna', 'id'); // Columna de ordenamiento predeterminada
        $direction = $request->input('direccion', 'asc'); // Dirección de ordenamiento predeterminada
        $perPage = $request->input('perPage', 5); // Elementos por página
        //$alumnos = Alumno::orderBy('nombre')->paginate(5);
        $alumnos = Alumno::orderBy($column, $direction)->paginate($perPage);
        $grupos = Grupo::paginate(5);
        //return view('alumnos.index', ['alumnos' => $alumnos, 'grupos' => $grupos, 'ordenActual' => 'asc', 'columnaActual' => 'nombre']);
        return view('alumnos.index', ['alumnos' => $alumnos, 'grupos' => $grupos, 'columna' => $column, 'direccion' => $direction]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = Grupo::paginate(5);
        return view('alumnos.create', ['grupos' => $grupos]);
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

    public function mostrarAlumnos($grupo)
    {

        $alumnosClase = Alumno::where('codigoGrupo', $grupo)->get();
        $alumnosFuera = Alumno::whereNOTIn('codigoGrupo', [$grupo])->get();
        return view('alumnos.grupo', ['alumnos' => $alumnosClase, 'modo' => 'ver', 'grupo' => $grupo, 'alumnosFuera' => $alumnosFuera]);
    }

    public function buscarAlumno(Request $request)
    {
        //dd($request->query('id'));
        $id = $request->input('id');
        $nombre = $request->input('nombre');

        //dd($id != "");
        if ($id != "" && $nombre != "") {
            $resultados = Alumno::where('id', '=', $id)
                ->where('nombre', '=', $nombre)
                ->get();
            dd("uno");
        } else if ($id != "") {
            $resultados = Alumno::where('id', '=', $id)
                ->get();
            //dd("dos");
        } else {
            $resultados = Alumno::where('nombre', '=', $nombre)
                ->get();
            //dd("tres");
        }
        //dd($resultados);
        return view('alumnos.search', compact('resultados'));
    }

    public function borrarAlumno(Request $request)
    {
        $id = $request->input('id');
    }

    public function obtenerAlumnos(Request $request)
    {
        $columna = $request->input('columna', 'nombre');
    
        $orden = $request->input('orden', 'asc'); // Valor predeterminado a 'asc' si no se proporciona

        //dd($columna, $orden);

        $alumnos = Alumno::orderBy($columna, $orden)->paginate(5);
        $alumnosData = $alumnos->items();

        $pagination = [
            'total' => $alumnos->total(),
            'per_page' => $alumnos->perPage(),
            'current_page' => $alumnos->currentPage(),
            'last_page' => $alumnos->lastPage()
        ];
    
        $responseData = [
            'alumnos' => $alumnosData,
            'pagination' => $pagination,
            'columnaActual' => $columna,
            'orden' => $orden
        ];
        return response()->json($responseData);
    }

}