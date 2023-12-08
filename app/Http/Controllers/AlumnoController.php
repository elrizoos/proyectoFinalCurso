<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function inicio(Request $request)
    {
        return view('alumnos.perfil');
    }

    public function registroAlumno(Request $request)
    {
        $user = $request->input('user');
        return view('Alumno.register', compact('user'));
    }

    public function registrarAlumno(Request $request)
    {
        if (!$request->session()->has('user')) {
            return redirect()->route('rutaAdecuada')->with('error', 'No estás autenticado.');
        }

        $user = $request->session()->get('user');

        // Calcula la fecha de hace 16 años
        $fechaHace16Años = now()->subYears(16)->format('Y-m-d');

        // Validación de la solicitud
        $validatedData = $request->validate([
            'apellidos' => 'required',
            'dni' => 'required|unique:alumnos,dni|regex:/^[0-9]{8}[A-Z]$/',
            'telefono' => 'required|regex:/^[679][0-9]{8}$/',
            'fechaNacimiento' => 'required|date|before_or_equal:' . $fechaHace16Años,
            'direccion' => 'required',
            'foto' => 'required|image',
            'password' => ['required', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
        ], [
             'telefono.regex' => 'El número de teléfono debe comenzar con 6, 7, o 9 y tener un total de 9 dígitos.',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, un número y un signo especial.',
            'dni.regex' => 'El DNI debe tener 8 dígitos seguidos de una letra mayúscula.',
            'fechaNacimiento.before_or_equal' => 'Debes tener al menos 16 años de edad.'
        ]);
        // Manejo de la foto
        $fotoPath = $request->file('foto')->store('uploads', 'public');

        // Creación del alumno
        $alumno = new Alumno([
            'nombre' => $user->name,
            'apellidos' => $validatedData['apellidos'],
            'dni' => $validatedData['dni'],
            'telefono' => $validatedData['telefono'],
            'email' => $user->email,
            'fechaNacimiento' => $validatedData['fechaNacimiento'],
            'direccion' => $validatedData['direccion'],
            'foto' => 'storage/' . $fotoPath,
            'codigoGrupo' => 0,
            'password' => $user->password,
        ]);

        $alumno->save();

        return redirect()->route('inicioAlumno', ['alumno' => $user->email])->with('success', 'Alumno registrado con éxito.');
    }


    public function mostrarPerfil($alumno)
    {
        $alumno = Alumno::where('email', '=', $alumno)->first();
        //dd($alumno);
        $asistencias = $alumno->obtenerAsistencias();
        //dd($asistencias);
        //dd($alumno->codigoGrupo);
        if ($alumno->codigoGrupo === 0) {
            $horarioMañana = 0;
            $horarioTarde = 0;
        } else {
            $horarioMañana = Horario::where('codigoGrupo', '=', $alumno->codigoGrupo)
                ->where('horaInicio', '<', '14:00:00')
                ->orderBy('primerDia', 'asc')
                ->orderBy('horaInicio', 'asc')
                ->first();

            if (!$horarioMañana) {
                $horarioMañana = 0;
            }
            $horarioTarde = Horario::where('codigoGrupo', '=', $alumno->codigoGrupo)
                ->where('horaInicio', '>', '14:00:00')
                ->orderBy('primerDia', 'asc')
                ->orderBy('horaInicio', 'asc')
                ->first();

            if (!$horarioTarde) {
                $horarioTarde = 0;
            }
        }

        $reservas = Reserva::where('id_alumno', '=', $alumno->id)->get();
        $horariosReservados = [];
        foreach ($reservas as $reserva) {
            $horario = Horario::where('id', '=', $reserva->id_horario)->first();
            $horariosReservados[] = $horario;

        }
        //dd($horariosReservados);
        return view('Alumno.perfil', compact('alumno', 'asistencias', 'horarioMañana', 'horarioTarde', 'horariosReservados'));
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
        

        $user = $request->session()->get('user');

        // Calcula la fecha de hace 16 años
        $fechaHace16Años = now()->subYears(16)->format('Y-m-d');
        //dd($request->all());
        $campos = [
            'apellidos' => 'required',
            'dni' => 'required|unique:alumnos,dni|regex:/^[0-9]{8}[A-Z]$/',
            'telefono' => 'required|regex:/^[679][0-9]{8}$/',
            'fechaNacimiento' => 'required|date|before_or_equal:' . $fechaHace16Años,
            'direccion' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'foto' => 'required|image',
            'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/'],
            

        ];

        $mensaje = [
            'email' => 'El formato del correo electrónico no es válido.',
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

    public function reservarClase($horario, $alumno)
    {
        try {
            Reserva::insert([
                'id_alumno' => $alumno,
                'id_horario' => $horario,
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'No se puede volver a reservar la clase');
        }

        $alumno = Alumno::findOrFail($alumno);
        $horario = Horario::findOrFail($horario);
        return redirect()->route('inicioAlumno', $alumno->email)->with('reserva', 'Reservada la clase');
    }

}