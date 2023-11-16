<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/galeria.css') }}">
</head>

<body>
    @extends('layouts.app', ['modo' => 'Galería'])
    @section('content')
        <div class="container">
            <a href="{{url('/galeria/create')}}">subir imagen</a>
            <div class="galeria">
                @foreach ($imagenes as $imagen)
                    <div class="imagen">
                        <img src="{{ asset($imagen->ruta) }}" alt="Imagen">
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
</body>

</html>
