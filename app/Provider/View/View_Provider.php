<?php

namespace App\Provider\View;

use 
    Psr\Container\ContainerInterface,

    Slim\Views\Twig,
    Slim\Views\PhpRenderer,

    Twig\Extension\DebugExtension;

// SERVICE TWIG OR PHP-VIEW FOR TEMPLATES.

class View_Provider {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 

        $this -> ciContainer = $ciContainer; 

    }

    private function setTwig () {

        $aConfig = $this -> ciContainer -> get('config');

        $strProvider = $aConfig['view']['provider'];

        // Create Twig.
        $tTwig = Twig::create($aConfig['view'][ $strProvider ]['path'], $aConfig['view'][ $strProvider ]['options']);

        $tTwig -> addExtension(new DebugExtension());

        return $tTwig;

    }

    private function setPHPView () {

        $aConfig = $this -> ciContainer -> get('config');

        $strProvider = $aConfig['view']['provider'];

        // Create PHP-View (Renderer).
        $prRederer = new PhpRenderer($aConfig['view'][ $strProvider ]['path'] . '/');

        return $prRederer;

    }

    public function setView () {

        $aConfig = $this -> ciContainer -> get('config');

        $strProvider = $aConfig['view']['provider'];

        return $strProvider == 'php-view' ? $this -> setPHPView() : $this -> setTwig();

    }

}