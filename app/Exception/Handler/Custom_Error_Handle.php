<?php

namespace App\Exception\Handler;

use Slim\Handlers\ErrorHandler;

class Custom_Error_Handler extends ErrorHandler {

    protected function logError (string $strError): void {

        // Insert custom error logging function.

    }

}