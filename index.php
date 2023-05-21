<?php
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require 'vendor/autoload.php';
require 'helpers/funciones.php';
require 'config/config.php';
require 'recursos.php';

require 'config/services.php';

$core = new core\Core($container);
$core->run();