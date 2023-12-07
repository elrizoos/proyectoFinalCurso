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
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Formulario de Pago</div>

                        <div class="panel-body">
                            <form action="{{url('/facturaciones/procesar-pago')}}" method="GET">
                                @csrf

                                <div class="form-group">
                                    <label for="monto">Monto a Pagar</label>
                                    <input type="text" name="monto" id="monto" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción de la Compra</label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="correo">Correo Electrónico del Comprador</label>
                                    <input type="email" name="correo" id="correo" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Pagar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</body>

</html>
