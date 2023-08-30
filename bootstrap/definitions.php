<?php

use Psr\Container\ContainerInterface, 

    Slim\App, 
    Slim\Factory\AppFactory;

return [

    'config' => function () {

        $aConfig = [
            'app' => require __DIR__ . '/../config/app.php',
            'exception' => require __DIR__ . '/../config/exception.php',
            'db' => require __DIR__ . '/../config/db.php',
            'view' => require __DIR__ . '/../config/view.php',
            'whoops' => require __DIR__ . '/../config/whoops.php'
        ];

        return $aConfig;

    },

    App::class => function (ContainerInterface $ciContainer) {

        AppFactory::setContainer($ciContainer);

        return AppFactory::create();

    }

];
