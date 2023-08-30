<?php

namespace App\Middleware\View;

use 
    Slim\App,

    Slim\Views\TwigMiddleware;

// Middleware (Twig | PHP-View).

class View_Middleware {
    
    protected $aApp;
    protected $cContainer;

    public function __construct (App $aApp) { 

        $this -> aApp = $aApp;
        $this -> cContainer = $aApp -> getContainer();
    
    }

    // Twig.
    private function setTwig (App &$aApp) {

        // d('Middleware (Twig)');

        $aApp -> add(TwigMiddleware::createFromContainer($aApp));

    }

    // PHP-View.
    private function setPHPView (App &$aApp) {

        // d('Middleware (PHP-View)');

        return null;

    }

    public function setView (App &$aApp) {

        $aConfig = $this -> cContainer -> get('config');

        $strProvider = $aConfig['view']['provider'];

        if ($strProvider == 'php-view') 
            $this -> setPHPView($aApp);
        else 
            $this -> setTwig($aApp);

    }

}
