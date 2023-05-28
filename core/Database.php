<?php
namespace core;
use  \PDO;

/**
 * Class responsible for connecting to the database.
 */
class Database extends \PDO {
    private static $instance = null;

    public function __construct() {
        $dbHost = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $dbUser = $_ENV['DB_USER'];
        $dbPass = $_ENV['DB_PASS'];

        parent::__construct('pgsql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Deshabilitar la clonación de objetos
    private function __clone() { }
}





