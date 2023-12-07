<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error en el Pago</title>
    <!-- Estilos comunes aquí -->
</head>
<body>
    @if (Auth::user())
        
    @endif
    <div class="container">
        <h1>Error en el Pago</h1>
        <p>Lo sentimos, hubo un problema al procesar tu pago.</p>
        <a href="{{ route('inicioAlumno') }}">Volver al Inicio</a>
    </div>
</body>
</html>
