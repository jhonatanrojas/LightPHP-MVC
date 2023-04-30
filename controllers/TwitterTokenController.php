<?php

namespace controllers;

use core\Controller;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');


use Abraham\TwitterOAuth\TwitterOAuth;
use Exception;


class TwitterTokenController extends Controller
{

        function __construct()
        {
            
        }

    public function index()
    {
        global $config;
        $apiKey     = $config['TWITTER_API_KEY'];
        $apiSecret  = $config['TWITTER_API_SECRET'];


        $twitterClient = new TwitterOAuth($apiKey, $apiSecret);

        try {
            $requestToken = $twitterClient->oauth('oauth/request_token', ['oauth_callback' => $config['TWTTER_CALLBACK_URL']]);

            echo json_encode($requestToken);
        } catch (Exception $error) {
            echo json_encode(['message' => $error->getMessage()]);
            //       http_response_code(500);

        }
    }


    public  function callback()
    {

        global $config;
        try {
            $apiKey         = $config['TWITTER_API_KEY'];
            $apiSecret      = $config['TWITTER_API_SECRET'];
            $oauthToken     = $_POST['oauth_token'];
            $oauthVerifier  = $_POST['oauth_verifier'];
            $twitterClient  = new TwitterOAuth($apiKey, $apiSecret, $oauthToken, $oauthVerifier);
            $accessToken    = $twitterClient->oauth('oauth/access_token', ['oauth_verifier' => $oauthVerifier]);
          
            $_SESSION['screen_name']        = $accessToken['screen_name'];
            $_SESSION['oauth_token']        = $accessToken['oauth_token'];
            $_SESSION['oauth_token_secret'] = $accessToken['oauth_token_secret'];
            $accessToken['data_user']       = $this->get_data_user_twtter($_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );

            echo json_encode($accessToken);

        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode(['message' => $error->getMessage()]);
        }
    }

    public function post_twiiter()
    {

        global $config;
        try {
            $apiKey         =  $config['TWITTER_API_KEY'];
            $apiSecret      =  $config['TWITTER_API_SECRET'];
            $oauthToken     =  $_SESSION['screen_name'];
            $oauthVerifier  =  $_SESSION['oauth_token_secret'];
            $connection     =  new TwitterOAuth($apiKey, $apiSecret, $oauthToken, $oauthVerifier);

            // Obtiene el contenido del tweet enviado desde el frontend
            $status = urldecode($_POST['status']);
            // Publica el tweet
            $result = $connection->post('statuses/update', ['status' => $status]);
            // Verifica si se ha producido algún error
            if (isset($result->errors)) {
           
                echo json_encode(['error' => 'Error al publicar el tweet', 'message' => $result->errors[0]->message]);
  
                http_response_code(400);
            } else {
                http_response_code(200);
                echo json_encode(['success' => 'Tweet publicado con éxito']);
            }
        } catch (Exception $error) {
            http_response_code(400);
            echo json_encode(['message' => $error->getMessage()]);
        }
    }

    public function get_data_user_twtter( $oauthToken,$oauthVerifier){

        global $config;
        $apiKey     = $config['TWITTER_API_KEY'];
        $apiSecret  = $config['TWITTER_API_SECRET'];
   
  
        try {
            $connection  = new TwitterOAuth($apiKey, $apiSecret, $oauthToken, $oauthVerifier);
            return $connection->get('account/verify_credentials');
        } catch (Exception $error) {         
           return $error->getMessage();
        }
        
    }

}
