<?php

namespace App\Tool;

class Tool_View {

    public function __construct () {}

    public static function mtdRenderSnipet(string $strPATH, array $aParams = []): void {

        extract($aParams, EXTR_SKIP);

        include $strPATH;

    }

}