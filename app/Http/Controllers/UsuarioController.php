<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }

    public function mostrarNotificaciones(){
        $user = Auth::user();
        $lastLoginAt = Carbon::parse($user->last_login_at);
        $cambiosAlumnos = Alumno::where('updated_at', '>', $lastLoginAt)->get();
        $cambiosEmpleados = Empleado::where('updated_at', '>', $lastLoginAt)->get();
        return view('notificaciones.list', compact('cambiosAlumnos', 'cambiosEmpleados'));

    }
}
