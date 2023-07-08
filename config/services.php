<?php
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

// Si quieres usar la compilación de contenedor para mejorar el rendimiento
// $containerBuilder->enableCompilation(__DIR__ . '/var/cache');

$containerBuilder->addDefinitions([
    // Aquí es donde defines tus dependencias
  
    'domain\UserRepositoryInterface' => function () {
        return new \models\UserActiveRecordRepository(new \models\User());
    },
    'services\FileUploaderInterface' => function () {
        return new \services\FileUploader();
    },


    
    
 
]);

$container = $containerBuilder->build();
