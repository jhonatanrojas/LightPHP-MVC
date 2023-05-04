<?php

namespace controllers;
use core\Controller;
use lib\SocialMediaPost;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class SocialMediaPostController extends Controller
{
    private $postSocialMedia;

    public function __construct()
    {
        $this->postSocialMedia = new SocialMediaPost();
    }

    public function index()
    {
        // Verifica si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Obtiene los datos de la publicación a partir de la solicitud
            $text = $_POST['text'];
            $images = !empty($_POST['images']) ? explode(',', $_POST['images']) : [];

 
            $platforms = json_decode($_POST['platforms'], true);

            // Realiza la publicación en las redes sociales
            $results = [];
            foreach ($platforms as $platform) {
                switch ($platform['platform']) {
                    case 'Facebook':
                        $response = $this->postSocialMedia->postToFacebook(
                            $text,
                            $images,
                            $platform['accessToken']
                        );
                        $results['Facebook'] = $response['result'];
                        $results['FacebookMessage'] = $response['message'];
                        $results['FacebookError'] = $response['error'];
                        break;

                    case 'Twitter':
                        $response = $this->postSocialMedia->postToTwitter(
                            $text,
                            $images,
                            $platform['accessToken'],
                            $platform['accessTokenSecret']
                        );
                        
                      //                return ['result' => true, 'message' => 'Tweet publicado correctamente',  $response];
                        $results['Twitter'] = $response['result'];
                        $results['TwitterMessage'] = $response['message'];
                        $results['TwitterError'] = $response['error'];
                        break;

                    // Añade otros casos para otras plataformas aquí
                }
            }

            // Devuelve el resultado en formato JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'results' => $results,
            ]);
        } else {
            // En caso de que no sea una solicitud POST, devuelve un error 405 (Method Not Allowed)
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        }
    }
}
