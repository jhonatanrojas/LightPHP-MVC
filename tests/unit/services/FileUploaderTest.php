<?php
declare(strict_types=1);

namespace tests\unit\services;


use PHPUnit\Framework\TestCase;
use services\FileUploader;

class FileUploaderTest extends TestCase
{
    private $fileUploader;

    protected function setUp(): void
    {
        $this->fileUploader = new FileUploader();
    }

    public function testProcessUploadWithInvalidExtension()
    {
        $file = [
            'name' => 'test.txt',
            'size' => 500,
            'tmp_name' => 'tmp/test.txt',
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid file extension.');

        $this->fileUploader->processUpload($file);
    }

    public function testProcessUploadWithExceededSize()
    {
        $file = [
            'name' => 'test.jpg',
            'size' => 10485761, // 10 MB + 1 byte
            'tmp_name' => 'tmp/test.jpg',
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File size exceeds the limit.');

        $this->fileUploader->processUpload($file);
    }

}
