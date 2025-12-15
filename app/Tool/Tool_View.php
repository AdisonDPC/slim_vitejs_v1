<?php

namespace App\Tool;

class Tool_View {

    public function __construct () {}

    public static function mtdRenderSnipet ($strPATH, $objParams_) {

        $objParams = $objParams_;

        require $strPATH;

    }

}