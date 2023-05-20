<?php
session_start();


require 'helpers/funciones.php';
require 'config.php';
require 'recursos.php';



require 'vendor/autoload.php';
require 'config/services.php';

$core = new core\Core($container);
$core->run();