<?php
namespace core;
use  \PDO;

/**
 * Class responsible for connecting to the database.
 */
class Database extends \PDO
{
    public function __construct()
    {
        $dbHost = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $dbUser = $_ENV['DB_USER'];
        $dbPass = $_ENV['DB_PASS'];
        	
			  try {
            parent::__construct('pgsql: host='.$dbHost.'; dbname='.$dbName, $dbUser, $dbPass);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
        } catch ( \PDOException $e) {
            throw new  \Exception('Error de conexión a la base de datos: ' . $e->getMessage());
        }   
     
    } 

   
    



}

