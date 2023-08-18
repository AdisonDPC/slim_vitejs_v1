<?php

// Settings (VIEW).
$aSettings = [

    'provider' => isset($_ENV['TEMPLATE_PROVIDER']) && $_ENV['TEMPLATE_PROVIDER'] != '' ? $_ENV['TEMPLATE_PROVIDER'] : 'twig',
    'twig' => [
        'path' => __DIR__ . '/../src/view/twig',
        'options' => [ 'cache' => false ]    
    ],
    'php-view' => [
        'path' => __DIR__ . '/../src/view/php',
    ]

];

// ...

return $aSettings;