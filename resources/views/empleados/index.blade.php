<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    @extends('layouts.app', ['modo' => 'Empleados'])
    @section('content')
        <div class="container">
            @if (Session::has('mensaje'))
                {{ Session::get('mensaje') }}
            @endif
            <a href="{{ url('empleados/create') }}" class="btn btn-success">Crear nuevo empleado</a>
            <br><br>
            <table id="tablaEmpleados" class="table text-center align-middle table-striped-columns table-responsive fs-6">
                <thead class="table-light ">
                    <th>Foto</th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'id', 'direccion' => $direccion == 'asc' && $columna == 'id' ? 'desc' : 'asc']) }}">ID</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'nombre', 'direccion' => $direccion == 'asc' && $columna == 'nombre' ? 'desc' : 'asc']) }}">Nombre</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'apellidos', 'direccion' => $direccion == 'asc' && $columna == 'apellidos' ? 'desc' : 'asc']) }}">Apellidos</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'dni', 'direccion' => $direccion == 'asc' && $columna == 'dni' ? 'desc' : 'asc']) }}">DNI</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'telefono', 'direccion' => $direccion == 'asc' && $columna == 'telefono' ? 'desc' : 'asc']) }}">Telefono</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'email', 'direccion' => $direccion == 'asc' && $columna == 'email' ? 'desc' : 'asc']) }}">Email</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'fechaNacimiento', 'direccion' => $direccion == 'asc' && $columna == 'fechaNacimiento' ? 'desc' : 'asc']) }}">fechaNacimiento</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'direccion', 'direccion' => $direccion == 'asc' && $columna == 'direccion' ? 'desc' : 'asc']) }}">direccion</a></th>
                    <th> <a href="{{ route('gestionEmplead', ['columna' => 'codigoGrupo', 'direccion' => $direccion == 'asc' && $columna == 'codigoGrupo' ? 'desc' : 'asc']) }}">codigoGrupo</a></th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td>
                                <img src="{{ asset('/storage/'.$empleado->foto) }}" alt="Imagen del usuario">

                            </td>
                            <td>{{ $empleado->id }}</td>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->apellidos }}</td>
                            <td>{{ $empleado->dni }}</td>
                            <td>{{ $empleado->telefono }}</td>
                            <td>{{ $empleado->email }}</td>
                            <td>{{ $empleado->fechaNacimiento }}</td>
                            <td>{{ $empleado->direccion }}</td>
                            <td>{{ $empleado->codigoClase }}</td>
                            <td><a href=" {{ url('/empleados/' . $empleado->id . '/edit') }}"
                                    class="btn btn-warning d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg></a>

                                <form action="{{ url('/empleados/' . $empleado->id) }}" method="post"
                                    class="d-inline-block">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="X" class="btn btn-danger"
                                        onclick="return confirm('¿Quieres borrar el empleado?')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
            <div id="paginacion" class="pagination-container">
                {{ $empleados->appends(request()->input())->links('pagination::bootstrap-4') }}
                </div>
        </div>
    @endsection
</body>

</html>
