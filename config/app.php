<?php

// Should be set to 0 in production.
error_reporting(E_ALL);

// Should be set to '0' in production.
ini_set('display_errors', '1');

// Settings (APP).
$aSettings = [

    'name' => isset($_ENV['APP_NAME']) && $_ENV['APP_NAME'] != '' ? $_ENV['APP_NAME'] : 'Slim APP',
    'env' => isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] != '' ? $_ENV['APP_ENV'] : 'devel',
    'debug' => isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] != '' ? $_ENV['APP_DEBUG'] : true,
    'url' => isset($_ENV['APP_URL']) && $_ENV['APP_URL'] != '' ? $_ENV['APP_URL'] : 'localhost'

];

// ...

return $aSettings;
