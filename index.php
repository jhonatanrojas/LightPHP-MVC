<?php
session_start();

require 'vendor/autoload.php';
require 'helpers/funciones.php';
require 'config.php';
require 'recursos.php';

require 'config/services.php';

$core = new core\Core($container);
$core->run();