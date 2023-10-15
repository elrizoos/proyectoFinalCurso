document.addEventListener("DOMContentLoaded", function () {
    const encabezados = document.querySelectorAll("th[data-column]");

    encabezados.forEach((encabezado) => {
        encabezado.addEventListener("click", function () {
            const columna = this.getAttribute("data-column");
            ordenarYFiltrarTabla(columna);
        });
    });

    let columnaActual = "nombre"; // Variable para rastrear la columna actual
    let ordenActual = "asc"; // Variable para rastrear el orden actual

    function ordenarYFiltrarTabla(columna) {
        $.ajax({
            type: "GET",
            url: "/alumnos/obtener-alumnos",
            data: {
                columna: columna,
                orden: ordenActual,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                // Accede a los datos del JSON
                var alumnos = data.alumnos;
                var pagination = data.pagination;

                // Actualiza la tabla con los resultados ordenados
                actualizarTabla(alumnos);

                // Actualiza la paginación
                actualizarPaginacion(pagination);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }

    function actualizarTabla(alumnos) {
        var tabla = $("#tablaAlumnos tbody");
        tabla.empty();

        $.each(alumnos, function (index, alumno) {
            tabla.append(
                '<tr><td><img class="img-thumbnail img-fluid" width="70px" height="100px" src="' +
                    alumno.foto +
                    '" alt="Imagen del usuario"></td><td>' +
                    alumno.id +
                    "</td><td>" +
                    alumno.nombre +
                    "</td><td>" +
                    alumno.apellidos +
                    "</td><td>" +
                    alumno.dni +
                    "</td><td>" +
                    alumno.telefono +
                    "</td><td>" +
                    alumno.email +
                    "</td><td>" +
                    alumno.fechaNacimiento +
                    "</td><td>" +
                    alumno.direccion +
                    "</td><td>" +
                    alumno.codigoGrupo +
                    "</td></tr>"
            );
        });
    }

    function actualizarPaginacion(pagination) {
        // Actualiza la paginación en tu vista, por ejemplo, usando Blade en Laravel
        // Debe estar fuera del elemento <table>
        var paginacion = $("#paginacion");
        paginacion = {{ $alumnos->appends(['columna' => $columnaActual, 'orden' => $ordenActual])->links('pagination::bootstrap-4') }}
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const encabezados = document.querySelectorAll("th[data-column]");
    const camposTexto = document.querySelectorAll("tbody tr");

    encabezados.forEach((encabezado) => {
        encabezado.addEventListener("click", function () {
            const columna = this.getAttribute("data-column");
            ordenarYFiltrarTabla(columna);
        });
    });
    let columnaActual = "nombre"; // Variable para rastrear la columna actual
    let ordenActual = "asc"; // Variable para rastrear el orden actual
    function ordenarYFiltrarTabla(columna) {
        if (columna === columnaActual) {
            // Si se hace clic en la misma columna, cambia el orden
            ordenActual = ordenActual === "asc" ? "desc" : "asc";
        } else {
            // Si se hace clic en una nueva columna, restablece el orden a ascendente
            ordenActual = "asc";
            columnaActual = columna;
        }

        $.ajax({
            type: "GET",
            url:
                "alumnos/obtener-alumnos?columna=" +
                columnaActual +
                "&orden=" +
                ordenActual,
            data: {
                columna: columnaActual,
                orden: ordenActual, // Nuevo parámetro para el orden
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                // Accede a los datos del JSON
                var alumnos = data.alumnos;
                var pagination = data.pagination;

                // Haz lo que necesites con los datos
                console.log(alumnos); // Array de alumnos
                console.log(pagination); // Datos de paginación

                // Por ejemplo, puedes recorrer los alumnos y agregarlos a tu tabla
                var tabla = $("#tablaAlumnos tbody");
                tabla.empty();

                $.each(alumnos, function (index, alumno) {
                    tabla.append(
                        '<tr><td><img class="img-thumbnail img-fluid" width="70px" height="100px" src="' +
                            alumno.foto +
                            '" alt="Imagen del usuario"></td><td>' +
                            alumno.id +
                            "</td><td>" +
                            alumno.nombre +
                            "</td><td>" +
                            alumno.apellidos +
                            "</td><td>" +
                            alumno.dni +
                            "</td><td>" +
                            alumno.telefono +
                            "</td><td>" +
                            alumno.email +
                            "</td><td>" +
                            alumno.fechaNacimiento +
                            "</td><td>" +
                            alumno.direccion +
                            "</td><td>" +
                            alumno.codigoGrupo +
                            "</td></tr>"
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }
});
