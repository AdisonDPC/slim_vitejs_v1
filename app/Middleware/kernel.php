<?php

use 
    Psr\Container\ContainerInterface,

    Slim\App,

    App\Middleware\DB\DB_Middleware,
    App\Middleware\View\View_Middleware,
    App\Middleware\Whoops\Whoops_Middleware,

    App\Middleware\General\Before_Middleware,
    App\Middleware\General\After_Middleware;

return function (App $aApp) {

    // Get container.
    $cContainer = $aApp -> getContainer();

    $aConfig = $cContainer -> get('config');

    // Parse json, form data and xml.
    $aApp -> addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware.
    $aApp -> addRoutingMiddleware();

    // BEGIN - Middleware (Debug).

    $emError = null;

    $bDebug = $aConfig['app']['debug'];

    if ($bDebug) {
        $strType = $aConfig['exception']['renderer']['type'];

        if ($strType === 'whoops')
            (new Whoops_Middleware($aApp)) -> setWhoops($aApp);
        else
            // Handle exceptions | Add Error Middleware.
            $emError = $aApp -> addErrorMiddleware($bDebug, true, true);
    }
    else
        // Handle exceptions | Add Error Middleware.
        $emError = $aApp -> addErrorMiddleware($bDebug, true, true);

    // END - Middleware (Debug).

    // BEGIN - Middleware (Twig | PHP-View).

    (new View_Middleware($aApp)) -> setView($aApp);

    // END - Middleware (Twig | PHP-View).

    // BEGIN - Middleware (APP).

    $cContainer -> set('DB_Middleware', function(App $aApp, ContainerInterface $ciContainer) {

        return new DB_Middleware($ciContainer);

    });

    $cContainer -> set('Before_Middleware', function(App $aApp, ContainerInterface $ciContainer) {

        return new Before_Middleware($ciContainer);

    });

    $cContainer -> set('After_Middleware', function(App $aApp, ContainerInterface $ciContainer) {

        return new After_Middleware($ciContainer);

    });

    // END - Middleware (APP).

    return $emError;

};
