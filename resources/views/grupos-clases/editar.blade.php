<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ediccion de grupos y clases</title>
</head>
<body>
    @extends('layouts.app', ['modo' => 'Centro de Control'])
    @section('content')
    <div class="container ediccion">
        <div class="row">
            <div class="col col-6">
                <div id="cuadradoGrupo" class="cuadrado">
                    <a href="{{url('grupos-clases/grupos/editar')}}">Editar Grupos</a>
                </div>
            </div>
            <div class="col col-6">
                <div id="cuadradoClase" class="cuadrado">
                    <a href="{{url('grupos-clases/clases/editar')}}">Editar Clases</a>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>