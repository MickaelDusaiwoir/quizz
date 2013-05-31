<?php 
    if ( $type == 'start' ) :
?>
    <div id="startQuizz">
        <?= form_open('game/startQuizz', array('method' => 'post', 'id' => 'start')); ?>
            <?= form_fieldset(); ?>
                    <?= form_label('Entrez votre nom','name'); ?>
                    <input type="text" id="name" name="name" placeholder="Inscrivez votre nom ici ?" />
                    <?= form_submit('jouer', 'Start'); ?>
                    <?= form_error('name'); ?>
            <?= form_fieldset_close(); ?>
        <?= form_close(); ?>
        <?php echo anchor('game/quizz', 'Recommencer', array('title' => "Recommencer le quizz", 'alt' => "Recommencer le quizz", 'class' => 'replay')); ?>
    </div>
<?php
    elseif ( $type == 'quest' ) : 
        
        $num = isset($numQuest) ? $numQuest : 0;
        
        echo '<section id="quizz_design"><h1>Quizz sur l\'écologique</h1>';
        echo '<div id="quizz">';
            echo form_open('game/quizzGame', array('method' => 'post'));
            
            echo '<h2> Question n°<span id="num_quest">'.($num + 1).'</span></h2>';
            
                echo form_fieldset();

                    echo '<div id="quest">'.
                         '<p>'.$questions[$num]['question'].'</p>'.
                         '</div>';
                    
                    echo '<div id="lab">';
                        echo form_label($questions[$num]['choice_1'],'choice_1');
                        echo form_radio(array('name' => 'choice', 'id' => 'choice_1', 'value' => $questions[$num]['choice_1']));
                        echo '<p class="lettre">A</p>';

                        echo form_label($questions[$num]['choice_2'],'choice_2');
                        echo form_radio(array('name' => 'choice', 'id' => 'choice_2', 'value' => $questions[$num]['choice_2']));
                        echo '<p class="lettre">B</p>';

                        echo form_label($questions[$num]['choice_3'],'choice_3');
                        echo form_radio(array('name' => 'choice', 'id' => 'choice_3', 'value' => $questions[$num]['choice_3']));
                        echo '<p class="lettre">C</p>';
                    echo '</div>';
                        
                    echo '<input type="hidden" name="numQuest" id="numQuest" value="'.$num.'"/>';
                    echo '<input type="hidden" name="user_id" value="'.$user_id.'"/>';
                    echo '<input type="hidden" name="quest_id" value="'.$questions[$num]['id'].'"/>';
                    echo '<input type="hidden" name="answer" value="'.$questions[$num]['answer'].'"/>';

                    echo form_submit('repondre', 'Répondre');

                echo form_fieldset_close();
            echo form_close();
            
            echo '<p id="son" class="icon-volume-up" data-son="play"><span>Volume</span></p>'.
                 '<img src="'.site_url() . IMG_QUIZZ_DIR.'nuage_1.png" width="130" height="72" alt="nuage" title="nuage" id="nuage_1" />'.
                 '<img src="'.site_url() . IMG_QUIZZ_DIR.'p_nuage.png" height="30" width="60" alt="nuage d\'arrière plan" title="nuage" id="p_nuage" />';
                        
        echo '</div>';
        echo anchor('game/quizz', 'Recommencer', array('title' => "Recommencer le quizz", 'alt' => "Recommencer le quizz", 'class' => 'replay'));
        echo'</section>';
        
    else : 
?>
        <div id="endQuizz">
            <?php
                $pct = ( $result['goodAnswer'] / $result['nbQuestion'])* 100;
                
                if ( $pct > 50 )
                    echo '<h3>Félicitation tu as términé le quizz avec un score de <em id="good">'.$result['goodAnswer'] .'/'. $result['nbQuestion'].'</em></h3>';        
                else
                    echo '<h3>Désolé tu as términé le quizz avec un score de <em id="bad">'.$result['goodAnswer'] .'/'. $result['nbQuestion'].'</em></h3>'; 
            ?>
        </div>
<?php        
    endif;
