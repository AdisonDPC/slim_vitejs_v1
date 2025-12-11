<?php

use 
    Slim\App, 

    Slim\Middleware\ErrorMiddleware,

    App\Exception\Handler\HTML_Error_Handler,
    App\Exception\Renderer\HTML_Error_Renderer;

return function (App $aApp, ?ErrorMiddleware $emError = null) {

    if (is_null($emError)) return null;

    // Get container.
    $cContainer = $aApp -> getContainer();

    $aConfig = $cContainer -> get('config');

    $aTypes = [
        'template' => function () use ($aApp, $emError) {

            // Define custom error handler.
            // Instantiate custom error handler.
            $emError -> setDefaultErrorHandler([ (new HTML_Error_Handler($aApp)), 'getHandler' ]);

            // Get the default error handler.
            $dehHandler = $emError -> getDefaultErrorHandler();

            return $dehHandler;

        },
        'string' => function () use ($aApp, $emError) {

            // Get the default error handler.
            $dehHandler = $emError -> getDefaultErrorHandler();

            // Register custom error renderer.
            $dehHandler -> registerErrorRenderer('text/html', HTML_Error_Renderer::class);

            return $dehHandler;

        }
    ];

    $dehHandler = isset($aTypes[ $aConfig['exception']['renderer']['type'] ]) ? $aTypes[ $aConfig['exception']['renderer']['type'] ]() : $aTypes['string']();

    // d($dehHandler);

};
