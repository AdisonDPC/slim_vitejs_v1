<?php

namespace Controller;

use Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response,

    App\Model\User_Model;

class User_Controller {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { $this -> ciContainer = $ciContainer; }

    public function getAll (Request $rRequest, Response $rResponse) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['db']['driver'] != 'mysql') { $rResponse -> getBody() -> write('Error: Not MySQL driver.'); return $rResponse; }

        $mixDB = $this -> ciContainer -> get('db');

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';

        return $this -> ciContainer -> get('view') -> render($rResponse, 'users.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).',
                'strType' => 'Controller',
                'strDriver' => $aConfig['db']['driver']
            ],
            'aUsers' => $mixDB -> table('users') -> get()
        ]);

    }

}
