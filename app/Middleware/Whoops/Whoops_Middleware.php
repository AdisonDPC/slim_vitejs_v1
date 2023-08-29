<?php

namespace App\Middleware\Whoops;

use 
    DI\Container,

    Slim\App,

    Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

// Middleware (Whoops).

class Whoops_Middleware {
    
    protected $cContainer;

    public function __construct (Container $cContainer) { 

        $this -> cContainer = $cContainer;
    
    }

    public function setWhoops (App &$aApp) {

        $aConfig = $this -> cContainer -> get('config');

        $aOptions = $aConfig['whoops']['options'];

        $aApp -> add(new WhoopsMiddleware($aOptions));

    }

}
