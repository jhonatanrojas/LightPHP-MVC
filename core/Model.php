<?php

namespace core;


/**
 * All models will have access to a database (if the application has one).
 */
class Model
{
    //-----------------------------------------------------------------------
    //        Attributes
    //-----------------------------------------------------------------------
    protected $db;
    protected  $db_administrador;

    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------
    public function __construct()
    {
        $this->db = new Database();
       
    }
 
  

 
    public function campos(array $array) 
    {

        return implode(",",  array_keys($array));
    }

    public function campos_update(array $array) : string
    {
        $array=array_keys($array);
        $campos="";
        $count =count($array);
        $count =   $count -1;
    foreach ($array as $key => $value) {
      
        $coma=",";
        if($count==$key)
        $coma="";

        $campos .= $value.' = ?'. $coma;
  
    }
        return $campos;
    }


    public function valores($array) : array
    {
        return  array_values($array);
        
    }



    public function asignacion($array)
    {

        $elemetos=[];
        for ($i=0; $i < count($array); $i++) { 

            $elemetos[]='?';
            
        }

        return implode(",",  array_values($elemetos));
    }

    



}
