<?php

namespace App\Middleware\General;

use 
    Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Server\RequestHandlerInterface as RequestHandler, 
    
    Slim\Psr7\Response;

class After_Middleware {
    
    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 
        
        $this -> ciContainer = $ciContainer; 
    
    }

    public function __invoke (Request $rRequest, RequestHandler $rhHandler): Response {

        $rResponse = $rhHandler -> handle($rRequest);

        $rResponse -> getBody() -> write(' AFTER');

        return $rResponse;

    }

}
