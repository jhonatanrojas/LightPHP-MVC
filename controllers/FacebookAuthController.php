<?php

namespace controllers;

use core\Controller;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');
// HABILITAR ERRORES PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Abraham\TwitterOAuth\TwitterOAuth;
use Facebook\Facebook;
use Exception;


class FacebookAuthController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
        global $config;
        $app_id     = $config['APP_ID_FACEBOOK'];
        $app_secret  = $config['APP_SECRET_FACEBOOK'];

        $default_graph_version  = 'V16.0';

        $fb = new Facebook([
            'app_id' =>  $app_id,
            'app_secret' =>       $app_secret,
            'default_graph_version' => 'v16.0',
            //'default_access_token' => '{access-token}', // optional
        ]);


        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me');
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $me = $response->getGraphUser();
        echo 'Logged in as ' . $me->getName();
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
            $accessToken['data_user']       = $this->get_data_user_twtter($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

            echo json_encode($accessToken);
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode(['message' => $error->getMessage()]);
        }
    }


    public function get_data_user_twtter($oauthToken, $oauthVerifier)
    {

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
