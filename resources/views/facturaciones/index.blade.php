<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div id="tiempoTranscurrido" data-tiempo="{{ $segundosDesdeCreacion }}"></div>

   @foreach ($productos as $producto)
    <div class="tarifa tarifa-basica">
        <h2>{{ $producto['nombre'] }}</h2>
        <p>{{ $producto['descripcion'] }}</p>
        <p>{{$producto['precioMensual']}}</p>
        <p>O</p>
        <p><p>{{$producto['precioAnual']}}</p></p>
        
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="producto" value="{{ json_encode($producto) }}">
            <button type="submit">Comprar</button>
        </form>
    </div>
@endforeach


    <div class="aviso">
        <p>¡Aviso importante! Debes hacer tu elección antes de 72 horas.</p>
        <form action="{{ route('masTarde') }}" method="POST">
            @csrf
            <button id="mas-tarde" type="submit">Más Tarde</button>
        </form>
        <span id="contador">Tiempo restante: </span>
    </div>
@endsection
    <script>
        var tiempoTranscurrido = document.querySelector('#tiempoTranscurrido').dataset.tiempo;
        let tiempoTotal = 72 * 60 * 60; // 72 horas en segundos

        let tiempoRestante = tiempoTotal - tiempoTranscurrido;

        function actualizarContador() {
            console.log(tiempoTranscurrido);
            const horas = Math.floor(tiempoRestante / 3600);
            const minutos = Math.floor((tiempoRestante % 3600) / 60);
            const segundosRestantes = tiempoRestante % 60;
            document.getElementById('contador').innerText =
                `Tiempo restante: ${horas}:${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
        }

        setInterval(() => {
            tiempoRestante--;
            if (tiempoRestante <= 0) {
                // Puedes redirigir al usuario o realizar alguna acción cuando expire el tiempo
                alert('¡Se ha agotado el tiempo! La cuenta se cerrará.');
            } else {
                actualizarContador();
            }
        }, 1000);
    </script>
</body>

</html>
