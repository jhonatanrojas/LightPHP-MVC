<?php
session_start();


require 'helpers/funciones.php';
require 'config.php';
require 'recursos.php';



require 'vendor/autoload.php';


$core = new core\Core();
$core->run();