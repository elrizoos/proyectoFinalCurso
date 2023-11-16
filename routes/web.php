<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\GrupoController;

use App\Http\Controllers\ClaseController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PayPalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    // Rutas para el usuario admin
    Route::get('/home', function () {
        return view('index');
    })->name('home');
    
    //Asignando ruta para la busqueda de alumno
    Route::get("/alumnos/search", function () {
        return view('alumnos.search');
    })->name('alumnos.search');

    Route::get('/alumnos/searchAlumno', [AlumnoController::class, 'buscarAlumno']);

    Route::get('/alumnos/{grupo}/mostrar-alumnos', [AlumnoController::class, 'mostrarAlumnos'])->name('alumnos.mostrar-alumnos');

    //Ruta para obtener los alumnos de forma obtenada en la lista de alumnos
    Route::get('alumnos/obtener-alumnos', [AlumnoController::class, 'obtenerAlumnos']);

    Route::resource('alumnos', AlumnoController::class);



    //Cuando escribamos en la url empleados nos redirige a la vista index de empleados
    Route::get("/empleados", function () {
        return view('empleados.index');
    });

    Route::get("/empleados/search", function () {
        return view('empleados.search');
    })->name('empleados.search');

    Route::get('/empleados/searchEmpleado', [EmpleadoController::class, 'buscarEmpleado']);
    
    //Obtenemos automaticamente las rutas asociadas a empleados
    Route::resource('empleados', EmpleadoController::class);




   // Route::get('facturaciones/pagar', [PayPalController::class, 'mostrarFormulario']);

    //Route::get('facturaciones/procesar-pago', [PayPalController::class, 'procesarPago']);


    Route::get('/galeria', [GaleriaController::class,'index']);

    Route::resource('galeria', GaleriaController::class);

    Route::get('/grupos-clases/grupos/{grupo}/mostrar-alumnos', [GrupoController::class, 'mostrarAlumnos'])->name('grupos.mostrar-alumnos');

    Route::get("/grupos-clases/grupos/{grupo}/asignar-alumnos", [GrupoController::class, 'asignarAlumnos'])->name('grupos.asignar-alumnos');
    //Ruta para acceder a la ediccion de grupos o clases
    Route::get('grupos-clases/editar', function () {
        return view('grupos-clases.editar');
    });

    Route::get('grupos-clases/grupos/editar', [GrupoController::class, 'cargarGrupos']);

    Route::get('grupos-clases/clases/editar', [ClaseController::class, 'cargarClases']);

    Route::resource('grupos-clases/clases', ClaseController::class);

    Route::resource('grupos-clases/grupos', GrupoController::class);

    Route::resource('grupos-clases', GrupoController::class);




    //Ruta para acceder al formulario de edicion del registro
    Route::get("horarios/edit/{dia}/{tramo}/{fecha}/{id}", [HorarioController::class, 'edit']);

    //Ruta para acceder al formulario de Horario(create) mediante el botón disponible en la casilla vacia del horario
    Route::get("horarios/create/{dia}/{tramo}/{fecha}", [HorarioController::class, 'createPredefinido']);

    Route::resource('horarios', HorarioController::class);




    Route::get('/admin', function() {
        return view('index');
    });


});

Route::middleware(['auth', 'checkRole:alumno'])->group(function () {
    // Rutas para el usuario alumno
    Route::get('/alumno', [AlumnoController::class,'inicio'])->name('inicioAlumno');
});

Route::middleware(['auth', 'checkRole:empleado'])->group(function () {
    // Rutas para el usuario empleado
    

    Route::get('/empleado', [EmpleadoController::class,'inicio'])->name('inicioEmpleado');
});






//Para que si ponemos la ruta principal haya que iniciar sesion en la pagina
//Route::get('/', function () {
  //  return view('auth.login');
//});





//Hacemos que desaparezca el boton de registro de usuario y de restablecer la contraseña
Auth::routes(['register' => true, 'reset' => false]);


//Hacemos que se redirija al index global cuando se inicie sesion
Route::group(['middleware' => 'auth'], function () {
    
});
Route::group(['middleware' => 'auth'], function () {
    
});

//Para acceder a la funcion asociada a buscar el alumno
/** Route::get('/alumnos/searchAlumno', [AlumnoController::class, 'buscarAlumno']);


//Para asociar todas las rutas de alumnos
Route::resource('alumnos', AlumnoController::class)->middleware('auth');


//Para asociar todas las rutas de grupos

Route::get('/grupos-clases/grupos/{grupo}/mostrar-alumnos', [GrupoController::class, 'mostrarAlumnos'])->name('grupos.mostrar-alumnos')->middleware('auth');
Route::get('/alumnos/{grupo}/mostrar-alumnos', [AlumnoController::class, 'mostrarAlumnos'])->name('alumnos.mostrar-alumnos')->middleware('auth');
Route::get("/grupos-clases/grupos/{grupo}/asignar-alumnos", [GrupoController::class, 'asignarAlumnos'])->name('grupos.asignar-alumnos')->middleware('auth');
Route::get("/grupos-clases/grupos/{grupo}/edit", [GrupoController::class, 'edit'])->name('grupos.edit')->middleware('auth');



Route::resource('grupos-clases/clases', AlumnoController::class);

//Redireccionar a la vista de horarios
Route::get('/horarios', function() {
    return view('horarios');
});*/
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
