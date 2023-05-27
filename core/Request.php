<?php

namespace core;

class Request
{
    private $json;

    public function __construct()
    {
        $this->json = json_decode(file_get_contents('php://input'), true);
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

    public function validate(array $rules)
    {
        $errors = [];

        foreach ($rules as $key => $rule) {
            $value = $this->input($key);

            if ($rule === 'required' && empty($value)) {
                $errors[$key] = 'The ' . $key . ' field is required.';
            }
        }

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }
    }
}
