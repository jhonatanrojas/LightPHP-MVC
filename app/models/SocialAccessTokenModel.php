<?php

namespace models;

use core\Model;
use core\Database;

/**
 * Modelo de la base de  envios masiovos
 */

use  \PDO;

class SocialAccessTokenModel extends Model
{
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct()
    {
       

    }

    public function  getAccess(int $id_user) : array

    {
 
   
        $sql = "SELECT * FROM socials_access_tokens  WHERE id_user=?
     
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user]);
        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }
        return [];
    }

    public function insert(array $datos)
    {

        $campos = $this->campos($datos);
        $values = $this->valores($datos);
        $asignacion = $this->asignacion($values);


        $sql = "INSERT INTO socials_access_tokens  ($campos) VALUES ($asignacion)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }
  

}