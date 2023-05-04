<?php

namespace controllers;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');
use core\Controller;
use controllers\ImageUploader;




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

class ImageUploaderController extends Controller
{
    private $imageUploader;

    public function __construct()
    {
        $this->imageUploader = new ImageUploader();
    }

    public function index()
    {
       
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // Responde con una respuesta vacía para las solicitudes de método OPTIONS
            http_response_code(200);
            exit();
        }
        if ($_FILES) {
            $file = $_FILES['file'];

            try {
                $uploadedFileName = $this->imageUploader->processUpload($file);
                echo json_encode(['status' => 'success', 'filename' => $uploadedFileName]);
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'No file received.']);
        }
    }
}
