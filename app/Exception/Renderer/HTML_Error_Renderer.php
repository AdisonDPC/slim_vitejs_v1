<?php

namespace App\Exception\Renderer;

use 
    Slim\Interfaces\ErrorRendererInterface,
    Slim\Exception\HttpNotFoundException,

    Throwable;

class HTML_Error_Renderer implements ErrorRendererInterface {

    private function getExceptionDetail (Throwable $te) {

        $iCode = 200;
        $strMessage = 'Error: An error has occurred.';
        $strDescription = 'Description: An error has occurred.';
        $iLine = 0;
        $strFile = '';
        $mixPrevious = null;
        $mixTrace = null;

        // HttpBadRequestException
        // HttpForbiddenException
        // HttpInternalServerErrorException
        // HttpMethodNotAllowedException
        // HttpNotFoundException
        // HttpNotImplementedException
        // HttpUnauthorizedException

        switch (true) {
            case $te instanceof HttpBadRequestException:
            case $te instanceof HttpForbiddenException:
            case $te instanceof HttpInternalServerErrorException:
            case $te instanceof HttpMethodNotAllowedException:
            case $te instanceof HttpNotFoundException:
            case $te instanceof HttpNotImplementedException:
            case $te instanceof HttpUnauthorizedException:
                $iCode = $te -> getCode();
                $strMessage = 'Error: ' . $te -> getMessage();
                $strDescription = $te -> getDescription();
                $iLine = $te -> getLine();
                $strFile = $te -> getFile();
                $mixPrevious = $te -> getPrevious();
                $mixTrace = $te -> getTrace();

                break;
        }

        return [
            'CODE' => $iCode,
            'MESSAGE' => $strMessage,
            'DESCRIPTION' => $strDescription,
            'LINE' => $iLine,
            'FILE' => $strFile,
            'PREVIOUS' => $mixPrevious,
            'TRACE' => $mixTrace
        ];

    }

    private function render ($aException, $bDisplayErrorDetails) {

        if (!$bDisplayErrorDetails) unset($aException['DESCRIPTION'], $aException['LINE'], $aException['FILE'], $aException['PREVIOUS'], $aException['TRACE']);

        // d($aException);

        return json_encode($aException, JSON_UNESCAPED_UNICODE);

    }

    public function __invoke (Throwable $te, bool $bDisplayErrorDetails): string {

        $aException = $this -> getExceptionDetail($te);

        return $this -> render($aException, $bDisplayErrorDetails);

    }

}