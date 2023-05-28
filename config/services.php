<?php
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

// Si quieres usar la compilación de contenedor para mejorar el rendimiento
// $containerBuilder->enableCompilation(__DIR__ . '/var/cache');

$containerBuilder->addDefinitions([
    // Aquí es donde defines tus dependencias
   /* 'repositories\socialMedia\SocialAccessTokenRepositoryInterface' => function () {
        return new \repositories\socialMedia\SocialAccessTokenRepository(new \models\SocialAccessTokenModel());
    },
    'repositories\UserRepositoryInterface' => function () {
        return new \repositories\UserRepository(new \models\User());
    },
    'services\FileUploaderInterface' => function () {
        return new \services\FileUploader();
    },*/


    
    
 
]);

$container = $containerBuilder->build();
