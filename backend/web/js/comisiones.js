/*=============================================
CARGAR LA TABLA DINÁMICA DE COMISIONES
=============================================*/
$(".tablaComisiones").DataTable({
    //"ajax": "index.php?r=cargos/listar-cargos-ajax",
    ajax: {
        type: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=cargos/listar-cargos-ajax',
        data: {}
    },
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});
/*=============================================
ACTIVAR CARGO
=============================================*/
$(".tablaComisiones tbody").on("click", ".btnActivar", function () {
    let objectBtn = $(this);
    let codigo = objectBtn.attr("codigo");
    let estado = objectBtn.attr("estado");
    let datos = new FormData();
    datos.append("codigoactivar", codigo);
    datos.append("estadoactivar", estado);
    $.ajax({
        url: "index.php?r=cargos/activar-comision-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                if (estado == "V") {
                    objectBtn.removeClass('btn-success');
                    objectBtn.addClass('btn-danger');
                    objectBtn.html('CADUCADO');
                    objectBtn.attr('estado', 'C');
                } else {
                    objectBtn.addClass('btn-success');
                    objectBtn.removeClass('btn-danger');
                    objectBtn.html('VIGENTE');
                    objectBtn.attr('estado', 'V');
                }
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cambiar el estado de la comisión con código " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });
});
/*=============================================
CREAR COMISION
=============================================*/
$("#btnCrearComision").click(function () {
    let nombre = $("#nombreComisionNew").val();
    let descripcion = $("#descripcionComisionNew").val();
    let datos = new FormData();
    datos.append("nombrecrear", nombre);
    datos.append("descripcioncrear", descripcion);
    $.ajax({
        url: "index.php?r=cargos/crear-comision-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok"){
                $("#modalCrearComision").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "La comisión " + nombre + " ha sido guardada correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function(){
                    $(".tablaComisiones").DataTable().ajax.reload();
                });
            }
            else{
                let mensaje;
                if(respuesta === "existe"){
                    mensaje = "la comisión " + nombre + " ya existe. Ingrese otro nombre.";
                }else{
                    mensaje = "Ocurrio un error al crear la comisión " + nombre + ". Comuniquese con el administrador del sistema."
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function(){
                    //acciones
                });
            }
        }
    });
});
/*=============================================
EDITAR COMISION
=============================================*/
$(".tablaComisiones tbody").on("click", ".btnEditarComision", function () {
    var codigo = $(this).attr("codigo");
    var datos = new FormData();
    datos.append("codigoeditar", codigo);
    $.ajax({
        url: "index.php?r=cargos/buscar-comision-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta != "error"){
                $("#codigoComisionUpd").val(respuesta["CodigoCargo"]);
                $("#nombreComisionUpd").val(respuesta["NombreCargo"]);
                $("#descripcionComisionUpd").val(respuesta["DescripcionCargo"]);
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos de la comisión con código " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function(){
                    $('#modalEditarComision').modal('hide');
                });
            }
        }
    });
});
/*=============================================
ACTUALIZAR CARGO
=============================================*/
$("#btnActualizarComision").click(function () {
    let codigo = $("#codigoComisionUpd").val();
    let nombre = $("#nombreComisionUpd").val();
    let descripcion = $("#descripcionComisionUpd").val();
    let datos = new FormData();
    datos.append("codigoactualizar", codigo);
    datos.append("nombreactualizar", nombre);
    datos.append("descripcionactualizar", descripcion);
    $.ajax({
        url: "index.php?r=cargos/actualizar-comision-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok"){
                $("#modalActualizarComision").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "La comisión " + nombre + " ha sido guardada correctamente con el código " + codigo + ".",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function(){
                    $(".tablaComisiones").DataTable().ajax.reload();
                });
            }
            else{
                let mensaje;
                if(respuesta === "existe"){
                    mensaje = "La comisión " + nombre + " ya existe. Ingrese otro nombre.";
                }else{
                    mensaje = "Ocurrio un error al actualizar los datos de la comisión con código " + codigo + ". Comuniquese con el administrador del sistema."
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function(){
                    //acciones
                });
            }
        }
    });
});
/*=============================================
ELIMINAR COMISION
=============================================*/
$(".tablaComisiones tbody").on("click", ".btnEliminarComision", function () {
    let codigo = $(this).attr("codigo");
    let nombre = $(this).attr("nombre");
    let datos = new FormData();
    datos.append("codigoeliminar", codigo);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar la comisión " + nombre + "?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function(resultado){
        if (resultado.value) {
            $.ajax({
                url: "index.php?r=cargos/eliminar-comision-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta === "ok"){
                        Swal.fire({
                            icon: "success",
                            title: "Eliminación Completada",
                            text: "La comisión " + nombre + "con el código " + codigo + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function(){
                            $(".tablaComisiones").DataTable().ajax.reload();
                        });
                    }
                    else{
                        let mensaje;
                        if(respuesta === "enUso"){
                            mensaje = "No se puede eliminar la comisión " + nombre + " con código " + codigo + " esta en uso actualmente y no puede ser eliminada. Solo puede ser inhabilitada.";
                        }else{
                            mensaje = "Ocurrio un error al eliminar la comisión con código " + codigo + ". Comuniquese con el administrador del sistema."
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: mensaje,
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function(){
                            //acciones
                        });
                    }
                }
            });
        }
    });
});