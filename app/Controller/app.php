<?php

use Psr\Container\ContainerInterface,

    Slim\App;

return function (App $aApp) {

    $cContainer = $aApp -> getContainer();

    // BEGIN - APP CONTROLLER.

    $cContainer -> set('Home_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Controller\Home_Controller($ciContainer);

    });

    $cContainer -> set('User_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Controller\User_Controller($ciContainer);

    });

    $cContainer -> set('Pokemon_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Controller\Pokemon_Controller($ciContainer);

    });

    $cContainer -> set('Phrases_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Controller\Phrases_Controller($ciContainer);

    });

    $cContainer -> set('ViteJS_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Controller\ViteJS_Controller($ciContainer);

    });

    // END - APP CONTROLLER.

};
