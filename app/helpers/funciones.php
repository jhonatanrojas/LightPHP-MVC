
<?php


function recurso ($nombre_recurso) {
    global $recursos;


    if (isset($recursos[$nombre_recurso])) $recurso = $recursos[$nombre_recurso];
    else $recurso = "";

    return $recurso;
    
}
 function responseJson($data)
{
    header('Content-Type: application/json');
    return json_encode($data);
}
function verificar_request($post){


    foreach($post as $key=>$value) {

         if(!isset($_REQUEST[$value]) ||  empty($_REQUEST[$value]) ){
     
            return ['result' =>false,'value' =>$value];
            break;
         }

         return ['result' =>true,'value' =>''];
    }


     



}

function param_url ($fecha_europea, $con_horas=true) {
		
    $fecha_europea = str_replace("/", "-", $fecha_europea);
    
    if ($con_horas) {

        $fecha_sql = date("Y-m-d H:i:s", strtotime($fecha_europea));

    }
    else {

        $fecha_sql = date("Y-m-d", strtotime($fecha_europea));

    }
    
    return $fecha_sql;

}

function fecha_to_sql ($fecha_europea, $con_horas=true) {
		
    $fecha_europea = str_replace("/", "-", $fecha_europea);
    
    if ($con_horas) {

        $fecha_sql = date("Y-m-d H:i:s", strtotime($fecha_europea));

    }
    else {

        $fecha_sql = date("Y-m-d", strtotime($fecha_europea));

    }
    
    return $fecha_sql;

}
function url($name)
{

    // Aquí es donde agregas la URL base
    $baseUrl = $_ENV['URL_BASE'];
    return $baseUrl . $name;
}



