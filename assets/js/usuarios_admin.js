


(function ($) {

    $("#formulario-login").submit(function(e) {
        e.preventDefault();
        ingresar();
    });
})(jQuery);
    

function ingresar(){
       var  email =$("#email").val();
       var  password =$("#password").val();
    $.ajax({
        dataType: "json",
        data: {email,password
           
        },

        url: base_url + "Cadmin/validarSession",
        type: "post",
        beforeSend: function () {
            $("#loginbtn").html('Validando..');
        },
        success: function (respuesta) {
            
          

            if (respuesta.resultado == false) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: respuesta.mensaje,
                });

                $("#loginbtn").html('Ingresar');
            }else{

                $(location).attr("href", base_url + "admin/inicio");
            }
        },
        error: function (xhr, err) {
            $("#loginbtn").html('Ingresar');
            console.log(err);
            alert("ocurrio un error intente de nuevo");
        },
    });
}