<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
     @extends('layouts.app', ['modo' => 'empleado:'])
    @section('content')
    <div class="container">
        <div class="contenedorTarjeta">
            <div class="row">
                <div class="col">
                    <div class="imagen">
                        <div class="foto">
                            foto: {{$empleado}}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="datos">
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="menu">
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="contenidoCambiante">

                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>