<?php

// Settings (WHOOPS).
$aSettings = [

    'options' => [ 'enable' => isset($_ENV['WHOOPS_ENABLED']) ? $_ENV['WHOOPS_ENABLED'] === 'true' : true ]

];

// ...

return $aSettings;