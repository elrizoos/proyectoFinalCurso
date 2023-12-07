<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Exitoso</title>
    <!-- Estilos comunes aquí -->
</head>
<body>
    <div class="container">
        <h1>Pago Exitoso</h1>
        <p>Tu pago ha sido procesado correctamente.</p>
        @if (Auth::user())
            @php
                $user = Auth::user();
            @endphp
            <a href="{{ route('inicioAlumno', ['alumno' => $user->email]) }}">Volver al Inicio</a>
        @else
            <a href="{{ url('/') }}">Volver al Inicio</a>
        @endif
    </div>
</body>
</html>
