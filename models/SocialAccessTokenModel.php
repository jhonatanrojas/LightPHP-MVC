<?php

namespace models;

use core\Model;


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
        parent::__construct();

    }

    public function  get_access($id_user)

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

    public function insertar($id_user, $id_user_red, $red_social, $user_name, $img_perfil, $access_token){

        $sql="insert into socials_access_tokens (id_user, id_user_red, red_social, user_name, img_perfil, access_token) values (?,?,?,?,?,?) ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user, $id_user_red, $red_social, $user_name, $img_perfil, $access_token]);
    }
  

}