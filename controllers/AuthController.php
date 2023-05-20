<?php

namespace controllers\SocialMedia\Auth;

use core\Controller;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');



// HABILITAR ERRORES PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



use Exception;

use  models\UserModel;
use models\SocialAccessTokenModel;
use lib\JwtAuth;

class AuthController extends Controller
{
  private $jwtAuth;
  private $socialAccessTokenModel;
  private $userModel;
  private $tokenJwt;

  function __construct()
  {
    global $config;
    $this->jwtAuth  = new JwtAuth($config['token_auth']);

    $this->socialAccessTokenModel = new SocialAccessTokenModel();
    $this->userModel = new UserModel();
  //  $authHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : null;
  $authHeader ="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2ODM2OTQwMzksImV4cCI6MTY4MzcwODQzOSwidXNlcl9pZCI6MX0.JLcvaStZeiXmSzSgzeSaQ79e57mh7w8GJp5cQgXUq1I";
    $this->tokenJwt = '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
      $this->tokenJwt = $matches[1];
    }
  }

  public function index()
  {


    $JSONData = file_get_contents("php://input");
    $dataObject = json_decode($JSONData);



    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
      // Responde con una respuesta vacía para las solicitudes de método OPTIONS
      http_response_code(200);
      exit();
    }

    if (isset($dataObject->email) && isset($dataObject->password)) {
      header('Content-Type: application/json');

      $email     = $dataObject->email;
      $password  = $dataObject->password;

      $result_consulta =  $this->userModel->getUser($email);

      if ($result_consulta) {

        if ($result_consulta['password']  == $password) {

          $token =   $this->jwtAuth->createJwt($result_consulta['id']);
          $platforms = $this->socialAccessTokenModel->get_access($result_consulta['id']);
          $result = true;

          echo json_encode(compact('result', 'token', 'platforms'));
        } else {
          echo json_encode(['result' => false, 'mensaje' => '']);
        }
      } else {
        echo json_encode(['result' => false, 'mensaje' => ' el email no  no se encuentra registrado']);
      }
    } else {

      echo json_encode(['result' => false, 'mensaje' => 'el email y la contraseña son obligatorios']);
    }


    //verificar contraseña





  }
  public function guardar_tokens()
  {
    $JSONData = file_get_contents("php://input");
    $dataObject = json_decode($JSONData);
  

    try {

 
      $decoded_jwt = $this->jwtAuth->decodeJwt($this->tokenJwt);

      if (is_string($decoded_jwt)) {
        // Error en la validación del token
        http_response_code(401); // Unauthorized
        echo $decoded_jwt;
        exit; 
      }
echo "hola";
   

    } catch (Exception $e) {

      echo json_encode(['result' => false, 'mensaje' =>  $e->getMessage(), 'sesion' => false]);
    }
  }
}
