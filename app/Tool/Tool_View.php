<?php

namespace App\Tool;

use RuntimeException;

class Tool_View {

    public function __construct () {}

    // CONTROLLER.

    // use App\Tool\Tool_View;

    // return $this -> ciContainer -> get('view') -> render($rResponse, 'module/wipei/back/default/default.php', [
    //     'aPage' =>  [
    //         'strTitle' => 'Welcome - Slim + (PHP - View)',
    //         'strDescription' => 'Welcome to the oficial page Slim + (PHP - View).',
    //         'aEnvironment' => $_ENV,
    //         'cViteJS' => $cViteJS,
    //         'cView' => Tool_View::class
    //     ]
    // ]);

    // VIEW.

    // $cView = $aPage['cView'];

    // $cView::mtdRenderSnipet(__DIR__ . '/../snippet/snippet.php', [ 'a' => 'b' ]);
    // $cView::mtdRenderSnipet(__DIR__ . '/../snippet/snippet.php', [ 'a' => 'b' ], 'include');
    // $cView::mtdRenderSnipet(__DIR__ . '/../snippet/snippet.php', [ 'a' => 'b' ], 'include_once');
    // $cView::mtdRenderSnipet(__DIR__ . '/../snippet/snippet.php', [ 'c' => 'b' ], 'require');
    // $cView::mtdRenderSnipet(__DIR__ . '/../snippet/snippet.php', [], 'require_once');

    public static function mtdRenderSnipet(string $strPATH, array $aParams = [], string $strMethod = 'include'): void {
    
        // Early validation.
        if (!is_file($strPATH)) throw new RuntimeException('Snippet not found: ' . $strPATH);
    
        // Expose variables to the snippet.
        if (!empty($aParams)) extract($aParams, EXTR_SKIP);
    
        // Resolution of the method.
        switch ($strMethod) {
            case 'include_once':
                include_once $strPATH;
                break;
    
            case 'require':
                require $strPATH;
                break;
    
            case 'require_once':
                require_once $strPATH;
                break;
    
            default:
                include $strPATH;
        }

    }

}