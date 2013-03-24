<?php 
    if ( $type == 'start' ) :
?>
    <div id="startQuizz">
        <img src="<?= site_url() . IMG_QUIZZ_DIR ?>start.jpg" width="1000" height="500" alt="Porte d'entrée du jeu" title="Porte d'entrée du jeu" />
        <?= form_open('game/startQuizz', array('method' => 'post')); ?>
            <?= form_fieldset(); ?>
                    <?= form_label('Entrez votre nom','name'); ?>
                    <input type="text" id="name" name="name" placeholder="Quel est ton nom ?" />
                    <?= form_submit('jouer', 'Start'); ?>
                    <?= form_error('name'); ?>
            <?= form_fieldset_close(); ?>
        <?= form_close(); ?>
    </div>
<?php
    endif;
