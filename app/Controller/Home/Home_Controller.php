<?php

namespace App\Controller\Home;

use 
    Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response;

class Home_Controller {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 
        
        $this -> ciContainer = $ciContainer; 
    
    }

    public function getHome (Request $rRequest, Response $rResponse) {

        $aConfig = $this -> ciContainer -> get('config');

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';

        return $this -> ciContainer -> get('view') -> render($rResponse, 'welcome.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).'
            ]
        ]);

    }

}
