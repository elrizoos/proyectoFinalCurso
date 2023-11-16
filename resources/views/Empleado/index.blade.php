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
        <div class="row">
            <div class="col columnaPerfil">
                <div class="imagen">
                    {{ print_r($empleados)}}
                </div>
            </div>
            <div class="col">
                f1c2
            </div>
            <div class="col">
                f1c3
            </div>
        </div>
    </div>
    @endsection
</body>
</html>