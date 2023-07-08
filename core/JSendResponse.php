<?php
namespace core;
class JSendResponse
{
    public static function success($data = null)
    {
        header('Content-Type: application/json');
        $response = ['status' => 'success'];
        if ($data !== null) {
            $response['data'] = $data;
        }

        return json_encode($response);
    }

    
    public static function data($data)
    {
        header('Content-Type: application/json');
     
        return json_encode($data);
    }

    public static function successPaginate($data = null)
    {
        header('Content-Type: application/json');
        $response = ['status' => 'success'];
        if ($data !== null) {
            $response[] = $data;
        }

        return json_encode($response);
    }

    public static function fail($message,$code=422,$errors='')
    {
        header('Content-Type: application/json');
        if ($code !== null) {
            http_response_code($code);
    
        }
        return json_encode([
            'status' => 'fail',
            'message' => $message,
            'errors' =>$errors
        ]);
    }

    public static function error($message, $code = null, $data = null)
    {
        $response = [
            'status' => 'error',
            'message' => $message
        ];

        if ($code !== null) {
            http_response_code($code);
            $response['code'] = $code;
        }

        if ($data !== null) {
            $response['data'] = $data;
        }

        return json_encode($response);
    }
}
