<?php

session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require 'vendor/autoload.php';
require "vendor/larapack/dd/src/helper.php";
require 'app/helpers/funciones.php';
require 'viteconfig.php';

require 'config/config.php';
require 'app/views/recursos.php';

require 'config/services.php';





$core = new core\Core($container);

$core->run();

