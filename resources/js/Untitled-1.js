document.addEventListener("DOMContentLoaded", function () {
    const encabezados = document.querySelectorAll("th[data-column]");

    encabezados.forEach((encabezado) => {
        encabezado.addEventListener("click", function () {
            const columna = this.getAttribute("data-column");
            ordenarYFiltrarTabla(columna);
        });
    });

    let columnaActual = "nombre";   
    let ordenActual = "asc";   

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
                  
                var alumnos = data.alumnos;
                var pagination = data.pagination;

                  
                actualizarTabla(alumnos);

                  
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
    let columnaActual = "nombre";   
    let ordenActual = "asc";   
    function ordenarYFiltrarTabla(columna) {
        if (columna === columnaActual) {
              
            ordenActual = ordenActual === "asc" ? "desc" : "asc";
        } else {
              
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
                orden: ordenActual,   
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                  
                var alumnos = data.alumnos;
                var pagination = data.pagination;

                  
                console.log(alumnos);   
                console.log(pagination);   

                  
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
