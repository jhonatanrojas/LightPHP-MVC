<?php

namespace core;

use exceptions\ValidationException;

class Request
{
    public $userAgent = 'Mozilla/5.0 (compatible; PHP Request library)';
    private $json;
    protected $input;
    protected $errors;
    protected $validationErrors = [];
    public function __construct()
    {
        $this->json = json_decode(file_get_contents('php://input'), true);
        $this->input = [];
        $this->errors = [];
    }


    public function getHeaders()
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        } else {
            return $this->getAllHeadersFallback();
        }
    }

    private function getAllHeadersFallback()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
    public function header($key, $default = null)
    {


        $headers = $this->getHeaders();

        return $headers[$key] ?? $default;
    }


    public function query($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public function input($key, $default = null)
    {
        if ($this->isJson()) {
            $data = $this->json;
            $segments = explode('.', $key);
            foreach ($segments as $segment) {
                if (!isset($data[$segment])) {
                    return $default;
                }
                $data = $data[$segment];
            }
            return $data;
        }

        return $_REQUEST[$key] ?? $default;
    }

    public function merge(array $input)
    {
        if ($this->isJson()) {
            $decodedInput = json_decode($input, true);
            $this->input = array_merge_recursive($this->input, $decodedInput);
        } else {
            $this->input = array_merge($this->input, $input);
        }
    }
    public function all()
    {
        if ($this->isJson()) {
            return $this->json;
        }

        return $_REQUEST ?? [];
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

        return false;
    }

    public function validate($rules, $messages = [])
{
    $validatedFields = new \stdClass();

    foreach ($rules as $field => $rule) {
        $ruleMethods = explode('|', $rule);

        $segments = explode('.', $field);

        if (isset($segments[1]) && $segments[1] === '*') {
            $arrayField = $segments[0];

            if (!is_array($this->input($arrayField))) {
                $this->addError($field, "$field debe ser un array.");
                continue;
            }

            $validatedFields->{$arrayField} = [];
            $validCount = 0;
            foreach ($this->input($arrayField) as $index => $item) {
                if (!isset($item[$segments[2]]) || empty($item[$segments[2]])) {
                    $this->addError("{$arrayField}.{$index}.{$segments[2]}", $messages["{$arrayField}.*.{$segments[2]}"] ?? "debe contener al menos un elemento válido.");
                    continue 2; 
                }

                $validCount++;
                foreach ($item as $itemField => $itemValue) {
                    $tempField = "{$arrayField}.{$index}.{$itemField}";
                    if ($this->validateField($tempField, $ruleMethods, $messages)) {
                        $validatedFields->{$arrayField}[$index] = (object) $item;
                    }
                }
            }

            if ($validCount === 0 && !isset($this->errors["{$arrayField}.*.{$segments[2]}"])) {
                $this->addError($field, "$field debe contener al menos un elemento válido.");
            }
        } else {
            if ($this->validateField($field, $ruleMethods, $messages)) {
                $segments = explode('.', $field);
                $currentField = &$validatedFields;
                foreach ($segments as $segment) {
                    if (!isset($currentField->{$segment})) {
                        $currentField->{$segment} = new \stdClass();
                    }
                    $currentField = &$currentField->{$segment};
                }
                $currentField = $this->input($field);
            }
        }
    }

    if (!empty($this->errors)) {
        $errorDetails = $this->getErrors();
        if (!empty($errorDetails['errors'])) {
            throw new ValidationException("Validation error: " . $errorDetails['message'], $errorDetails['errors']);
        }
    }

    return $validatedFields;
}

    /*public function validate($rules, $messages = [])
    {
        $validatedFields = new \stdClass();
    
        foreach ($rules as $field => $rule) {
            $ruleMethods = explode('|', $rule);
    
            $segments = explode('.', $field);
            $currentField = &$validatedFields;
            foreach ($segments as $segment) {
                if (!isset($currentField->{$segment}) && $segment !== '*') {
                    $currentField->{$segment} = new \stdClass();
                }
                if ($segment !== '*') {
                    $currentField = &$currentField->{$segment};
                }
            }
    
            if (isset($segments[1]) && $segments[1] === '*') {
                $arrayField = $segments[0];
    
                if (!is_array($this->input($arrayField))) {
                    $this->addError($field, "$field debe ser un array.");
                    continue;
                }
    
                $currentField = [];
                $validCount = 0;
                foreach ($this->input($arrayField) as $index => $item) {
                    if (!isset($item[$segments[2]]) || empty($item[$segments[2]])) {
                        $this->addError("{$arrayField}.{$index}.{$segments[2]}", $messages["{$arrayField}.*.{$segments[2]}"]);
                        continue;
                    }
    
                    $currentField[$index] = new \stdClass();
                    $validCount++;
                    foreach ($item as $itemField => $itemValue) {
                        $tempField = "{$arrayField}.{$index}.{$itemField}";
                        if ($this->validateField($tempField, $ruleMethods, $messages)) {
                            $currentField[$index]->{$itemField} = $itemValue;
                        }
                    }
                }
    
                if ($validCount === 0) {
                    $this->addError($field, "$field debe contener al menos un elemento válido.");
                }
            } else {
                if ($this->validateField($field, $ruleMethods, $messages)) {
                    $currentField = $this->input($field);
                }
            }
        }
    
        if (!empty($this->errors)) {
            $errorDetails = $this->getErrors();
            if (!empty($errorDetails['errors'])) {
                throw new ValidationException("Validation error: " . $errorDetails['message'], $errorDetails['errors']);
            }
        }
    
        return $validatedFields;
    }*/
    
    

    /*
    public function validate($rules,$messages = [])
    {
        $validatedFields = new \stdClass();

        foreach ($rules as $field => $rule) {
            $ruleMethods = explode('|', $rule);

            $segments = explode('.', $field);
            $currentField = $validatedFields;
            foreach ($segments as $segment) {
                if (!isset($currentField->{$segment})) {
                    $currentField->{$segment} = new \stdClass();
                }
                $currentField = $currentField->{$segment};
            }

         
          
            if (isset($segments[1]) && $segments[1] === '*') {
         
                // Validación de comodín para un arreglo de objetos JSON
              
            $arrayField = $segments[0];

                if (!is_array($this->input($arrayField))) {
                    continue; // El campo no es un arreglo, saltar validación
                }

                $validCount = 0;
                foreach ($this->input($arrayField) as $index => $item) {
                    $tempField = "{$arrayField}.{$index}.{$segments[2]}";
                    if ($this->validateField($tempField, $ruleMethods,$messages )) {
                        $validCount++;
                 
                        $currentField->{$index} = $item;
                    }
                }

                if ($validCount === 0) {
                    $this->addError($field, "$field debe contener al menos un elemento válido.");
                }
            } else {
               
                // Validación regular para un campo no anidado
                $this->validateField($field, $ruleMethods,$messages);
                $currentField = $this->input($field);
            }
        }

        if (!empty($this->errors)) {
            $errorDetails = $this->getErrors();
            if (!empty($errorDetails['errors'])) {
                throw new ValidationException("Validation error: " . $errorDetails['message'], $errorDetails['errors']);
            }
        }

        return $validatedFields;
    }*/

    private function validateField($field, $ruleMethods,$messages = [])
    {
        foreach ($ruleMethods as $method) {
         

            if (strpos($method, ':') !== false) {
                [$method, $parameter] = explode(':', $method);
                if (method_exists($this, $method)) {
              
                    $this->{$method}($field, $parameter,$messages[$field.'.'.$method] ?? null);
                }
            } else {
                if (method_exists($this, $method)) {
                   
                    $this->{$method}($field,$messages[$field.'.'.$method] ?? null);
                }
            }
        }

        return empty($this->errors[$field]);
    }



    protected function addError($field, $error, $customMessage = null)
    {
        $errorMessage = $customMessage ?? $error;
        $this->errors[$field][] = $errorMessage;
    }

   
    public function getErrors()
    {
        $errors = [];
        foreach ($this->errors as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors;
        }

        $errorCount = array_reduce($errors, function ($carry, $item) {
            return $carry;
        }, 0);

        $message = $errorCount > 1 ? "Hay $errorCount errores." : "Hay $errorCount error.";

        return [
            "result" => false,
            "message" => $message,
            "errors" => $errors
        ];
    }
    protected function nullable($field)
    {
             return;
    }
    protected function required($field, $customMessage = null)
    {
        if (empty($this->input($field))) {
            $this->errors[$field] = $customMessage ?? "El campo $field es requerido.";
        }
    }

    protected function max($field, $value, $customMessage = null)
    {
        if (strlen($this->input($field)) > $value) {
            $this->errors[$field][] =  $customMessage ?? "$field debe tener menos de $value caracteres.";
        }
    }

    protected function unique($field, $table, $customMessage = null)
    {
        if (!$this->input($field)) {

            return;
        }
        $db =  Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM {$table} WHERE {$field} = ? LIMIT 1");
        $stmt->execute([$this->input($field)]);

        $result = $stmt->fetch();

        // Si existe, añade un error a la lista de errores
        if ($result) {
            $this->errors[$field][] =  $customMessage ?? "{$field} ya existe en {$table}.";
        }
    }


    protected function number($field,$customMessage =null)
    {
        if (!$this->input($field)) {

            return;
        }

        if (!is_numeric($this->input($field))) {
            $this->errors[$field] = $customMessage ??  "$field debe ser un número.";
        }
    }

    protected function date($field,$customMessage = null )
    {
        if (!$this->input($field)) {
            return;
        }
    
        $dateFormats = ['Y-m-d H:i:s', 'Y-m-d'];
    
        foreach ($dateFormats as $format) {
            $date = \DateTime::createFromFormat($format, $this->input($field));
            if ($date !== false && $date->format($format) === $this->input($field)) {
                return;
            }
        }
    
        $this->errors[$field] = $customMessage ??  "$field debe ser una fecha válida con el formato AAAA-MM-DD o AAAA-MM-DD HH:MM:SS.";
    }

    protected function boolean($field, $customMessage = null)
    {
        $value = $this->input($field);
        if ($value !== true && $value !== false && $value !== 0 && $value !== 1 && 
            ($value !== null && strtolower($value) !== 'true') && 
            ($value !== null && strtolower($value) !== 'false')) {
            $this->errors[$field] = $customMessage ?? "$field debe ser booleano (true o false).";
        }
    }
    
    
}
