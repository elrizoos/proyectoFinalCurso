<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Empleado;
use App\Models\Clase;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,alumno,empleado'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

    }

    protected function registered(Request $request, $user)
    {

        $clases = Clase::all();
        $existeUsuario = $this->comprobarExistencia($user);
        if($existeUsuario){
            if ($user->role === 'admin') {
                $redirectPath = '/admin';
            } elseif ($user->role === 'alumno') {
                $redirectPath = '/alumno';
            } elseif ($user->role === 'empleado') {
                $redirectPath = '/empleado';
            } else {
                $redirectPath = $this->redirectTo;
            }
        } else {
            if ($user->role === 'admin') {
                $redirectPath = '/admin';
            } elseif ($user->role === 'alumno') {
                $redirectPath = '/alumno/create';
            } elseif ($user->role === 'empleado') {
                $redirectPath = '/empleado/create';
            } else {
                $redirectPath = $this->redirectTo;
            }

        }

        // Redirigir según el rol del usuario después de registrarse
        

        // Almacenar el mensaje informativo en la sesión
        $request->session()->flash('registro_exitoso', 'Registro exitoso. Bienvenido.');

        // Redireccionar a la ruta correspondiente
        return redirect($redirectPath)->with('clases', $clases);
    }

    public function comprobarExistencia($data)
    {
        $email = $data['email'];
        $role = $data['role'];

        if ($role === 'admin' || $role === 'empleado') {
            $usuario = Empleado::where('email', $email)->first();
        } elseif ($role === 'alumno') {
            $usuario = Alumno::where('email', $email)->first();
        }

        if ($usuario) {
            return $usuario;
        } else {
            return null;
        }
    }
}
