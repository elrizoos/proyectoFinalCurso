<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Llamado de emergencia</title>
</head>
<body>
    <p>Su código de registro es:
        <b>{{ $code }}
    </p>
    <p>Accede al siguiente enlace para registrarte ahora y disfrutar de todas las novedades de nuestra app</p>
    <a href="{{ url('/register')}}">App</a>
   
</body>
</html>