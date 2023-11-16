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
            <form action="{{ url('/galeria') }}" method="POST" enctype="multipart/form-data">
@csrf
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre">
                <input type="file" name="ruta" id="ruta">
                <input type="submit" value="subir">
            </form>

        </div>
    @endsection
</body>

</html>
