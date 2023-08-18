<!doctype html>
<html>
  <head>

    <title><?= $aPage['strTitle']; ?></title>

    <meta name="description" content="<?= $aPage['strDescription']; ?>">

  </head>
  <body>
    <h1>TEMPLATE POKEMONS (PHP - VIEW)</h1>
    <h2>Pokemons <?= $aPage['strType']; ?></h2>
    <h3>Driver <?= $aPage['strDriver']; ?></h3>

    <div>

        <?php foreach ($aPokemons as $pPokemon) { ?>
            <div>
                <span><?= $pPokemon -> name; ?></span>
                <span> => </span>
                <img src="<?= '/assets/img/' . str_pad($pPokemon -> id, 3, '0', STR_PAD_LEFT) . '.png'; ?>" alt="<?= $pPokemon -> name; ?>" width="50" height="50">
            </div>
        <?php } ?>

    </div>
  </body>
</html>
