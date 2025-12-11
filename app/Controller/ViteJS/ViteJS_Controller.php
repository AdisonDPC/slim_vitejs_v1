<?php

namespace App\Controller\ViteJS;

use 
    Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response;

class ViteJS_Controller {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 
        
        $this -> ciContainer = $ciContainer; 
    
    }

    public function getIndex (Request $rRequest, Response $rResponse) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['view']['provider'] != 'php-view') { $rResponse -> getBody() -> write('Error: Provider not supported.'); return $rResponse; }

        return $this -> ciContainer -> get('view') -> render($rResponse, 'vitejs.php', [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (PHP - View).',
                'aEnvironment' => $_ENV,
                'cViteJS' => $cViteJS
            ]
        ]);

    }

}
