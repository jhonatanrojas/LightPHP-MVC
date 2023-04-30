
<!DOCTYPE html>
<html lang="es">

<head>

    <title>

    <?php   echo isset($title) ? $title : '' ?>
            
                
        
    </title>


    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL?>favicon.png" />

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="<?php echo BASE_URL?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="<?php echo BASE_URL?>assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL?>assets/css/dark-style.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL?>assets/css/transparent-style.css" rel="stylesheet">
    <link href="<?php echo BASE_URL?>assets/css/skin-modes.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL?>assets/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL?>assets/plugins/summer/summernote.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!--- FONT-ICONS CSS -->
    <link href="<?php echo BASE_URL?>/assets/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="<?php echo BASE_URL?>/assets/colors/color1.css" />
        <?php $this->loadView("scripts_css",$viewData); ?>
    

</head>


<body class="app sidebar-mini ltr  sidenav-toggled">

    <!-- GLOBAL-LOADER 
    <div id="global-loader">
        <img src="<?php echo BASE_URL?>/assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">



            <!-- app-Header  menu superior-->
            <?php   
            
          $this->loadView("layouts/menu_superior",$viewData); 
          
          ?> 


            <?php   
            
       /*  this->load->view("layouts/estructuras/menu_superior");  
         $this->load->view("layouts/menu_superior"); */
           
           
             ?>
             <!--app-content open-->
             <div class="main-content at mt-0">
                 <div class="side-app">
 
                     <!-- CONTAINER -->
                     <div class="main-container ">
 
                         <!-- PAGE-HEADER END -->
 
                         <!-- ROW-1 OPEN -->
                         <!-- Row -->
                     
                             <?php $this->loadView($viewName, $viewData); ?>

                         
                         <!-- /Row -->
                     </div>
                     <!-- CONTAINER CLOSED -->
                 </div>
             </div>
             <!--app-content closed-->
         </div>
 
 
 
         <!-- FOOTER -->
         <footer class="footer">
             <div class="container">
                 <div class="row align-items-center flex-row-reverse">
                     <div class="col-md-12 col-sm-12 text-center">
                         Copyright © 2022 <a href="javascript:void(0)"></a>. Diseñado por <span
                             class="fa fa-job text-danger"></span>  <a href="javascript:void(0)"> Practisis </a>
                         Todos los derecho reservados.
                     </div>
                 </div>
             </div>
         </footer>
         <!-- FOOTER CLOSED -->
     </div>
 
 
 
     <!-- BACK-TO-TOP -->
     <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
      <!-- JQUERY JS -->
     <script src="<?php echo BASE_URL?>assets/js/jquery.min.js"></script>
  
     <!-- BOOTSTRAP JS -->
     <script src="<?php echo BASE_URL?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 
     <!-- SIDE-MENU JS
     <script src="<?php echo BASE_URL?>assets/plugins/sidemenu/sidemenu.js"></script>
  -->
     <!-- SIDEBAR JS 
     <script src="<?php echo BASE_URL?>assets/plugins/sidebar/sidebar.js"></script>
 -->
 

 
     <script src="<?php echo BASE_URL?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>



   
     <script src="<?php echo BASE_URL?>assets/js/themeColors.js"></script>
 
     <!-- CUSTOM JS -->
     <script src="<?php echo BASE_URL?>assets/js/custom.js"></script>
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js" integrity="sha512-5pjEAV8mgR98bRTcqwZ3An0MYSOleV04mwwYj2yw+7PBhFVf/0KcE+NEox0XrFiU5+x5t5qidmo5MgBkDD9hEw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript"> var base_url = "<?php echo BASE_URL?>";</script>

     <!-- Sticky js -->
     <script src="<?php echo BASE_URL?>assets/js/sticky.js"></script>

     <?php $this->loadView("scripts_js",$viewData); ?>

 
     <script>
        $('.dropdown-toggle').dropdown()

function mostrar_notificacion(id){


            $("#s_cuerpo_notificacion").text('');
            $("#myModalListaNotificaciones").modal('hide');



            $.ajax({

            url:" <?php echo BASE_URL?>?url=ajax/Consultas",
            type: 'GET',
            dataType: 'JSON',
            data: {
            id:id,
            accion:'obtener_notificacion'
            },
            success: function(response){
                console.log(response)
                $("#s_titulo_notificacion").text(response.notificacion.titulo);
            $("#s_cuerpo_notificacion").html(response.notificacion.cuerpo);

            $("#myModalNotificaciones").modal('show');


            }
            });
}


     </script>
 </body>
 
 
 
 </html>
