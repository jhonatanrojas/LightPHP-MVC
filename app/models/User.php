<?php

namespace models;

use core\Model;


/**
 * Modelo de la base de  envios masiovos
 */

use  \PDO; 

class User extends Model {
    public function __construct() {
        parent::__construct('users');
    }
}
