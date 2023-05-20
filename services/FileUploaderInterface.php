<?php

namespace services;

interface FileUploaderInterface
{
    public function processUpload(array $file): string;
}
