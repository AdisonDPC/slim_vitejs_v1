<!doctype html>
<html>
  <head>

    <title><?= $aPage['strTitle']; ?></title>

    <meta name="description" content="<?= $aPage['strDescription']; ?>">

  </head>
  <body>
    <h1>TEMPLATE USERS (PHP - VIEW)</h1>
    <h2>Users <?= $aPage['strType']; ?></h2>
    <h3>Driver <?= $aPage['strDriver']; ?></h3>

    <div>

      <?php foreach ($aUsers as $uUser) { ?>
        <div>
          <span><?= $uUser -> name; ?></span>
          <span> | </span>
          <span><?= $uUser -> email; ?></span>
        </div>
      <?php } ?>

    </div>
  </body>
</html>
