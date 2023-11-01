import "./bootstrap";
console.log("Script cargado");
import $ from 'jquery';
/*$(document).ready(function () {
    $("#tramoHorario").change(function () {
        const tramo = $(this).val(); //Captura del valor del select
        console.log("tramo" + tramo);
        if (tramo) {
            const partes = tramo.split("---");
            console.log("partes:  " + partes);
            console.log(partes[0]);
            $("#horaInicio").val(partes[0]);
            $("#horaFin").val(partes[1]);
        } else {
            $("#horaInicio").val("");
            $("#horaFin").val("");
        }
    });
});
*/


$(function () {
    document
        .querySelector("#cuadradoGrupo")
        .addEventListener("click", editarGrupos);
    document
        .querySelector("#cuadradoClase")
        .addEventListener("click", editarClases);
});

function editarGrupos() {
    //console.log("Hola, estamos dentro de editarGrupos");
    document.querySelector('#ediccion')
}

function editarClases() {
    //console.log("Hola, estamos dentro de editarClases");
}

