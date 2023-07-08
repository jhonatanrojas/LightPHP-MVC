<?php

namespace core;

use  \PDO;

/**
 * Class responsible for connecting to the database.
 */
class Database extends \PDO
{
    private static $instance = null;
    protected $connection;
    public function __construct()
    {
        $dbHost = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $dbUser = $_ENV['DB_USER'];
        $dbPass = $_ENV['DB_PASS'];
        try {
            parent::__construct('pgsql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            throw new  \Exception('Error a conectar a la base de datos: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public static function connectEmpresa($dbConfig)
    {
        try {
            $dbHost=$dbConfig['host'];
            $dbName=$dbConfig['db_name'];
            
           $dsn = "pgsql:host=$dbHost;dbname=$dbName";
            $connection = new PDO($dsn, $_ENV['DB_USER_EMP'], $_ENV['DB_PASS_EMP']);

            // set the PDO error mode to exception
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return  $connection;
        } catch (\PDOException $e) {
            throw new  \Exception('Error al conectar  base de datos: '.$dbConfig['db_name'] ." ". $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    // Deshabilitar la clonación de objetos
    private function __clone()
    {
    }
}
