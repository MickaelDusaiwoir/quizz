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
        <?php
            
        if ( isset($type) ):   
            if ( $type == 'quest' || $type == 'start' ) : 
        ?>
                <script> var urlSite = '<?= base_url() ?>'; </script>
                <script src="<?= base_url() . JS_DIR ?>/quizz.js" ></script>
        <?php 
            endif; 
            
            if ( $type == 'quest' ) : ?>    
                <script> 
                        var sQuestions = '<?php echo json_encode($questions); ?>'; 
                        var nUser = <?= $user_id ?>;
                        var url_quizz = '<?= base_url() ?>web/ajax/quizz.php';
                        var playSound = true;                        
                </script>
        <?php
            endif;
        endif;
        ?>
    </body>
</html>