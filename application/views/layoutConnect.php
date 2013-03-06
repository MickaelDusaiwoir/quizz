<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?= $titre ?></title>
        <link rel="stylesheet" type="text/css" href="<?= site_url() . CSS_DIR ?>style.css" media="screen" />
    </head>
    <body id="connect_layout">
        <h1 class="no_Show"><?= $titre ?></h1>

        <div id="container">
            <?= $vue ?>            
        </div>
        
    </body>
</html>