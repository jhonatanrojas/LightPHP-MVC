
<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sash – Bootstrap 5  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->

    <!-- TITLE -->
    <title>Notificaciones</title>

    <!-- BOOTSTRAP CSS -->

    <!-- STYLE CSS -->
    <link id="style" href="<?php echo BASE_URL?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <link href="<?php echo BASE_URL?>assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL?>assets/css/dark-style.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL?>assets/css/transparent-style.css" rel="stylesheet">
    <link href="<?php echo BASE_URL?>assets/css/skin-modes.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="<?php echo BASE_URL?>assets/colors/color1.css" />

</head>

<body class="app sidebar-mini ltr">

    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">

 
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">

                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <img src="<?php echo BASE_URL?>assets/images/brand/logo-white.png" class="header-brand-img" alt="">
                    </div>
                </div>

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id="login">
                            <span class="login100-form-title pb-5">
                                Login
                            </span>
                            <div class="panel panel-primary">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class="mx-0"><a href="#tab5" class="active" data-bs-toggle="tab">Email</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input required class="input100 border-start-0 form-control ms-0" id="email" type="email" placeholder="Email">
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input  required class="input100 border-start-0 form-control ms-0" id="clave" type="password" placeholder="Password">
                                            </div>
                                            <div class="text-end pt-4">
                                            </div>
                                            <div class="container-login100-form-btn">
                                                <button  class=" btn login100-form-btn btn-primary iniciar btn-enviar">
                                                        Iniciar Sesión
                                                </button>
                                            </div>
                        
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    <!-- JQUERY JS -->
      <!-- JQUERY JS -->
      <script src="<?php echo BASE_URL?>assets/js/jquery.min.js"></script>
  
  <!-- BOOTSTRAP JS -->
  <script src="<?php echo BASE_URL?>assets/plugins/bootstrap/js/popper.min.js"></script>
  <script src="<?php echo BASE_URL?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script>

$( "#login" ).submit(function( event ) {

  event.preventDefault();

  inicio()
});

        	function inicio(){
            var data ={
                email:$("#email").val(),
                clave:$("#clave").val(),
            }
		$.ajax({
			dataType: "json",
			data: data,

			url: "<?php echo BASE_URL?>?url=Inicio/validar",
			type: "post",
			beforeSend: function () {
				//$("#cod_municipio").selectpicker('refresh');
			},
			success: function (respuesta) {
				console.log(respuesta);
				if (respuesta.result == true) {
				
                    location.href = "<?php echo BASE_URL?>?url=Notificaciones/"
				} else {
                    alert("Usuario o Contraseña incorrecta")
				
				}
			},
			error: function (xhr, err) {
				console.log(err);
				alert("ocurrio un error intente de nuevo");
			},
		});
	}
    </script>
</body>

</html>