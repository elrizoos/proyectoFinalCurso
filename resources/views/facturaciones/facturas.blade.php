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
            <h1>Lista de Facturas</h1>
        <table id="tablaAlumnos" class="table text-center align-middle table-striped-columns table-responsive fs-6">
            <thead class="table-responsive ">
                <tr>
                    <th>Referencia</th>
                    <th>Nombre de Archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                    <tr>
                        <td>{{ $factura['referencia'] }}</td>
                        <td><a  class="btn btn-warning d-inline-block" href="{{ route('descargar.factura', $factura['nombre']) }}">{{ $factura['nombre'] }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endsection
</body>

</html>
