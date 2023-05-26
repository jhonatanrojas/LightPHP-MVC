<?php

namespace controllers;

use core\Controller;

use Exception;

use models\SocialAccessTokenModel;
use services\jwt\JwtAuth;
use services\jwt\JwtDecoder;
use repositories\UserRepositoryInterface;


class AuthController extends Controller
{
  public $jwtAuth;
  public $socialAccessTokenModel;
  public $tokenJwt;
  public $userRepository;


  function __construct(UserRepositoryInterface $userRepository)
  {
     $this->jwtAuth  = new JwtAuth($_ENV['SECRET_KEY_JWT']);

    $this->socialAccessTokenModel = new SocialAccessTokenModel();
    $this->userRepository = $userRepository;
 
  }

  public function index()
  {



    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
      // Responde con una respuesta vacía para las solicitudes de método OPTIONS
      http_response_code(200);
      exit();
    }
       header('Content-Type: application/json');
    if (isset($_POST['email'], $_POST['password'])) {
     

      $email     = $_POST['email'];
      $password  = $_POST['password'];

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
        echo json_encode(['result' => false, 'mensaje' => 'el email no se encuentra registrado']);
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

      $jwtDecoder  =new JwtDecoder($this->tokenJwt);
      $decoded_jwt = $jwtDecoder->decodeJwt($this->tokenJwt);

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
