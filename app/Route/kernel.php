<?php

use 
    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response, 
    
    Slim\App;

return function (App $aApp) {
    
    $cContainer = $aApp -> getContainer();

    $aApp -> get('/', function (Request $rRequest, Response $rResponse, $aArgs) {
        
        $aConfig = $this -> get('config');

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';

        return $this -> get('view') -> render($rResponse, 'welcome.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).'
            ]
        ]);
        
    });

    $aApp -> get('/dd', function (Request $rRequest, Response $rResponse, $aArgs) { 
        
        Kint::dump([1, 'a']); 
        
        $rResponse -> getBody() -> write('Kint');

        return $rResponse;
    
    });

    $aApp -> get('/parameter-01/{parameter-01}', function (Request $rRequest, Response $rResponse, $aArgs) {

        $strParameter01 = $aArgs['parameter-01'];

        $rResponse -> getBody() -> write("$strParameter01");

        return $rResponse;

    });

    $aApp -> get('/parameter-02/{parameter-01}/{parameter-02}', function (Request $rRequest, Response $rResponse, $aArgs) {

        $strParameter01 = $aArgs['parameter-01'];
        $strParameter02 = $aArgs['parameter-02'];

        $rResponse -> getBody() -> write("$strParameter01, $strParameter02");

        return $rResponse;

    });

    $aApp -> get('/parameter-03/{parameter-01}/{parameter-02}[/{parameter-03}]', function (Request $rRequest, Response $rResponse, $aArgs) {

        $strParameter01 = $aArgs['parameter-01'];
        $strParameter02 = $aArgs['parameter-02'];
        $strParameter03 = $aArgs['parameter-03'];

        $rResponse -> getBody() -> write("$strParameter01, $strParameter02, $strParameter03");

        return $rResponse;

    });

    // CONTROLLER - MIDDLEWARE.

    // HOME.

    $aApp -> get('/home', Home_Controller::Class . ':getHome');

    $aApp -> get('/home/middleware/no', function (Request $rRequest, Response $rResponse, $aArgs) { 
        
        $rResponse -> getBody() -> write('Hello'); 

        return $rResponse;
    
    });

    $aApp -> get('/home/middleware/yes/before', function (Request $rRequest, Response $rResponse, $aArgs) { 
        
        $rResponse -> getBody() -> write('Hello'); 

        return $rResponse;

    }) -> add($cContainer -> get('Before_Middleware'));

    $aApp -> get('/home/middleware/yes/after', function (Request $rRequest, Response $rResponse, $aArgs) { 
        
        $rResponse -> getBody() -> write('Hello'); 

        return $rResponse;

    }) -> add($cContainer -> get('After_Middleware'));

    // PHRASES.

    $aApp -> get('/phrases/count', Phrases_Controller::Class . ':getCount');
    $aApp -> get('/phrases/random', Phrases_Controller::Class . ':getRandom');
    $aApp -> get('/phrases/get/{iRow}', Phrases_Controller::Class . ':getRow');
    $aApp -> get('/phrases/add/{strPhrase}', Phrases_Controller::Class . ':addRow');

    // DB.

    $aApp -> get('/db/middleware/no', function (Request $rRequest, Response $rResponse, $aArgs) {

        $rResponse -> getBody() -> write('DB'); 

        return $rResponse;

    });

    $aApp -> get('/db/middleware/yes', function (Request $rRequest, Response $rResponse, $aArgs) { 

        $rResponse -> getBody() -> write('DB '); 

        return $rResponse;

    }) -> add($cContainer -> get('DB_Middleware'));

    // USER.

    $aApp -> get('/user/all/closure', function (Request $rRequest, Response $rResponse, $aArgs) { 

        $aConfig = $this -> get('config');

        if ($aConfig['db']['driver'] != 'mysql') { $rResponse -> getBody() -> write('Error: Not MySQL driver.'); return $rResponse; }

        $mixDB = $this -> get('db');

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';

        return $this -> get('view') -> render($rResponse, 'users.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).',
                'strType' => 'Closure',
                'strDriver' => $aConfig['db']['driver']
            ],
            'aUsers' => $mixDB -> table('users') -> get()
        ]);

    });

    $aApp -> get('/user/all/controller', User_Controller::Class . ':getAll');

    // POKEMON.

    $aApp -> get('/migrate/pokemons/json/to/sql/closure', function (Request $rRequest, Response $rResponse, $aArgs) { 

        $aConfig = $this -> get('config');

        if ($aConfig['db']['driver'] != 'json') { $rResponse -> getBody() -> write('Error: Not JSON driver.'); return $rResponse; }

        $mixDB = $this -> get('db');

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

    });

    $aApp -> get('/migrate/pokemons/json/to/sql/controller', Pokemon_Controller::Class . ':migrateJSON2SQL');

    $aApp -> get('/pokemon/all/closure', function (Request $rRequest, Response $rResponse) {

        $aConfig = $this -> get('config');

        if (!in_array($aConfig['db']['driver'], ['mysql', 'json'])) { $rResponse -> getBody() -> write('Error: Not MySQL or JSON driver.'); return $rResponse; }

        $mixDB = $this -> get('db');

        $aData = $aConfig['db']['driver'] == 'mysql' ? 
            $mixDB -> table('pokemons') -> get() : 
            json_decode(file_get_contents($mixDB['path'] . '/' . $mixDB['filename']), false);

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';
            
        return $this -> get('view') -> render($rResponse, 'pokemons.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).',
                'strType' => 'Closure',
                'strDriver' => $aConfig['db']['driver']
            ],
            'aPokemons' => $aData
        ]);

    });

    $aApp -> get('/pokemon/all/controller', Pokemon_Controller::Class . ':getAll');
    
    // VITE JS.

    $aApp -> get('/vitejs/closure', function (Request $rRequest, Response $rResponse, $aArgs) {

        $aConfig = $this -> get('config');

        if ($aConfig['view']['provider'] != 'php-view') { $rResponse -> getBody() -> write('Error: Provider not supported.'); return $rResponse; }

        return $this -> get('view') -> render($rResponse, 'vitejs.php', [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (PHP - View).',
                'aEnvironment' => $_ENV
            ]
        ]);
        
    });

    $aApp -> get('/vitejs/controller', ViteJS_Controller::Class . ':getIndex');

};
