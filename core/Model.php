<?php

namespace core;
use  \PDO; 

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
    protected $table;
    protected $lastInsertId;
    protected $autoUpdateTimestamp = false;
    protected $updated_at = 'updated_at';
    protected $conditions = [];
    protected $limit = null;
    protected $result_pdo;
    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------

    public function __construct(string $table =null, $result_sql='array')
    {
        $this->db = new Database();
        $this->table = $table;
        if($result_sql=='array')    
        $this->result_pdo=PDO::FETCH_ASSOC;
        else
        $this->result_pdo=PDO::FETCH_OBJ;
    }




    public function campos(array $array)
    {

        return implode(",",  array_keys($array));
    }

    public function campos_update(array $array): string
    {
        $array = array_keys($array);
        $campos = "";
        $count = count($array);
        $count =   $count - 1;
        foreach ($array as $key => $value) {

            $coma = ",";
            if ($count == $key)
                $coma = "";

            $campos .= $value . ' = ?' . $coma;
        }
        return $campos;
    }


    public function valores($array): array
    {
        return  array_values($array);
    }



    public function asignacion($array)
    {

        $elemetos = [];
        for ($i = 0; $i < count($array); $i++) {

            $elemetos[] = '?';
        }

        return implode(",",  array_values($elemetos));
    }




    public function insert(array $data)
    {

        $sql = "INSERT INTO " . $this->table . " (" . $this->campos($data) . ") VALUES (" . $this->asignacion($data) . ") RETURNING id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->valores($data));
        $this->lastInsertId = $stmt->fetchColumn();
        return $this;
    }

    public function returning($column)
    {

        if (!empty($this->lastInsertId)) {
            $sql = "SELECT $column FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$this->lastInsertId]);
            return $stmt->fetchColumn();
        } else {
            throw new \Exception("No insert operation was made previously.");
        }
    }

    public function updateById($id, array $data)
    {

        $sql = "UPDATE " . $this->table . " SET " . $this->campos_update($data) . " WHERE id = " . intval($id);
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($this->valores($data));
    }

  

    public function update(array $data, array $conditions)
    {
        if ($this->autoUpdateTimestamp) {
            $data[$this->updated_at] = date('Y-m-d H:i:s'); 
        }

        if(empty($conditions)){
            throw new \Exception("Las condiciones son requridas");
        }
        $sql = "UPDATE " . $this->table . " SET " . $this->campos_update($data) . " WHERE " . $this->formatConditions($conditions);
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($this->valores($data));
    }

    protected function formatConditions(array $conditions)
    {
        $formattedConditions = [];
        foreach ($conditions as $field => $value) {
            $formattedConditions[] = "$field = ?";
        }
        return implode(' AND ', $formattedConditions);
    }

    public function getById($id)
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch($this->result_pdo);
    }

    public function where($field, $value) {
        $this->conditions[$field] = $value;
        return $this;
    }
    public function first() {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->formatConditions($this->conditions) . " LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->valores($this->conditions));
        return $stmt->fetch($this->result_pdo);
    }

    


    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function get() {
        $sql = "SELECT * FROM " . $this->table;
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . $this->formatConditions($this->conditions);
        }
        
        if ($this->limit !== null) {
            $sql .= " LIMIT " . (int)$this->limit;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->valores($this->conditions));
        return $stmt->fetchAll($this->result_pdo);
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll($this->result_pdo);
    }
}
