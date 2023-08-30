<?php

// Settings (EXCEPTION).
$aSettings = [

    'renderer' => [

        // type => string | template
        'type' => isset($_ENV['EXCEPTION_TYPE']) && $_ENV['EXCEPTION_TYPE'] != '' ? $_ENV['EXCEPTION_TYPE'] : 'string',

    ]

];

// ...

return $aSettings;