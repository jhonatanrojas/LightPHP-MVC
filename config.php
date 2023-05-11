<?php
require 'environment.php';

global $config;


$config = array();


$nombrehost = $_SERVER['HTTP_HOST'];

define("BASE_URL", "http://localhost/backendComparteYa/");

$config['TWITTER_API_KEY'] = '6LrepEEfBlaWXgGev056mwwAz';
$config['TWITTER_API_SECRET'] = 'tJWgvwkFCpLrZgPoIZHsTMLVtMsmQmi5NjfurXJQeG8zLAgJ6e';

//AOuth2 twitter
$config['TWTTER_CLIENTE_SECRET'] = '72eVSXjJ8jKbTHyWY5eAHV6rMGK-INrzmaDKPQHmHGaTxXIjZh';
$config['TWITTER_API_KEYSECRET'] = 'MUc4WmRxQ0dYY1I2cGVKQUZBb3Y6MTpjaQ';
$config['TWTTER_CALLBACK_URL'] = 'https://app.api.neptunove.site/auth_twitter';
$config['URL_CALLBACK_FACEBOOK'] = 'https://api.neptunove.site/?url=FacebookAuth/callback';

//FACRBOOK
$config['APP_ID_FACEBOOK'] = '555977850002156';
$config['APP_SECRET_FACEBOOK'] = '72b258ba2e223327c47f43049cca4b43';
$config['ACCESS_TOKEN_FACEBOOK'] = '';

//TIKTOK
$config['CLIENT_ID_TIKTOK']='awowpw3vzh0ysrr2';
$config['CLIENT_SECRET_TIKTOK']='44ddf89d49acc91c11893c487c36a06a';
$config['URL_CALLBACK_TIKTOK']='api.neptunove.site';

// Base de datos
$config['dbname'] = 'comparteYapp'; 
$config['host'] = '190.202.144.60';
$config['charset'] = 'utf8';
$config['dbuser'] = 'postgres';
$config['dbpass'] = 'chamba123';

$config['token_auth'] = 'sk-WBXV1CZiDi1EQvg8o9xeT3Bl';

$config['projectRoot'] = dirname(__DIR__);
