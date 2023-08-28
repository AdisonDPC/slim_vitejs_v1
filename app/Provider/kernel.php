<?php

use Psr\Container\ContainerInterface,

    Slim\App,
    Slim\Views\Twig,
    Slim\Views\PhpRenderer,

    Twig\Extension\DebugExtension,

    Illuminate\Database\Capsule\Manager;

return function (App $aApp) {

    $cContainer = $aApp -> getContainer();

    // SERVICE TWIG FOR TEMPLATES.
    
    $cContainer -> set('view', function(App $aApp, ContainerInterface $ciContainer) {

        $aConfig = $ciContainer -> get('config');

        $aProvider = [
            'twig' => function () use ($aConfig) {

                $strProvider = $aConfig['view']['provider'];

                // Create Twig.
                $tTwig = Twig::create($aConfig['view'][ $strProvider ]['path'], $aConfig['view'][ $strProvider ]['options']);

                $tTwig -> addExtension(new DebugExtension());

                return $tTwig;

            },
            'php-view' => function () use ($aConfig) {

                $strProvider = $aConfig['view']['provider'];

                // Create PHP-View (Renderer).
                $prRederer = new PhpRenderer($aConfig['view'][ $strProvider ]['path'] . '/');

                return $prRederer;

            }
        ];

        return isset($aProvider[ $aConfig['view']['provider'] ]) ? $aProvider[ $aConfig['view']['provider'] ]() : $aProvider['twig']();

    });
    
    // SERVICE FACTORY FOR THE DATABASE (ORM MYSQL ELOQUENT | JSON | TXT).

    $cContainer -> set('db', function(App $aApp, ContainerInterface $ciContainer) {

        $aConfig = $ciContainer -> get('config');

        $mManager = new Manager;

        if ($aConfig['db']['driver'] != 'mysql') return $aConfig['db'][$aConfig['db']['driver']];

        $mManager -> addConnection($aConfig['db'][$aConfig['db']['driver']]);

        $mManager -> setAsGlobal();
        $mManager -> bootEloquent();

        return $mManager;

    });

};
