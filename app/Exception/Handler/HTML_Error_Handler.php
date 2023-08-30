<?php

namespace App\Exception\Handler;

use 
    Slim\App,

    Slim\Exception\HttpBadRequestException,
    Slim\Exception\HttpForbiddenException,
    Slim\Exception\HttpInternalServerErrorException,
    Slim\Exception\HttpMethodNotAllowedException,
    Slim\Exception\HttpNotFoundException,
    Slim\Exception\HttpNotImplementedException,
    Slim\Exception\HttpUnauthorizedException,

    Psr\Log\LoggerInterface,

    Psr\Http\Message\ServerRequestInterface as Request,
    Psr\Http\Message\ResponseInterface as Response, 

    Throwable;
    
class HTML_Error_Handler {

    protected $aApp;
    protected $cContainer;

    public function __construct (App $aApp) { 

        $this -> aApp = $aApp;
        $this -> cContainer = $aApp -> getContainer();
    
    }

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

    public function getHandler (Request $rRequest, Throwable $te, bool $bDisplayErrorDetails, bool $bLogErrors, bool $bLogErrorDetails, ?LoggerInterface $liLogger = null) {

        $aConfig = $this -> cContainer -> get('config');

        $aException = $this -> getExceptionDetail($te);

        if ($liLogger) $liLogger -> error($aException['MESSAGE']);

        if (!$bDisplayErrorDetails) unset($aException['DESCRIPTION'], $aException['LINE'], $aException['FILE'], $aException['PREVIOUS'], $aException['TRACE']);

        // d($aException);

        $rResponse = $this -> aApp -> getResponseFactory() -> createResponse();

        $strExtension = $aConfig['view']['provider'] == 'php-view' ? 'php' : 'twig';

        return $this -> cContainer -> get('view') -> render($rResponse, 'error/' . $aException['CODE'] . '.' . $strExtension, [
            'aPage' =>  [
                'strTitle' => 'Welcome - Slim + (Twig | PHP - View)',
                'strDescription' => 'Welcome to the oficial page Slim + (Twig | PHP - View).',
                'aEnvironment' => $_ENV,
                'aException' => $aException
            ]
        ]);

    }

}