<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Empleado;
use App\Models\Clase;
use App\Models\InvitationCode;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\MatchInvitationRole;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
     * Comprueba si se ha introducido el codigo valido o no
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): ValidatorContract
    {
        $opcionCodigo = "";
        $code = $data['code'];
        $invitation = InvitationCode::where('code', $code)
            ->where('used', 0)
            ->first();
        if (isset($data['codigoUse'])) {
            $opcionCodigo = $data['codigoUse'];
            if (!$invitation) {
                throw ValidationException::withMessages([
                    'code' => ['El código de invitación no es válido.'],
                ]);
            }
            $rules = [
                'code' => ['required', 'string', 'exists:invitation_codes,code,used,0'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', new MatchInvitationRole($invitation->role)]
            ];
            $messages = [
                'required' => 'El campo :attribute es obligatorio.',
                'string' => 'El campo :attribute debe ser una cadena de texto.',
                'exists' => 'El código no es válido.',
                'max' => 'El campo :attribute no puede tener más de :max caracteres.',
                'email' => 'El formato del correo electrónico no es válido.',
                'unique' => 'El correo electrónico ya está registrado.',
                'confirmed' => 'La confirmación de la contraseña no coincide.',
            ];

            $validator = Validator::make($data, $rules, $messages);

            return $validator;
        } else {
            //dd($invitation);
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', 'in:admin,alumno,empleado'],

            ];
            $messages = [
                'required' => 'El campo :attribute es obligatorio.',
                'string' => 'El campo :attribute debe ser una cadena de texto.',
                'max' => 'El campo :attribute no puede tener más de :max caracteres.',
                'email' => 'El formato del correo electrónico no es válido.',
                'unique' => 'El correo electrónico ya está registrado.',
                'confirmed' => 'La confirmación de la contraseña no coincide.',
            ];

            return Validator::make($data, $rules, $messages);
        }
    }

    protected function create(array $data)
    {
        if (isset($data['code'])) {
            $code = $data['code'];
            $invitation = InvitationCode::where('code', $code)
                ->where('used', 0)
                ->first();
            $invitation->used = 1;
            $invitation->save();


            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'verificado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $user = $this->createCustom($data);
            return $user;
        }



    }

    protected function createCustom(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'verificado' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
    protected function registered(Request $request, $user)
    {


        $clases = Clase::all();
        $existeUsuario = $this->comprobarExistencia($user);
        if ($existeUsuario && $user->verificado === 'true') {
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
                $redirectPath = route('registroAlumno');
            } else {
                $redirectPath = route('mostrarRegistro');
            }

        }


        $request->session()->flash('registro_exitoso', 'Registro exitoso. Bienvenido.');
        $request->session()->put('user', $user);

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
