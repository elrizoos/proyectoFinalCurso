<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Studio de Pilates</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #343a40;
        }

        .user-profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-avatar {
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
            width: 80px;
            height: 80px;
        }

        .user-avatar img {
            width: 100%;
            height: auto;
        }

        .user-info {
            flex-grow: 1;
        }

        .user-info h2 {
            margin: 0;
            color: #343a40;
        }

        .user-info p {
            margin: 5px 0;
            color: #6c757d;
        }

        .user-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .stat {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .stat:hover {
            transform: scale(1.05);
        }

        .class-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 1em;
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

@section('content')



    <header>
        <h1>Perfil de Usuario</h1>
    </header>

    <main class="container">
        <div class="user-profile">
            <div class="user-avatar">
                <img src="avatar.jpg" alt="Avatar">
            </div>
            <div class="user-info">
                <h2>Nombre del Usuario</h2>
                <p>Email: usuario@example.com</p>
                <p>Teléfono: 123-456-7890</p>
            </div>
        </div>

        <div class="user-stats">
            <div class="stat" data-toggle="modal" data-target="#clasesAsistidasModal">
                <h3>Clases Asistidas</h3>
                <p>25</p>
            </div>
            <div class="stat" data-toggle="modal" data-target="#horasEntrenamientoModal">
                <h3>Horas de Entrenamiento</h3>
                <p>20</p>
            </div>
            <div class="stat">
                <h3>Nivel</h3>
                <p>Intermedio</p>
            </div>
        </div>

        <h2>Próximas Clases</h2>

        <div class="class-card">
            <h3>Clase de Pilates Matutina</h3>
            <p>Fecha: DD/MM/YYYY</p>
            <p>Hora: HH:MM</p>
            <button class="btn btn-primary">Reservar</button>
        </div>

        <div class="class-card">
            <h3>Clase de Pilates Vespertina</h3>
            <p>Fecha: DD/MM/YYYY</p>
            <p>Hora: HH:MM</p>
            <button class="btn btn-primary">Reservar</button>
        </div>
    </main>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Modals for stats -->
    <div class="modal fade" id="clasesAsistidasModal" tabindex="-1" role="dialog" aria-labelledby="clasesAsistidasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clasesAsistidasModalLabel">Clases Asistidas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Aquí puedes ver detalles sobre las clases asistidas.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="horasEntrenamientoModal" tabindex="-1" role="dialog" aria-labelledby="horasEntrenamientoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="horasEntrenamientoModalLabel">Horas de Entrenamiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Aquí puedes ver detalles sobre las horas de entrenamiento.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2023 Studio de Pilates
    </footer>

    @endsection
</body>
</html>
