<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Studio de Pilates</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    ç
</head>

<body>
    @extends('layouts.app')

    @section('content')
        @if (count($errors) > 0)
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <header>
            <h1>Perfil de Usuario</h1>
        </header>

        <main class="container">
            <div class="user-profile">
                <div class="user-avatar">
                    <img class="img-thumbnail img-fluid" width="70px" height="100px" src="{{ asset($alumno->foto) }}"
                        alt="Imagen del usuario">
                </div>
                <div class="user-info">
                    <h2>{{ $alumno->nombre }}</h2>
                    <p>Email: {{ $alumno->email }}</p>
                    <p>Teléfono: {{ $alumno->telefono }}</p>
                    <p>Grupo: {{ $alumno->codigoGrupo }}</p>
                </div>
            </div>

            <div class="user-stats">
                <div class="stat" data-toggle="modal" data-target="#clasesAsistidasModal">
                    <h3>Clases Asistidas</h3>
                    <p>{{ $asistencias['numeroAsistencias'] }}</p>
                </div>
                <div class="stat" data-toggle="modal" data-target="#horasEntrenamientoModal">
                    <h3>Horas de Entrenamiento</h3>
                    <p>{{ $asistencias['numeroAsistencias'] * 1.5 }}</p>
                </div>
                <div class="stat">
                    <h3>Nivel</h3>
                    <p>
                        <?php
                        
                        if ($asistencias['numeroAsistencias'] < 30) {
                            echo 'Básico';
                        } elseif ($asistencias['numeroAsistencias'] >= 30 && $asistencias['numeroAsistencias'] < 60) {
                            echo 'Intermedio';
                        } else {
                            echo 'Avanzado';
                        }
                        ?>
                    </p>
                </div>
            </div>

            <h2>Próximas Clases</h2>

            <div class="class-card">
                <h3>Clase de Pilates Matutina</h3>
                <p>Fecha: {{ $horarioMañana !== 0 ? $horarioMañana->primerDia : 'No hay registros' }}</p>
                <p>Hora: {{ $horarioMañana !== 0 ? $horarioMañana->horaInicio : 'No hay registros' }}</p>
                <a
                    href="{{ $horarioMañana !== 0 ? route('reservarClase', [$horarioMañana, $alumno->id]) : '' }}">Reservar</a>
                @if (session('reserva'))
                    <div class="alert-success">
                        {{ session('reserva') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="class-card">
                <h3>Clase de Pilates Vespertina</h3>
                <p>Fecha: {{ $horarioTarde !== 0 ? $horarioTarde['primerDia'] : 'No hay registros' }}</p>
                <p>Hora: {{ $horarioTarde !== 0 ? $horarioTarde->horaInicio : 'No hay registros' }}</p>
                <button class="btn btn-primary">Reservar</button>
            </div>
            <div class="class-card">
                @foreach ($horariosReservados as $reserva)
                    <li>De <span>{{ $reserva->horaInicio }}</span> a <span>{{ $reserva->horaFin }}</span> el día
                        <span>{{ $reserva->primerDia }}</span>
                    </li>
                @endforeach
            </div>
            <!-- Modals for stats -->
            <div class="modal fade" id="clasesAsistidasModal" tabindex="-1" role="dialog"
                aria-labelledby="clasesAsistidasModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clasesAsistidasModalLabel">Clases Asistidas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Aquí puedes ver que dias asististe.</p>
                            @foreach ($asistencias['asistencias'] as $asistencia)
                                <li>{{ $asistencia['fecha_asistencia'] }}</li>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>


        <footer>
            &copy; 2023 EstudioPilates
        </footer>
    @endsection


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
