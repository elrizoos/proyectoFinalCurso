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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registro') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('registrarEmpleado')}}" enctype="multipart/form-data">
                            @csrf

                            <input class="form-control" type="hidden" name="idUser" value="{{$user}}">

                            <div class="form-group">
                                <label for="apellidos">{{ __('Apellidos') }}</label>
                                <input id="apellidos" type="text" class="form-control" name="apellidos" required>
                            </div>

                            <div class="form-group">
                                <label for="direccion">{{ __('Dirección') }}</label>
                                <input id="direccion" type="text" class="form-control" name="direccion" required>
                            </div>

                            <div class="form-group">
                                <label for="dni">{{ __('DNI') }}</label>
                                <input id="dni" type="text" class="form-control" name="dni" required>
                            </div>

                            <div class="form-group">
                                <label for="telefono">{{ __('Teléfono') }}</label>
                                <input id="telefono" type="tel" class="form-control" name="telefono" required>
                            </div>

                           

                            <div class="form-group">
                                <label for="fechaNacimiento">{{ __('Fecha de Nacimiento') }}</label>
                                <input id="fechaNacimiento" type="date" class="form-control" name="fechaNacimiento" required>
                            </div>

                            <div class="form-group">
                                <label for="foto">{{ __('Foto') }}</label>
                                <input id="foto" type="file" class="form-control" name="foto" accept="image/*" required>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

</body>
</html>