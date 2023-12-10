<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Alumno;
use App\Models\Empleado;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/'; //Creando una variable de redireccion por defecto
    protected $name = ""; //Inicializando la variable para el nombre de la ruta "route()"

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Método de autenticación de usuario el cual, dependiendo del rol, será redireccionado a una página u otra.
     *
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {

        if ($user->role === 'admin') {
            return redirect()->route('inicio');
        } elseif ($user->role === 'alumno') {
            return redirect()->route('inicioAlumno', ['alumno' => $user->email]);
        } elseif ($user->role === 'empleado') {
            return redirect()->route('inicioEmpleado', ['empleado' => $user->email]);
        }

    }
    /**
     * Metodo para salir de la app y cerrar sesion
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logout(Request $request)
    {
        $user = Auth::user();
        $this->guard()->logout(); //Salir de la aplicacion

        $request->session()->invalidate(); //Cerrar sesion

        $user->last_login_at = Carbon::now(); //Actualizar ultimo inicio de sesion
        $user->save(); //Guardar en la base de datos
        return redirect('/login');
    }

    /**
     * Metodo que sirve para obtener los datos necesarios para mostrar al admin las notificaciones de cambios en la bd (Alumnos y Empleados)
     * 
     * @return array
     */
    public function mostrarCambios()
    {
        $user = Auth::user();
        $lastLoginAt = Carbon::parse($user->last_login_at);
        $cambiosAlumnos = Alumno::where('updated_at', '>', $lastLoginAt)->get();
        $cambiosEmpleados = Empleado::where('updated_at', '>', $lastLoginAt)->get();

        $cambios = [
            $cambiosAlumnos,
            $cambiosEmpleados
        ];

        return $cambios;


    }
}
