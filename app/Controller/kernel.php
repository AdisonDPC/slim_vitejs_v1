<?php

use 
    Psr\Container\ContainerInterface,

    Slim\App, 
    
    App\Controller\Home\Home_Controller,
    App\Controller\User\User_Controller,
    App\Controller\Pokemon\Pokemon_Controller,
    App\Controller\Phrases\Phrases_Controller,
    App\Controller\ViteJS\ViteJS_Controller;

return function (App $aApp) {

    $cContainer = $aApp -> getContainer();

    // BEGIN - APP CONTROLLER.

    $cContainer -> set('Home_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new Home_Controller($ciContainer);

    });

    $cContainer -> set('User_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new User_Controller($ciContainer);

    });

    $cContainer -> set('Pokemon_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new Pokemon_Controller($ciContainer);

    });

    $cContainer -> set('Phrases_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new Phrases_Controller($ciContainer);

    });

    $cContainer -> set('ViteJS_Controller', function(App $aApp, ContainerInterface $ciContainer) {

        return new ViteJS_Controller($ciContainer);

    });

    // END - APP CONTROLLER.

};
