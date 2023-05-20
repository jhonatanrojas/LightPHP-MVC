<?php

namespace controllers;

use services\FileUploaderInterface;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Credentials: true');

class FileUploaderController
{
    private $fileUploader;

    public function __construct(FileUploaderInterface $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // Responde con una respuesta vacía para las solicitudes de método OPTIONS
            http_response_code(200);
            exit();
        }
        if ($_FILES) {

            $file = $_FILES['file'];

            try {
                header('Content-Type: application/json');
                $uploadedFileName = $this->processUpload($file);
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
    public function processUpload(array $file): string
    {
        // Lógica adicional si es necesario
        return $this->fileUploader->processUpload($file);
    }

    public function eliminar()
    {

        $filename = $_POST['filename'];

        unlink(__DIR__ . '/../uploads/' . $filename);


        echo json_encode(['success' => true]);
    }
}
