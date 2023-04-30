<?php

namespace models;

use core\Model;


/**
 * Modelo de la base de  envios masiovos
 */

use  \PDO;
use models\ClientesModel;
class EmailMaivosModel extends Model
{
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();

    }

    public function obtener_campanas_id($id)

    {

   
        $sql = "SELECT * FROM email_masivos  WHERE id=$id
     
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        return 0;
    }
    public function obtener_campanas($estado = false,$LIMIT=false)

    {
        $query_limit='';
        if($LIMIT)
        $query_limit='LIMIT 25';

        $WHERE = " WHERE email_masivos.estado <> 0";
        if ($estado !== false) {
            $WHERE = " WHERE  email_masivos.estado = $estado";
        }
        $sql = "SELECT email_masivos.*, estado_envios_email.estado as estatus FROM email_masivos 
        INNER JOIN estado_envios_email ON email_masivos.estado=estado_envios_email.id
        $WHERE
         ORDER BY fecha_creacion DESC  $query_limit
     
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $result;

    }

    public function registrar($datos)
    {

        $campos = $this->campos($datos);
        $values = $this->valores($datos);
        $asignacion = $this->asignacion($values);


        $sql = "INSERT INTO email_masivos ($campos) VALUES ($asignacion)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }


    public  function total_c_enviados($id_campana)
    {
        $sql = " SELECT count(id_cliente) as total FROM email_masivos_clientes
         WHERE id_campana=$id_campana AND estatus_envio='true'
         
         ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }
        return 0;
    }
    public  function total_c_programados($id_campana)
    {
        $sql = " SELECT count(id_cliente) as total FROM email_masivos_clientes
         WHERE id_campana=$id_campana 
         
         ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }
        return 0;
    }
    public function registrar_envio_cliente($datos)
    {

        $campos = $this->campos($datos);
        $values = $this->valores($datos);
        $asignacion = $this->asignacion($values);


        $sql = "INSERT INTO email_masivos_clientes ($campos) VALUES ($asignacion)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }


    public function actualizar($datos, $id)
    {

        $campos = $this->campos_update($datos);
        $values = $this->valores($datos);


        $sql = "UPDATE email_masivos SET  $campos WHERE id=$id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }



    public function actualizar_estatus($datos, $id, $id_plantilla)
    {

        $campos = $this->campos_update($datos);
        $values = $this->valores($datos);


        $sql = "UPDATE email_masivos_clientes SET  $campos WHERE id_cliente=$id
        AND id_campana=$id_plantilla
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    public  function obtener_clientes($limit=100 ,$fecha)
    {
        $sql = " SELECT asunto,plantilla,id_cliente,  email_masivos.id as id_plantilla
        FROM email_masivos_clientes
       
        INNER JOIN email_masivos ON email_masivos.id = email_masivos_clientes.id_campana
         WHERE estatus_envio='false'
         AND email_masivos.estado=2
         AND email_masivos.fecha_envio <='$fecha'
        order by email_masivos_clientes.id_campana ASC   LIMIT $limit
         ";


        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          return  $stmt->fetchAll(PDO::FETCH_ASSOC);

      
        }
        return [];
    }

    public function obtener_total_enviados($fecha_envio)
    {

        $sql = "SELECT count(id) as total
        FROM public.email_masivos_clientes where estatus_envio='true'
         and fecha_envio='$fecha_envio'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null; //
            return $row['total'];
        }
        return 0;
    }

    public function verificar_si_existe($id_cliente,$id_campana){
        $sql="SELECT id_cliente
        FROM email_masivos_clientes WHERE id_cliente=$id_cliente  and id_campana=$id_campana";
          $stmt = $this->db->prepare($sql);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
      
         
              return true;
          }
          return false;
        }
    public function id_cliente_programados($id_campana){
        $sql="SELECT id_cliente 
        FROM email_masivos_clientes WHERE id_campana=$id_campana ";
          $stmt = $this->db->prepare($sql);
          $stmt->execute();
          if ($stmt->rowCount() > 0) {
              $row =   $stmt->fetchAll(PDO::FETCH_ASSOC);
              $stmt = null; //
         
              return $row;
          }
          return [];
      
    }
    public function total_pendientes_campana($id_campana)
    {

        $sql = "SELECT count(email_masivos_clientes.id) as total
        FROM  email_masivos_clientes  
        INNER JOIN email_masivos ON email_masivos.id=id_campana 
        WHERE estatus_envio='false'
    and id_campana=$id_campana";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row =   $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null; //
            return $row['total'];
        }
        return 0;
    }
}
