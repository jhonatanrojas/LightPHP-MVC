<?php
namespace core;
use  \PDO;

/**
 * Class responsible for connecting to the database.
 */
class DatabaseAdmin extends \PDO
{
    public function __construct()
    {
        global $config;
        
        	
        parent::__construct('pgsql: host='.$config['host'].'; dbname='.$config['dbname_admin'],$config['dbuser'], $config['dbpass']);
        $this -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
     
    }

     

}

