<?php

namespace Middleware;

use Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Server\RequestHandlerInterface as RequestHandler, 
    
    Slim\Psr7\Response;

class DB_Middleware {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 
        
        $this -> ciContainer = $ciContainer; 
    
    }

    public function __invoke (Request $rRequest, RequestHandler $rhHandler): Response {

        $aConfig = $this -> ciContainer -> get('config');

        $rResponse = $rhHandler -> handle($rRequest);

        $rResponse -> getBody() -> write('Driver is: ' . $aConfig['db']['driver'] . '.');

        return $rResponse;

    }

}
