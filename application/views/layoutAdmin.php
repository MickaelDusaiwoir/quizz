<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title><?= $titre ?></title>
        <link rel="stylesheet" type="text/css" href="<?= site_url() . CSS_DIR ?>style.css" media="screen" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
    </head>
    <body id="layout_admin">

        <?php if ($this->session->userdata('logged_in')) : ?>
            <nav id="admin_menu">
                <ul>                    
                    <li> <?= anchor('game/afficher', 'Home', array('title' => "Retourner à la page d'accueil", 'class' => "homeIcon")); ?> </li>
                    <li> <?= anchor('admin/listUsers', 'Utilisateur', array('title' => "Administrer les utilisateurs")); ?> </li>
                    <li> <?= anchor('admin/getListQuestion', 'Quizz', array('title' => "Administrer le quizz")); ?> </li>
                    <li> <?= anchor('admin/stats', 'Statistiques', array('title' => "Statistiques")); ?> </li>
                    <li> <?= anchor('admin/disconnect', 'Déconnection', array('title' => "Se déconnecter")); ?> </li>
                </ul>
            </nav>
        <?php endif; ?>

        <h1 class="no_Show"><?= $titre ?></h1>

        <div id="container">
            <?= $vue ?>            
        </div>

    </body>
</html>