<?php

namespace models;

use core\Model;


/**
 * Modelo de la base de  envios masiovos
 */

use  \PDO; 

class UserModel extends Model
{
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();

    }

    public function  get_user($username)

    {
 
   
        $sql = "SELECT * FROM users  WHERE username=?
     
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        return 0;
    }
  
    public function insertar(){

        $sql="insert into users (username,password) values ('jhonatan@practisis.com','12345678') ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

}
