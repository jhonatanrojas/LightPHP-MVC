<?php

namespace controllers;

use core\Controller;

use Exception;
use core\Request;
use models\User;
use models\Post;
use models\SocialAccessTokenModel;
use exceptions\ValidationException;
use services\jwt\JwtAuth;
use services\jwt\JwtDecoder;
use repositories\UserRepositoryInterface;


class AuthUserController extends Controller
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

    $request = new Request();

    if ($request->isMethod('OPTIONS')) {
      // Responde con una respuesta vacía para las solicitudes de método OPTIONS
      http_response_code(200);
      exit();
    }
    header('Content-Type: application/json');
    if ($request->input('email') && $request->input('password')) {


      $email     = $request->input('email');
      $password  = $request->input('password');

      $result_consulta = $this->userRepository->getUserById($email);


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

  public function create()
  {
    // Crear una instancia de la clase Request
    $request = new Request();

    
    try {
      $request->validate([
          'name' => 'required',
          'email' => 'required|unique:users',
          'password' => 'required',
          'birthdate' => 'required|date'
      ]);

      echo "aqui";
    } catch (ValidationException $e) {
      http_response_code(422);
      // Aquí se manejan los errores de validación
      // Por ejemplo, podrías redirigir de vuelta al formulario con los errores de validación
      
     $errors = $e->getErrors();
     responseJson( $errors);
      // Pasar los errores a la vista para mostrarlos al usuario
  }
    // Obtener los datos de la solicitud
   /* $data = [
      'nombre' => $request->input('nombre'),
      'email' => $request->input('email'),
      'pass' => password_hash($request->input('pass'), PASSWORD_BCRYPT),
      'numero_tlf' => $request->input('numero_tlf'),
      'autenticado' => true,
    ];

    // Crear una instancia del modelo de usuario
    $userModel = new User();*/
 
    // Intentar insertar el usuario en la base de datos
  /*  try {
      $userId = $userModel->insert($data);
      print($userId);
    } catch (Exception  $e) {
      echo "ocurrio un error".$e->getMessage();
   }
  */

  }

  public function update()
  {
    try {
      $userModel = new User();
      $userModel->update(['nombre' => 'john.doe@example.com'], ['id' => 1]);
    } catch (\PDOException $e) {
      // Aquí puedes manejar cualquier error que pueda ocurrir
      die($e->getMessage());
    }
  }

  public function getUser(){
    try {
      $userModel = new User();
  // $user= $userModel->where('id', 1)->first();

   //
//  $user   =$userModel->where('email', '%juan%','LIKE')->orderBy('id', 'ASC')->limit(10)->get();
  //$resultQuery= $userModel->query('SELECT * FROM users  WHERE id=? LIMIT 10',[1],true);   
  //$users = $userModel->where('id', true,'>')->orderBy('id', 'ASC')->paginate(1, 10);
  $request = new Request();
  $postModel = new Post();
  $perPage = 2; // Muestra 5 usuarios por página.
  $currentPage =   $request->query('page') ?? 1; 
  $path='/user';

  
  $pagination = $userModel->orderBy('id', 'ASC')->paginate($perPage, $currentPage, $path);
  dd($pagination );
  responseJson($pagination);

   // echo json_encode(   $pagination );

    } catch (\PDOException $e) {
      // Aquí puedes manejar cualquier error que pueda ocurrir
      die($e->getMessage());
    }
  }
}
