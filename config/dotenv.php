<?php

use Dotenv\Dotenv,

    Dotenv\Exception\InvalidPathException, 
    Dotenv\Exception\ValidationException;

try {

    $strEnv = '.env.run'; 

    $dEnv = Dotenv::createImmutable(__DIR__ . '/../tmp/', $strEnv);
    
    $dEnv -> load();
    
    $dEnv -> required('APP_ENV') -> notEmpty();
    $dEnv -> required([ 'APP_NAME', 'APP_DEBUG' ]);
    $dEnv -> required('TEMPLATE_PROVIDER') -> 
        allowedValues([ 'twig', 'php-view' ]);
    
} 
catch (InvalidPathException $ipe) {

    echo $ipe -> getMessage();

}
catch (ValidationException $ve) {

    echo $ve -> getMessage();

}
