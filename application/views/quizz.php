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
    elseif ( $type == 'quest' ) : 
        
        $num = isset($numQuest) ? $numQuest : 0;
    
        echo form_open('game/quizzGame', array('method' => 'post'));
            echo form_fieldset();
            
                echo '<div>'.
                     '<h2> Question n°'.($num + 1).'</h2>'.
                     '<p>'.$questions[$num]['question'].'</p>'.
                     '</div>';
                
                echo form_label($questions[$num]['choice_1'],'choice_1');
                echo form_radio(array('name' => 'choice', 'id' => 'choice_1', 'value' => $questions[$num]['choice_1']));
                
                echo form_label($questions[$num]['choice_2'],'choice_2');
                echo form_radio(array('name' => 'choice', 'id' => 'choice_2', 'value' => $questions[$num]['choice_2']));
                
                echo form_label($questions[$num]['choice_3'],'choice_3');
                echo form_radio(array('name' => 'choice', 'id' => 'choice_3', 'value' => $questions[$num]['choice_3']));
                
                echo '<input type="hidden" name="numQuest" value="'.$num.'"/>';
                echo '<input type="hidden" name="user_id" value="'.$user_id.'"/>';
                echo '<input type="hidden" name="quest_id" value="'.$questions[$num]['id'].'"/>';
                echo '<input type="hidden" name="answer" value="'.$questions[$num]['answer'].'"/>';
                
                echo form_submit('repondre', 'Répondre');
                
            echo form_fieldset_close();
        echo form_close();
        
    else : 
?>
        <div id="endQuizz">
            <?php
                $pct = ( $result['goodAnswer'] / $result['nbQuestion'])* 100;
                
                if ( $pct > 50 )
                    echo '<h3>Félicitation tu as términé le quizz avec un score de <em>'.$result['goodAnswer'] .'/'. $result['nbQuestion'].'</em></h3>';        
                else
                    echo '<h3>Désolé tu as términé le quizz avec un score de <em>'.$result['goodAnswer'] .'/'. $result['nbQuestion'].'</em></h3>'; 
            ?>
        </div>
<?php        
    endif;
