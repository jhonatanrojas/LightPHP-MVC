<?php

namespace core;
use exceptions\ValidationException;

class Request
{
    private $json;
    protected $input;
    protected $errors;
    protected $validationErrors = [];
    public function __construct()
    {
        $this->json = json_decode(file_get_contents('php://input'), true);
        $this->input = $_REQUEST;
        $this->errors = [];
    }

    public function header($key, $default = null)
    {
        $headers = getallheaders();
        return $headers[$key] ?? $default;
    }

    public function query($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public function input($key, $default = null)
    {
        if ($this->isJson()) {
            return $this->json[$key] ?? $default;
        }

        return $_POST[$key] ?? $default;
    }

    public function server($key, $default = null)
    {
        return $_SERVER[$key] ?? $default;
    }

    public function isMethod(string $method)
    {
        return $this->server('REQUEST_METHOD') === strtoupper($method);
    }

    public function isJson()
    {
        $contentType = $this->header('Content-Type');

        if ($contentType !== null) {
            return strpos($contentType, 'application/json') !== false;
        }

        return false; // O realiza alguna otra acción adecuada en caso de que el valor sea nulo
    }

    public function validate($rules)
    {
        foreach ($rules as $field => $rule) {
            $ruleMethods = explode('|', $rule);
            foreach ($ruleMethods as $method) {
                if (strpos($method, ':') !== false) {
                    [$method, $parameter] = explode(':', $method);
                    if (method_exists($this, $method)) {
                        $this->{$method}($field, $parameter);
                    }
                } else {
                    if (method_exists($this, $method)) {
                        $this->{$method}($field);
                    }
                }
            }
        }

        if (!empty($this->errors)) {
            $errorDetails = $this->getErrors();
            if (!empty($errorDetails['errors'])) {
                throw new ValidationException("Validation error: " . $errorDetails['message'], $errorDetails['errors']);

            }
        }
    }


    public function getErrors()
    {
        $errors = [];
        foreach ($this->errors as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors;
        }

        $errorCount = array_reduce($errors, function ($carry, $item) {
            return $carry + count($item);
        }, 0);

        $message = $errorCount > 1 ? "Hay $errorCount errores." : "Hay $errorCount error.";

        return [
            "message" => $message,
            "errors" => $errors
        ];
    }

    protected function required($field)
    {
        if (empty($this->input[$field])) {
            $this->errors[$field][] = "$field es requerido.";
        }
    }

    protected function max($field, $value)
    {
        if (strlen($this->input[$field]) > $value) {
            $this->errors[$field][] = "$field debe tener menos de $value caracteres.";
        }
    }

    protected function unique($field, $table)
    {
        if (!isset($this->input[$field])) {

            return;
        }
        $db =  Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM {$table} WHERE {$field} = ? LIMIT 1");
        $stmt->execute([$this->input[$field]]);
    
        $result = $stmt->fetch();
    
        // Si existe, añade un error a la lista de errores
        if ($result) {
            $this->errors[$field][] = "{$field} ya existe en {$table}.";
        }
    }
    

    protected function number($field)
    {
        if (!isset($this->input[$field])) {
           
            return;
        }

        if (!is_numeric($this->input[$field])) {
            $this->errors[$field][] = "$field debe ser un número.";
        }
    }

    protected function email($field)
    {
        if (!isset($this->input[$field])) {
          
            return;
        }

        if (!filter_var($this->input[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field debe ser un correo electrónico válido.";
        }
    }

    protected function date($field)
    {
        if (!isset($this->input[$field])) {

            return;
        }
    
        $date =  \DateTime::createFromFormat('Y-m-d', $this->input[$field]);
    
        if ($date === false || array_sum($date->getLastErrors())) {
            $this->errors[$field][] = "$field debe ser una fecha válida con el formato AAAA-MM-DD.";
        }
    }
    
}
