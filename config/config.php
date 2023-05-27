<?php
require_once 'vendor/autoload.php';



$dotenv = Dotenv\Dotenv::createImmutable(PROJECT_ROOT.'/backend');
$dotenv->load();
define("APP_DEBUG",getenv('APP_DEBUG'));		// Local server
//define("ENVIRONMENT", "production");		// Online server
define("BASE_URL", "http://localhost/backendComparteYa/");

// Twitter
define('TWITTER_API_KEY', getenv('TWITTER_API_KEY'));
define('TWITTER_API_SECRET', getenv('TWITTER_API_SECRET'));

// Facebook
define('APP_ID_FACEBOOK', getenv('APP_ID_FACEBOOK'));
define('APP_SECRET_FACEBOOK', getenv('APP_SECRET_FACEBOOK'));

// TikTok
define('CLIENT_ID_TIKTOK', getenv('CLIENT_ID_TIKTOK'));
define('CLIENT_SECRET_TIKTOK', getenv('CLIENT_SECRET_TIKTOK'));

// Base de datos
define('DB_NAME', getenv('DB_NAME'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_CHARSET', getenv('DB_CHARSET'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));

define('TOKEN_AUTH', getenv('TOKEN_AUTH'));


