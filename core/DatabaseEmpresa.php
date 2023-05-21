<?php
namespace core;
use  \PDO;

/**
 * Class responsible for connecting to the database.
 */
class DatabaseEmpresa extends \PDO
{
    public function __construct($host,$dbname,$dbuser,$dbpass)
    {
    
        
        parent::__construct('pgsql: host='.$host.'; dbname='.$dbname,$dbuser,$dbpass );
        $this -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
     
    }

     

}

