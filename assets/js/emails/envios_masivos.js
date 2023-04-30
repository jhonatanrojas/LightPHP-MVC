
$(".btn-programar").click(function(e) {


    $("#id_campana").val( $(this).data('id_campana'))

$("#moda_programar").modal("show");
})

$(".btn-pruebas").click(function(e) {
    $("#modal_pruebas").modal("show");

    $("#id_campana").val( $(this).data('id_campana'))
  

})

$(".btn-elimimar").click(function(e) {
   

   $("#id_campana").val( $(this).data('id_campana'))
    Swal.fire({
        title: "¿Estas seguro?",
        text: "",
        icon: "warning",
        buttons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!',
        dangerMode: true,
      })
      .then((confirm) => {
        if (confirm.isConfirmed) {
            
            var data={
                accion:'eliminar_plantilla',
                id_campana:$(this).data('id_campana')
            }
            pausar_envio(data);
        }
})
  

})


$(".btn-enviar-pruebas").click(function(e) {
    $("#modal_pruebas").modal("hide");

    var data={
        accion:'enviar_prueba',
        id_campana:$("#id_campana").val(),
        correo:$("#nombre_correo").val()
    }
    enviar_prueba(data)

})

$(".btn-pausar").click(function(e) {
    $("#id_campana").val( $(this).data('id_campana'))

    Swal.fire({
        title: "¿Estas seguro?",
        text: "",
        icon: "warning",
        buttons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Pausar!',
        dangerMode: true,
      })
      .then((confirm) => {
        if (confirm.isConfirmed) {
            
            var data={
                accion:'pausar_envio',
                id_campana:$(this).data('id_campana')
            }
            pausar_envio(data);
        }
})

})


$(".btn-continuar").click(function(e) {
    $("#id_campana").val( $(this).data('id_campana'))

    Swal.fire({
        title: "¿Estas seguro?",
        text: "",
        icon: "warning",
        buttons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Continuar el envio!',
        dangerMode: true,
      })
      .then((confirm) => {
        if (confirm.isConfirmed) {
            
            var data={
                accion:'continuar_envio',
                id_campana:$(this).data('id_campana')
            }
            pausar_envio(data);
        }
})

})



$(".btn-copia").click(function(e) {


    $("#id_campana").val( $(this).data('id_campana'))
    $("#nombre_edit").val( $(this).data('nombre'))
    $("#asunto_edit").val( $(this).data('asunto'))

    $("#modal_copia").modal("show");


})
$(".btn-guardar-copia").click(function() {

    var data={
        nombre:$("#nombre_edit").val(),
        asunto:$("#asunto_edit").val(),
        id_campana:$("#id_campana").val(),
        fecha:$("#fecha_reenvio").val()
        
    }
    guardar_copia(data)

    })
    

$(".btn-guardar-fecha").click(function() {

    var data={
        fecha:$("#fecha_envio").val(),
        id_campana:$("#id_campana").val()
    }
    programar_envio(data)

    })
    

$(".btn-cerrar-modal").click(function() {

    $("#moda_programar").modal("hide");
    })
    

$('#fecha_envio').datepicker({
    format: 'dd/mm/yyyy',
    container: '#moda_programar',
    lang:'es',

    startDate: '+0d'
});



    

function programar_envio(data){

    $("#moda_programar").modal("hide");
    $.ajax({
        dataType: "json",
        data: data,

        url: BASE_URL + "?url=ajax/ProgramarEnvio",
        type: "post",
        beforeSend: function () {
            //$("#cod_municipio").selectpicker('refresh');
        },
        success: function (respuesta) {
            console.log(respuesta);
            if (respuesta.result == true) {
                Swal.fire({
                    icon: "success",
                    title: "Actualizacion Exitosa",

                    text: "Presione OK para continuar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $(location).attr(
                            "href",
                            BASE_URL +'?url=Inicio'
                        );
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: respuesta.msg,
                });
            }
        },
        error: function (xhr, err) {
            console.log(err);
            alert("ocurrio un error intente de nuevo");
        },
    });
}

function guardar_copia(data){

    $("#modal_copia").modal("hide");
    $.ajax({
        dataType: "json",
        data: data,

        url: BASE_URL + "?url=ajax/GuardarCopia",
        type: "post",
        beforeSend: function () {
            //$("#cod_municipio").selectpicker('refresh');
        },
        success: function (respuesta) {
            console.log(respuesta);
            if (respuesta.result == true) {
                Swal.fire({
                    icon: "success",
                    title: "Copia realizada",
                    text: "Presione OK para continuar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $(location).attr(
                            "href",
                            BASE_URL +'?url=Inicio'
                        );
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: respuesta.msg,
                });
            }
        },
        error: function (xhr, err) {
            console.log(err);
            alert("ocurrio un error intente de nuevo");
        },
    });
}


function pausar_envio(data){


    $.ajax({
        dataType: "json",
        data: data,

        url: BASE_URL + "?url=ajax/Consultas",
        type: "post",
        beforeSend: function () {
            //$("#cod_municipio").selectpicker('refresh');
        },
        success: function (respuesta) {
            console.log(respuesta);
            if (respuesta.result == true) {
                Swal.fire({
                    icon: "success",
                    title: "Accion completada",
                    text: "Presione OK para continuar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $(location).attr(
                            "href",
                            BASE_URL +'?url=Inicio'
                        );
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: respuesta.msg,
                });
            }
        },
        error: function (xhr, err) {
            console.log(err);
            alert("ocurrio un error intente de nuevo");
        },
    });
}


function enviar_prueba(data){


    $.ajax({
        dataType: "json",
        data: data,

        url: BASE_URL + "?url=ajax/Consultas",
        type: "post",
        beforeSend: function () {
            //$("#cod_municipio").selectpicker('refresh');
        },
        success: function (respuesta) {
            console.log(respuesta);
            if (respuesta.result == true) {
                Swal.fire({
                    icon: "success",
                    title: "Accion completada",
                    text: "Presione OK para continuar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                      
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: respuesta.msg,
                });
            }
        },
        error: function (xhr, err) {
            console.log(err);
            alert("ocurrio un error intente de nuevo");
        },
    });
}

