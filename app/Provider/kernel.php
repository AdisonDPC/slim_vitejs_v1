<?php

use 
    Psr\Container\ContainerInterface,

    Slim\App,

    App\Provider\View\View_Provider,
    App\Provider\View\DB_Provider;

return function (App $aApp) {

    $cContainer = $aApp -> getContainer();

    $cContainer -> set('view', function(App $aApp, ContainerInterface $ciContainer) {

        $vView = new View_Provider($ciContainer);

        return $vView -> setView();

    });

    $cContainer -> set('db', function(App $aApp, ContainerInterface $ciContainer) {

        $vView = new View_Provider($ciContainer);

        return $vView -> setDB();

    });

};
