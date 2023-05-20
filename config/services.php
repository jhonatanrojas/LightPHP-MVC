<?php
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

// Si quieres usar la compilación de contenedor para mejorar el rendimiento
// $containerBuilder->enableCompilation(__DIR__ . '/var/cache');

$containerBuilder->addDefinitions([
    // Aquí es donde defines tus dependencias
    'repositories\socialMedia\SocialAccessTokenRepositoryInterface' => function () {
        return new \repositories\socialMedia\SocialAccessTokenRepository(new \models\SocialAccessTokenModel());
    },
    'services\FileUploaderInterface' => function () {
        return new \services\FileUploader();
    },
    
    
]);

$container = $containerBuilder->build();
