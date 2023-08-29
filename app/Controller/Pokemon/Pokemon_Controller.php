<?php

namespace App\Controller\Pokemon;

use 
    Psr\Container\ContainerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response,

    App\Model\Pokemon\Pokemon_Model;

class Pokemon_Controller {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { $this -> ciContainer = $ciContainer; }

    public function getAll (Request $rRequest, Response $rResponse) {

        $aConfig = $this -> ciContainer -> get('config');

        if (!in_array($aConfig['db']['driver'], ['mysql', 'json'])) { $rResponse -> getBody() -> write('Error: Not MySQL or JSON driver.'); return $rResponse; }

        $mixDB = $this -> ciContainer -> get('db');

        $aData = $aConfig['db']['driver'] == 'mysql' ? 
            $mixDB -> table('pokemons') -> get() : 
            json_decode(file_get_contents($mixDB['path'] . '/' . $mixDB['filename']), false);

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';

        return $this -> ciContainer -> get('view') -> render($rResponse, 'pokemons.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).',
                'strType' => 'Controller',
                'strDriver' => $aConfig['db']['driver']
            ],
            'aPokemons' => $aData
        ]);

    }

    public function migrateJSON2SQL (Request $rRequest, Response $rResponse) {

        $aConfig = $this -> ciContainer -> get('config');

        if ($aConfig['db']['driver'] != 'json') { $rResponse -> getBody() -> write('Error: Not JSON driver.'); return $rResponse; }

        $mixDB = $this -> ciContainer -> get('db');

        $aData = json_decode(file_get_contents($mixDB['path'] . '/' . $mixDB['filename']), true);
        $iData = count($aData);

        $strHTML  = '';

        $strHTML .= 'CREATE TABLE `pokemons` ( </br>';
        $strHTML .= '    `id` int(11) NOT NULL, </br>';
        $strHTML .= '    `name` varchar(250) NOT NULL, </br>';
        $strHTML .= '    `types` text NOT NULL, </br>';
        $strHTML .= '    `hp` int(11) NOT NULL DEFAULT 0, </br>';
        $strHTML .= '    `attack` int(11) NOT NULL DEFAULT 0, </br>';
        $strHTML .= '    `defense` int(11) NOT NULL DEFAULT 0, </br>';
        $strHTML .= '    `speed` int(11) NOT NULL DEFAULT 0, </br>';
        $strHTML .= '    `special` int(11) NOT NULL DEFAULT 0, </br>';
        $strHTML .= '    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, </br>';
        $strHTML .= '    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP </br>';
        $strHTML .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8; </br>';

        $strHTML .= 'INSERT INTO `pokemons` (`id`, `name`, `types`, `hp`, `attack`, `defense`, `speed`, `special`, `created_at`, `updated_at`) VALUES <br>';

        foreach ($aData as $mKey => $mValue) {
            $strHTML .= '(';
            $strHTML .= $mValue['id'] . ', ';
            $strHTML .= '"' . $mValue['name'] . '", ';
            $strHTML .= '\''  . json_encode($mValue['types']) . '\', ';
            $strHTML .= $mValue['baseStats']['hp'] . ', ';
            $strHTML .= $mValue['baseStats']['attack'] . ', ';
            $strHTML .= $mValue['baseStats']['defense'] . ', ';
            $strHTML .= $mValue['baseStats']['speed'] . ', ';
            $strHTML .= $mValue['baseStats']['special'] . ', ';
            $strHTML .= '\'2017-08-06 11:47:24\', ';
            $strHTML .= '\'2017-08-06 17:06:57\'';
            $strHTML .= ')';
            $strHTML .= ($mKey < $iData - 1) ? ',' : ';';
            $strHTML .= ' <br>';
        }

        $strHTML .= 'ALTER TABLE `pokemons` ADD PRIMARY KEY (`id`); <br>';
        $strHTML .= 'ALTER TABLE `pokemons` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=' . $iData . '; <br>';

        $rResponse -> getBody() -> write($strHTML); 
        
        return $rResponse;

    }

}
