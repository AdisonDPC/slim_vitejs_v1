<?php

use Psr\Container\ContainerInterface,

    Slim\App,

    Slim\Views\TwigMiddleware;

return function (App $aApp) {

    // Get container.
    $cContainer = $aApp -> getContainer();

    $aConfig = $cContainer -> get('config');

    // Parse json, form data and xml.
    $aApp -> addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware.
    $aApp -> addRoutingMiddleware();

    // Handle exceptions.
    $aApp -> addErrorMiddleware(true, true, true);

    // BEGIN - Middleware (Twig | PHP-View).

    $aProvider = [
        'twig' => function () use ($aApp) {

            d('Middleware (Twig)');

            // Twig.
            $aApp -> add(TwigMiddleware::createFromContainer($aApp));

        },
        'php-view' => function () use ($aApp) {

            d('Middleware (PHP-View)');

            // PHP-View.
            return null;

        }
    ];

    if (isset($aProvider[ $aConfig['view']['provider'] ]))
        $aProvider[ $aConfig['view']['provider'] ]();
    else
        $aProvider['twig']();

    // END - Middleware (Twig | PHP-View).

    // BEGIN - APP MIDDLEWARE.

    $cContainer -> set('DB_Middleware', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Middleware\DB_Middleware($ciContainer);

    });

    $cContainer -> set('Before_Middleware', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Middleware\Before_Middleware($ciContainer);

    });

    $cContainer -> set('After_Middleware', function(App $aApp, ContainerInterface $ciContainer) {

        return new \Middleware\After_Middleware($ciContainer);

    });

    // END - APP MIDDLEWARE.

};
