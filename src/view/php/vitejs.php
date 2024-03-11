<?php

$strTitle = 'HELLO WORLD';

$strH1 = 'H1 HEADER';
$strH2 = 'H2 HEADER';
$strH3 = 'H3 HEADER';

$cViteJS = $aPage['cViteJS'];

$strDomain = $cViteJS -> mtdGetHost() . ':' . $cViteJS -> mtdGetPort();

$strImageViteJS = $cViteJS -> mtdAssetURL('image/dynamic/vite.svg');
$strImagePHP = $cViteJS -> mtdAssetURL('image/static/php.svg');

d($aPage['aEnvironment'], $cViteJS -> mtdGetProperties(), $cViteJS -> mtdManifest());

$cViteJS -> mtdSetEntry('js/vitejs.js'); 

?>

<!doctype html>
<html lang="en">
    <head>

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" type="image/svg+xml" href="<?= $strImageViteJS ?>" />

        <title><?= $strTitle ?></title>

    </head>
    <body style="display: block;">

        <h1 style="text-align: center;"><?= $strH1 ?></h1>
        <h2 style="text-align: center;"><?= $strH2 ?></h2>
        <h3 style="text-align: center;"><?= $strH3 ?></h3>

        <h4 style="text-align: center;"><?= $strTitle ?></h4>

        <div style="padding: 32px 32px 0 32px; text-align: center;">
            <a href="https://www.php.net" target="_blank">
                <img src="<?= $strImagePHP ?>" class="logo php" alt="PHP logo" />
            </a>
        </div>

        <div id="app"></div>

        <?= $cViteJS -> mtdInit(); ?>

    </body>
</html>
