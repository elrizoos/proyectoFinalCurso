<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   @extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Detalles del Empleado
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $empleado->nombre }} {{ $empleado->apellidos }}</h5>
            <p class="card-text">
                <strong>DNI:</strong> {{ $empleado->dni }}<br>
                <strong>Teléfono:</strong> {{ $empleado->telefono }}<br>
                <strong>Email:</strong> {{ $empleado->email }}<br>
                <strong>Fecha de Nacimiento:</strong> {{ $empleado->fechaNacimiento }}<br>
                <strong>Dirección:</strong> {{ $empleado->direccion }}<br>
                <strong>Código de Clase:</strong> {{ $empleado->codigoClase }}
            </p>
            <a href="{{ url( $empleado->foto) }}" target="_blank">
                <img src="{{ url( $empleado->foto) }}" class="img-fluid img-thumbnail" alt="Foto de {{ $empleado->nombre }}">
            </a>
        </div>
    </div>
    <h2>Lista de Alumnos</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se insertarán las filas de la tabla con los datos de los alumnos -->
                <!-- Suponiendo que tienes un array de alumnos en PHP -->
                
                @foreach ($alumnos as $alumno)
                    <tr>
                        <td>{{$alumno->nombre}}</td>
                        <td>{{$alumno->apellidos}}</td>
                        <td>{{$alumno->email}}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
</div>
@endsection
</body>
</html>