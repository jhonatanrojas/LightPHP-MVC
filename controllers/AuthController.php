<?php

namespace controllers;

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

use models\SocialAccessTokenModel;
use services\JwtAuth;
use repositories\UserRepositoryInterface;

class AuthController extends Controller
{
  private $jwtAuth;
  private $socialAccessTokenModel;
  private $tokenJwt;
  private $userRepository;

  function __construct(UserRepositoryInterface $userRepository)
  {
   
    $this->jwtAuth  = new JwtAuth( $_ENV['SECRET_KEY_JWT']);

    $this->socialAccessTokenModel = new SocialAccessTokenModel();
    $this->userRepository = $userRepository;
 
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

      $result_consulta = $this->userRepository->getUser($email);


      if ($result_consulta) {

        if ($result_consulta['password']  == $password) {

          $token =   $this->jwtAuth->createJwt($result_consulta['id']);
          $platforms = $this->socialAccessTokenModel->getAccess($result_consulta['id']);
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
