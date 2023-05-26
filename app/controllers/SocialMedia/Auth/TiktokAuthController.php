<?php

namespace controllers\SocialMedia\Auth;

use core\Controller;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');
// HABILITAR ERRORES PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use gimucco\TikTokLoginKit\Connector;
use Exception;


class TiktokAuthController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
       
        //
        $client_id      =  $_ENV['CLIENT_ID_TIKTOK'];
        $client_secret  =  $_ENV['CLIENT_SECRET_TIKTOK'];
        $redirect_uri   =  $_ENV['URL_CALLBACK_TIKTOK'];
        
        $_TK = new Connector($client_id, $client_secret, $redirect_uri);

        echo '<a href="'.$_TK->getRedirect().'">Log in with TikTok</a>';

     

   
        //echo '<a href="' . htmlspecialchars($loginUrl) . '">Iniciar sesión con Facebook</a>';

      //  echo json_encode(['url' => $loginUrl]);
    }


    public  function callback()
    {


        $app_id     =  $_ENV['APP_ID_FACEBOOK']; 
        $app_secret  =  $_ENV['APP_SECRET_FACEBOOK'];



        $fb = new Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v16.0',
        ]);

        $redirectUrl =  $_ENV['URL_CALLBACK_FACEBOOK'];
        $helper = $fb->getRedirectLoginHelper();
    
        try {
            $accessToken = $helper->getAccessToken($redirectUrl);
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in.
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // Optional: Get a long-lived access token.
        $oAuth2Client = $fb->getOAuth2Client();
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        echo '<h3>Long-lived Access Token</h3>';
        var_dump($longLivedAccessToken->getValue());
    }


    public function get_data_user_twtter($oauthToken, $oauthVerifier)
    {

        $apiKey     =  $_ENV['TWITTER_API_KEY'];
        $apiSecret  =  $_ENV['TWITTER_API_SECRET'];


        try {
            $connection  = new TwitterOAuth($apiKey, $apiSecret, $oauthToken, $oauthVerifier);
            return $connection->get('account/verify_credentials');
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }
}
