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
    protected $limit = null;
    protected $lastInsertId;
    protected $autoUpdateTimestamp = false;
    protected $updated_at = 'updated_at';
    protected $conditions = [];
    protected $result_pdo;
    protected $whereConditions = [];
    protected $lastQuery;
    protected $lastValues;
    protected $orderByConditions = [];
    protected $selectColumns = '*';
    protected $joins = [];
    protected $array_result = true;
    protected $primaryKey = 'id';
    protected $offset =null;

    //-----------------------------------------------------------------------
    //        Constructor
    //-----------------------------------------------------------------------

    public function __construct()
    {
        $this->db =  Database::getInstance();



        // Obtiene el nombre de la clase que está extendiendo Model
        $className = (new \ReflectionClass($this))->getShortName();

        // Convierte el primer carácter a minúscula y añade 's' al final

        $this->table =   $this->table ??  strtolower($className) . 's';

        if ($this->array_result)
            $this->result_pdo = PDO::FETCH_ASSOC;
        else
            $this->result_pdo = PDO::FETCH_OBJ;
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
        $valores = [];
        foreach ($array as $condicion) {
            if (is_array($condicion)) {
                $valores[] = $condicion[1];
            } else {
                $valores[] = $condicion;
            }
        }
        return $valores;
    }




    public function asignacion($array)
    {

        $elemetos = [];
        for ($i = 0; $i < count($array); $i++) {

            $elemetos[] = '?';
        }

        return implode(",",  array_values($elemetos));
    }




    // Código existente...

    public function insert(array $data)
    {
        // Comprobar si el campo "updated_at" debe ser establecido automáticamente
        if ($this->autoUpdateTimestamp) {
            $data[$this->updated_at] = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO " . $this->table . "(" . $this->campos($data) . ") VALUES(" . $this->asignacion($data) . ")";
        try {
            $stmt = $this->db->prepare($sql);
            $this->lastQuery = $sql;
            if ($stmt->execute($this->valores($data))) {
                return $this->db->lastInsertId();
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new  \Exception('Error al ejecutar la consulta: ' . $e->getMessage());
        }
    }




    public function updateById($id, array $data)
    {

        $sql = "UPDATE " . $this->table . " SET " . $this->campos_update($data) . " WHERE id = " . intval($id);
        $stmt = $this->db->prepare($sql);
        $this->lastQuery = $sql;

        return $stmt->execute($this->valores($data));
    }

    public function delete()
    {
        $whereSQL = '';
        $params = [];
        if (empty($this->whereConditions)) {
            throw new \Exception("EL Metodo Where es obligatorio para eliminar");
        }
        foreach ($this->whereConditions as $condition) {
            if ($whereSQL !== '') {
                $whereSQL .= ' AND ';
            }

            $whereSQL .= $condition[0] . ' ' . $condition[2] . ' ?';
            $params[] = $condition[1];
        }

        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE $whereSQL");

        try {
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            // aqui puedes manejar los errores como prefieras
            $e->getMessage();
            return false;
        }
    }

    public function update(array $data, array $conditions)
    {
        if ($this->autoUpdateTimestamp) {
            $data[$this->updated_at] = date('Y-m-d H:i:s');
        }

        if (empty($conditions)) {
            throw new \Exception("Las condiciones son requeridas");
        }

        $sql = "UPDATE " . $this->table . " SET " . $this->campos_update($data) . " WHERE " . $this->formatConditions($conditions);
        $stmt = $this->db->prepare($sql);
        $this->lastQuery = $sql;
        // Combina los valores de los datos y las condiciones en un solo array
        $values = array_merge($this->valores($data), $this->valores($conditions));

        return $stmt->execute($values);
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
        $this->lastQuery = $sql;
        $stmt->execute([$id]);
        return $stmt->fetch($this->result_pdo);
    }

    public function where($field, $value, $operator = '=')
    {
        $this->whereConditions[] = [$field, $value, $operator];
        return $this;
    }

    public function first()
    {
        $whereClause = $this->buildWhereClause();
        $sql = "SELECT * FROM " . $this->table;
        if (!empty($whereClause)) {
            $sql .= " WHERE " . $whereClause;
        }
        $sql .= " LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $this->lastQuery = $sql;
        $stmt->execute($this->valores($this->whereConditions));
        return $stmt->fetch($this->result_pdo);
    }

    protected function buildWhereClause()
    {
        $whereClause = '';
        foreach ($this->whereConditions as $condition) {
            list($field, $value, $operator) = $condition;
            if (!empty($whereClause)) {
                $whereClause .= ' AND ';
            }
            $whereClause .= "$field $operator ?";
        }
        return $whereClause;
    }



    public function limit(int $limit, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    public function select(...$columns)
    {
        $this->selectColumns = implode(', ', $columns);
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->selectColumns} FROM " . $this->table;

        $values = [];



        if (!empty($this->joins)) {
            $sql .= $this->buildJoins();
        }
        if (!empty($this->whereConditions)) {
            $values = $this->valores($this->whereConditions);
            $whereClause = $this->buildWhereClause();
            $sql .= " WHERE " . $whereClause;
        }

        // Agregar condiciones ORDER BY a la consulta, si existen
        if (!empty($this->orderByConditions)) {
            $sql .= " ORDER BY ";
            foreach ($this->orderByConditions as $condition) {
                list($field, $direction) = $condition;
                $sql .= "$field $direction, ";
            }
            $sql = rtrim($sql, ", "); // Elimina la última coma sobrante
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT " . (int)$this->limit;
            if ($this->offset !== null) {
                $sql .= " OFFSET " . (int)$this->offset;
            }
        }

        $stmt = $this->db->prepare($sql);
        $this->lastQuery = $sql;
        $stmt->execute($values);
        return $stmt->fetchAll($this->result_pdo);
    }



    public function query(string $sql, array $params = [], bool $singleResult = false)
    {

        $stmt = $this->db->prepare($sql);
        $this->lastQuery = $sql;
        if (empty($params)) {
            $stmt->execute();
        } else {
            $stmt->execute($params);
        }


        if ($singleResult) {
            return $stmt->fetch($this->result_pdo);
        }

        return $stmt->fetchAll($this->result_pdo);
    }
    public function last_query()
    {
        return $this->lastQuery;
    }
    public function orderBy($field, $direction = 'ASC')
    {
        $this->orderByConditions[] = [$field, $direction];
        return $this; // Esto permite encadenar llamadas de método
    }

    public function paginate($perPage, $currentPage, $path='/')
    {

        
      
        $path= $_ENV['URL_BASE'].$path;

        $total = $this->count();
        $lastPage = ceil($total / $perPage);
        $offset = ($currentPage - 1) * $perPage;
    
        $this->limit($perPage,$offset);
        $data = $this->get();
    
        $prevPage = $currentPage - 1 > 0 ? $currentPage - 1 : null;
        $nextPage = $currentPage + 1 <= $lastPage ? $currentPage + 1 : null;
    
        return [
            "data" => $data,
            "links" => [
                "first" => "{$path}?page=1",
                "last" => "{$path}?page={$lastPage}",
                "prev" => $prevPage ? "{$path}?page={$prevPage}" : null,
                "next" => $nextPage ? "{$path}?page={$nextPage}" : null
            ],
            "meta" => [
                "current_page" => $currentPage,
                "from" => $offset + 1,
                "last_page" => $lastPage,
                "path" => $path,
                "per_page" => $perPage,
                "to" => $offset + $perPage,
                "total" => $total
            ]
        ];
    }
    

    protected function buildJoins()
    {
        return array_reduce($this->joins, function ($sql, $join) {
            if (!is_array($join) || !isset($join['table'], $join['first'], $join['operator'], $join['second'])) {
                return $sql; // saltar este elemento si no es una matriz válida
            }
            $sql .= " JOIN {$join['table']} ON {$join['first']} {$join['operator']} {$join['second']}";
            return $sql;
        }, '');
    }

    public function join($table, $first, $operator, $second)
    {
        $this->joins[] = compact('table', 'first', 'operator', 'second');
        return $this;
    }
    public function leftJoin(string $table, string $first, string $operator, string $second)
    {
        $this->joins[] = 'LEFT JOIN ' . $table . ' ON ' . $first . ' ' . $operator . ' ' . $second;
        return $this;
    }

    public function rightJoin(string $table, string $first, string $operator, string $second)
    {
        $this->joins[] = 'RIGHT JOIN ' . $table . ' ON ' . $first . ' ' . $operator . ' ' . $second;
        return $this;
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        $values = []; // Definimos $values aquí para asegurar que siempre está definida
    
        if (!empty($this->whereConditions)) {
            $values = $this->valores($this->whereConditions);
            $conditions = [];
            foreach ($this->whereConditions as $condition) {
                list($field, $value, $operator) = $condition;
                $conditions[] = "$field $operator ?";
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
    
        if (!empty($this->joins)) {
            $sql .= $this->buildJoins();
        }
    
        $this->lastQuery = $sql;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Regresa el número de registros
        return intval($result['count']);
    }
    
}
