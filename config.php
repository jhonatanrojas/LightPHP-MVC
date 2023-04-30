<?php
require 'environment.php';

global $config;


$config = array();


$nombrehost = $_SERVER['HTTP_HOST'];
if($nombrehost == 'www.practisis.net' || $nombrehost == 'www.practisis.online' || $nombrehost == 'practisis.net' || $nombrehost == 'practisis.online' || $nombrehost == 'www.emergencia.practisis.com' || $nombrehost == 'emergencia.practisis.com'){
  $eslocalhost = false;
}else{
  $eslocalhost = true;
}

$config['TWITTER_API_KEY'] = '6LrepEEfBlaWXgGev056mwwAz';
$config['TWITTER_API_SECRET'] = 'tJWgvwkFCpLrZgPoIZHsTMLVtMsmQmi5NjfurXJQeG8zLAgJ6e';

//AOuth2
$config['TWTTER_CLIENTE_SECRET']='72eVSXjJ8jKbTHyWY5eAHV6rMGK-INrzmaDKPQHmHGaTxXIjZh';
$config['TWITTER_API_KEYSECRET'] = 'MUc4WmRxQ0dYY1I2cGVKQUZBb3Y6MTpjaQ';
$config['TWTTER_CALLBACK_URL']='http://localhost:4000/auth_twitter';


if ($eslocalhost) {
	define("BASE_URL", "http://localhost/backendComparteYa/");
	$config['dbname'] = 'email_marketing_practisis';
	$config['dbname_admin'] = 'administrador_practisis';
	$config['host'] = '127.0.0.1';
	$config['charset'] = 'utf8';
	$config['dbuser'] = 'practisis31';
	$config['dbpass'] = 'prometeo123';
} else {

	include ('/var/www/practisis.net/public/ips_enoc.php');
			

	define("BASE_URL", "https://$nombrehost./backendComparteYa/");

	$config['dbname'] = 'email_marketing_practisis';
	$config['dbname_admin'] = 'administrador_practisis';
	$config['host'] = $ip_real;
	$config['charset'] = 'utf8';
	$config['dbuser'] = 'practisis3';
	$config['dbpass'] = 'Zuleta99@251!';
}