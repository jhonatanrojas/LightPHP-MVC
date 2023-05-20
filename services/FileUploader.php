<?php

namespace services;

class FileUploader implements FileUploaderInterface
{
    private $uploadDirectory;
    private $allowedExtensions;
    private $maxFileSize;

    public function __construct(
        $uploadDirectory = null,
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov'],
        $maxFileSize = 10485760 // 10 MB
    ) {
        $this->uploadDirectory = $uploadDirectory === null ? __DIR__ . '/../uploads/' : $uploadDirectory;
        $this->allowedExtensions = $allowedExtensions;
        $this->maxFileSize = $maxFileSize;
    }

    public function processUpload(array $file): string
    {
        $filename = basename($file['name']);
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $this->allowedExtensions)) {
            throw new \Exception('Invalid file extension.');
        }

        if ($file['size'] > $this->maxFileSize) {
            throw new \Exception('File size exceeds the limit.');
        }

        $uniqueName = uniqid() . '.' . $fileExtension;
        $targetPath = $this->uploadDirectory . $uniqueName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $uniqueName;
        } else {
            throw new \Exception('Failed to move the uploaded file.');
        }
    }
}
