<?php

use DI\ContainerBuilder, 
    
    Slim\App;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../config/dotenv.php';

$cbContainerBuilder = new ContainerBuilder();

$aDefinitions = require __DIR__ . '/definitions.php';

// Add DI container definitions.
$cbContainerBuilder -> addDefinitions($aDefinitions);

// Create DI container instance.
$cContainer = $cbContainerBuilder -> build();

// Create Slim App instance
$aApp = $cContainer -> get(App::class);

// Get tools.
require __DIR__ . '/../app/Tool/app.php';

// Register provider.
(require __DIR__ . '/../app/Provider/app.php')($aApp);

// Register middleware.
(require __DIR__ . '/../app/Middleware/app.php')($aApp);

// Register controller.
(require __DIR__ . '/../app/Controller/app.php')($aApp);

// Register route.
(require __DIR__ . '/../app/Route/app.php')($aApp);

return $aApp;