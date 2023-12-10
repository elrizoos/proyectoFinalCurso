<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['nombre', 'apellidos', 'dni', 'telefono', 'email', 'fechaNacimiento','direccion','foto','codigoGrupo','password'];
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function obtenerAsistencias()
    {
        //dd($this);
        $asistencia = Asistencia::where('alumno_id', '=', $this->id)->get();
        //dd($asistencia);
        $numeroAsistencias = $asistencia->count();

        return ['numeroAsistencias' => $numeroAsistencias, 'asistencias' => $asistencia];
    }
}
