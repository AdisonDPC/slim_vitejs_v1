<?php

namespace Middleware;

use Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Server\RequestHandlerInterface as RequestHandler, 
    
    Slim\Psr7\Response;

class Before_Middleware {
    
    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 
        
        $this -> ciContainer = $ciContainer; 
    
    }

    public function __invoke (Request $rRequest, RequestHandler $rhHandler): Response {

        $rResponse = $rhHandler -> handle($rRequest);

        $strContent = (string)$rResponse -> getBody();

        $rResponse = new Response;

        $rResponse -> getBody() -> write('BEFORE ' . $strContent);

        return $rResponse;

    }

}
