<?php

namespace controllers\SocialMedia;


use core\Controller;
use services\ImageUploader;

 


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
            header('Content-Type: application/json');
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

    public function eliminar()
    {

        $filename = $_POST['filename'];

        unlink(__DIR__ . '/../uploads/' . $filename);


        echo json_encode(['success' => true]);
    }
}
