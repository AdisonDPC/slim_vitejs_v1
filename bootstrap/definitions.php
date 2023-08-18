<?php

use Psr\Container\ContainerInterface, 

    Slim\App, 
    Slim\Factory\AppFactory;

return [

    'config' => function () {

        $aConfig = [
            'app' => require __DIR__ . '/../config/app.php',
            'db' => require __DIR__ . '/../config/db.php',
            'view' => require __DIR__ . '/../config/view.php'
        ];

        return $aConfig;

    },

    App::class => function (ContainerInterface $ciContainer) {

        AppFactory::setContainer($ciContainer);

        return AppFactory::create();

    }

];
