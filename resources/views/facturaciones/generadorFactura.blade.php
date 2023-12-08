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
            @php
                $producto = json_decode($producto);
            @endphp
            <table id="tablaAlumnos" class="table text-center align-middle table-striped-columns table-responsive fs-6">
                <tr>
                    <td>Nombre de la Empresa: Estudio Pilates</td>
                    <td>Dirección: Sin direccion </td>
                </tr>
                <tr>
                    <td>Teléfono: 643 51 09 09</td>
                    <td>Email: infotrabajo97@gmail.com</td>
                </tr>
            </table>

            <table class="tabla-producto">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                </tr>
                <tr>
                    <td>Producto: {{ $producto->nombre }}</td>
                    <td>Total: {{ $producto->precioElegido }}</td>
                </tr>
            </table>
        </div>
        @endsection
    </body>

    </html>
