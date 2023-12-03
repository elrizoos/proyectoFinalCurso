<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .tarifa {
            width: 200px;
            height: 150px;
            padding: 20px;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tarifa-basica {
            background-color: #3498db;
            color: #fff;
        }

        .tarifa-premium {
            background-color: #2ecc71;
            color: #fff;
        }

        .tarifa-flex {
            background-color: #e74c3c;
            color: #fff;
        }
    </style>
</head>

<body>
    <div id="tiempoTranscurrido" data-tiempo="{{ $segundosDesdeCreacion }}"></div>

   @foreach ($productos as $producto)
    <div class="tarifa tarifa-basica">
        <h2>{{ $producto['nombre'] }}</h2>
        <p>{{ $producto['descripcion'] }}</p>
        <p>{{ $producto['precio'] }}</p>
        
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
