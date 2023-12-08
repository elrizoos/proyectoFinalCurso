<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @extends('layouts.app', ['modo' => 'Centro de Control'])
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col">
                    <form id="generadorCodigoForm"
                        action="{{ route('generadorCodigo') }}"
                        method="get">
                        @csrf

                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input id="email" type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                        </div>

                        <button id="enviar" type="submit">Generar Código</button>
                    </form>

                    
                </div>
            </div>
        </div>
    @endsection
