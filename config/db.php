<?php

// Settings (DB).
$aSettings = [

    'driver' => isset($_ENV['DB_CONNECTION']) && $_ENV['DB_CONNECTION'] != '' ? $_ENV['DB_CONNECTION'] : 'mysql',
    'mysql' => [
        'driver' => 'mysql',
        'host' => (function () {

            $mixHost = [ 
                $strHost = isset($_ENV['DB_HOST']) && $_ENV['DB_HOST'] != '' ? $_ENV['DB_HOST'] : 'localhost',
                $strPort = isset($_ENV['DB_PORT']) && $_ENV['DB_PORT'] != '' ? $_ENV['DB_PORT'] : '3306'
            ];

            $mixHost = array_filter($mixHost);

            $mixHost = implode(':', $mixHost);

            return $mixHost;
        })(),
        'database' => isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : '',
        'username' => isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : '',
        'password' => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '',
        'charset'   => isset($_ENV['DB_CHARSET']) && $_ENV['DB_CHARSET'] != '' ? $_ENV['DB_CHARSET'] : 'utf8mb4',
        'collation' => isset($_ENV['DB_COLLATION']) && $_ENV['DB_COLLATION'] != '' ? $_ENV['DB_COLLATION'] : 'utf8mb4_spanish2_ci',
        'prefix'    => isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : ''
    ],
    'json' => [
        'driver' => 'json',
        'filename' => isset($_ENV['DB_FILENAME_JSON']) ? $_ENV['DB_FILENAME_JSON'] : '',
        'path' => __DIR__ . '/../database'
    ],
    'txt' => [
        'driver' => 'txt',
        'filename' => isset($_ENV['DB_FILENAME_TXT']) ? $_ENV['DB_FILENAME_TXT'] : '',
        'path' => __DIR__ . '/../database'
    ]

];

// ...

return $aSettings;