<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?= $titre ?></title>
        <link rel="stylesheet" type="text/css" href="<?= site_url() . CSS_DIR ?>style.css" media="screen" />
    </head>
    <body id="layout_game">
        <nav>
            <ul>
                <li>
                    <?php echo anchor('#', 'Accueil', array('title' => "Retourner à la page d'accueil")); ?>
                </li>
                <li>
                    <?php echo anchor('game/quizz', 'Quizz', array('title' => "Jouer au quizz")); ?>
                </li>
                <li>
                    <?php echo anchor('#', 'nom du jeu', array('title' => "Jouer au jeu")); ?>
                </li>
                <li>
                    <?php echo anchor('http://www.objectifdeveloppementdurable.be/', 'Explora Temporium', array('title' => "Aller sur le site de l'exposition")); ?>
                </li>                
            </ul>
        </nav>

        <h1 class="no_Show"><?= $titre ?></h1>

        <div id="container">
            <?= $vue ?>            
        </div>
        <footer>
            <?php echo anchor('admin/connect', "Panneau d'administration", array('title' => "Administrer le site internet")); ?>
        </footer>
        
        <script src="<?= base_url() . JS_DIR ?>/jquery.js"></script>
        <?php if ( $type == 'quest' ) : ?>    
        <script> var sQuestions = JSON.stringify(<?php echo $questions; ?>); </script>
                
        <?php
            endif;
        ?>
        <?php if ( $type == 'quest' || $type == 'start' ) : ?>
            <script src="<?= base_url() . JS_DIR ?>/quizz.js" ></script>
        <?php endif; ?>
    </body>
</html>