<section id="updateQuestion">
    <h2>
        Modifier cette question
    </h2>
    <?php 
        echo form_open('admin/updateQuestion', array('method' => 'post', 'id' => 'updateQuestionForm')); 
        echo form_fieldset(); 
        
        echo form_label('Question', 'quest'); 
        
        if ( set_value('quest') ) : ?>
            <textarea name="quest" id="quest"><?= set_value('quest') ?></textarea>
        <?php else : ?>
            <textarea name="quest" id="quest"><?= $donnees->question ?></textarea>
        <?php endif; 
        
        echo form_error('quest'); 
        
        echo form_label('Proposition N°1', 'choice1'); 
        ?>
        <input type="text" id="choice1" name="choice1" 
            <?php
                if ( set_value('choice1') )
                    echo 'value="'.set_value('choice1').'"';
                else
                    echo 'value="'.$donnees->choice_1.'"';
                ?> />
        <?php
        echo form_error('choice1'); 
        
        echo form_label('Proposition N°2', 'choice2'); 
        ?>
        <input type="text" id="choice2" name="choice2" 
            <?php
                if ( set_value('choice2') )
                    echo 'value="'.set_value('choice2').'"';
                else
                    echo 'value="'.$donnees->choice_2.'"';
                ?> />
        <?php
        echo form_error('choice2'); 
        
        echo form_label('Proposition N°3', 'choice3'); 
        ?>
        <input type="text" id="choice3" name="choice3" 
            <?php
                if ( set_value('choice3') )
                    echo 'value="'.set_value('choice3').'"';
                else
                    echo 'value="'.$donnees->choice_3.'"';
                ?> />
        <?php
        echo form_error('choice3'); 
        
        echo form_label('Réponse', 'answer', array('class' => 'answer')); 
        ?>
        <input type="text" id="answer" name="answer" 
            <?php
                if ( set_value('answer') )
                    echo 'value="'.set_value('answer').'"';
                else
                    echo 'value="'.$donnees->answer.'"';
                ?> />
        <?php
        echo form_error('answer'); 
        
        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $donnees->id));
        
        echo form_input(array('name' => 'Modifier', 'value' => 'Modifier', 'type' => 'submit')); 
        
        echo form_fieldset_close(); 
        echo form_close(); ?>
</section>