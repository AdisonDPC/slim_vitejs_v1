<?php

namespace Controller;

use Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response;

class Phrases_Controller {

    protected $ciContainer;

    private $strName;
    private $fFile;

    public function __construct (ContainerInterface $ciContainer) {

        $this -> ciContainer = $ciContainer;

        $aDB = $this -> ciContainer -> get('db');

        $this -> strName = $aDB['filename'];
        $this -> fFile = file($aDB['path'] . '/' . $this -> strName);

    }

    public function getCount (Request $rRequest, Response $rResponse, $aArgs) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['db']['driver'] != 'txt') { $rResponse -> getBody() -> write('Error: Not TXT driver.'); return $rResponse; }

        $rResponse -> getBody() -> write(strval(count($this -> fFile))); 

        return $rResponse;
    
    }

    public function getRandom (Request $rRequest, Response $rResponse, $aArgs) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['db']['driver'] != 'txt') { $rResponse -> getBody() -> write('Error: Not TXT driver.'); return $rResponse; }

        $iRow = mt_rand(0, count($this -> fFile) - 1);

        $rResponse -> getBody() -> write($this -> fFile[$iRow]);

        return $rResponse;

    }

    public function getRow (Request $rRequest, Response $rResponse, $aArgs) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['db']['driver'] != 'txt') { $rResponse -> getBody() -> write('Error: Not TXT driver.'); return $rResponse; }

        if (!isset($this -> fFile[$aArgs['iRow'] - 1])) { $rResponse -> getBody() -> write('Error: The row ' . $aArgs['iRow'] . ' not found into the file.'); return $rResponse; }

        $rResponse -> getBody() -> write($this -> fFile[$aArgs['iRow'] - 1]); 

        return $rResponse;

    }

    public function addRow (Request $rRequest, Response $rResponse, $aArgs) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['db']['driver'] != 'txt') { $rResponse -> getBody() -> write('Error: Not TXT driver.'); return $rResponse; }

        $mixDB = $this -> ciContainer -> get('db');

        if(file_put_contents($mixDB['path'] . '/' . $this -> strName, $aArgs['strPhrase'] . "\n", FILE_APPEND)) { $rResponse -> getBody() -> write('Success: Add Row.'); return $rResponse; }

        $rResponse -> getBody() -> write('Error: Add Row.');

        return $rResponse;

    }

}
