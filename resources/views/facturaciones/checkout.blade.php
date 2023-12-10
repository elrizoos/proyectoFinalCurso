<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripcion Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Ocultamos el checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Estilo del "deslizador" */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Forma redondeada */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @extends('layouts.app')


    @section('content')
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">
                    <img src="" alt="" style="height: 40px;">
                </a>
            </nav>
        </header>
        <?php
        $producto = session()->get('producto');
        $producto = json_decode($producto, true);
        ?>
        <main>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h4">Resumen del Pedido</h2>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Producto: <span id="nombreProducto">{{ $producto['nombre'] }}</span></li>
                                    <li>Precio: <span
                                            id="precioProducto">{{ isset($producto['precioMensual']) ? $producto['precioMensual'] : old('precioProducto') }}</span>
                                    </li>
                                    <li>
                                        <label class="switch">
                                            <input type="checkbox" id="formaPago" onchange="cambiarFormaPago()">
                                            <span class="slider round"></span>
                                        </label> <span id="textoForma">Pago Mensual</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h4">Detalles de Facturación</h2>
                            </div>
                            <div class="card-body">
                                <form id="payment-form" action="{{ route('verificarPago') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="precio" id="precio"
                                        value="{{ isset($producto['precioMensual']) ? $producto['precioMensual'] : old('precio') }}">
                                    <input type="hidden" name="stripeToken" id="stripeToken">
                                    <input type="hidden" name="producto" id="producto">
                                    <input type="hidden" name="mensualAnual" id="mensualAnual">
                                    <div class="form-group">
                                        <label for="nombre">Nombre en la Tarjeta</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                                    </div>
                                    <div class="form-group" id="card-element">
                                        <!-- Elemento de Tarjeta Stripe se montará aquí -->
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Realizar Pago</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-light text-center text-lg-start">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2023 Derechos reservados: <a class="text-dark"
                    href="https://www.estudiopilates.host/">estudioPilates.host</a>
            </div>
        </footer>
    @endsection
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function cambiarFormaPago() {
            formaPago = document.querySelector('#formaPago').checked;
            precioProducto = document.querySelector('#precioProducto');
            textoForma = document.querySelector('#textoForma');
            precioElegido = document.querySelector('#precio');
            mensualAnual = document.querySelector('#mensualAnual');


            console.log($mensualAnual.value)
            if ($formaPago === true) {
                precioProducto.innerText =
                    '{{ isset($producto['precioAnual']) ? $producto['precioAnual'] : old('precioAnual') }}';
                textoForma.innerText = 'Pago Anual';
                precioElegido.value = '{{ isset($producto['precioAnual']) ? $producto['precioAnual'] : old('precioAnual') }}';
                
                mensualAnual.value = 'anual';
            } else {
                precioProducto.innerText =
                    '{{ isset($producto['precioMensual']) ? $producto['precioMensual'] : old('precioMensual') }}';
                textoForma.innerText = 'Pago Mensual';
                precioElegido.value =
                    '{{ isset($producto['precioMensual']) ? $producto['precioMensual'] : old('precioMensual') }}';
                mensualAnual.value = 'mensual';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            var stripe = Stripe('{{ $stripeKey }}'); // Clave pública
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');
            var precioElegido = document.querySelector('#precio').value;
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                console.log("dentro de la funcion de form");
                var producto = {!! json_encode($producto) !!};
                producto['precioElegido'] = precioElegido;
                console.log(producto);
                document.querySelector('#producto').value = JSON.stringify(producto);

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Informar al usuario si hubo un error.
                        console.log(result.error.message);
                    } else {
                        // Envía el token a tu servidor.
                        document.getElementById('stripeToken').value = result.token.id;
                        form.submit();
                        setInterval(() => {
                            location.reload();

                        }, 5000);
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
