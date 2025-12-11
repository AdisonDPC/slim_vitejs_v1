<?php

namespace App\Middleware\Whoops;

use 
    Slim\App,

    Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

// Middleware (Whoops).

class Whoops_Middleware {
    
    protected $aApp;
    protected $cContainer;

    public function __construct (App $aApp) { 

        $this -> aApp = $aApp;
        $this -> cContainer = $aApp -> getContainer();
    
    }

    public function setWhoops (App &$aApp) {

        $aConfig = $this -> cContainer -> get('config');

        $aOptions = $aConfig['whoops']['options'];

        $aApp -> add(new WhoopsMiddleware($aOptions));

    }

}
