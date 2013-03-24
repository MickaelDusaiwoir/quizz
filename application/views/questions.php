<?php
if (isset($msg))
    echo $msg;
?>

<section id="addQuestion">
    <h2>
        Ajouter une question
    </h2>
    <?php 
        echo form_open('admin/addQuestion', array('method' => 'post', 'id' => 'addQuestionForm')); 
        echo form_fieldset(); 
        
        echo form_label('Question', 'quest'); 
        echo form_textarea(array('name' => 'quest', 'id' => 'quest', 'placeholder' => 'Ex: La salade et les tomates je les mange en&nbsp;?', 'value' => set_value('quest'))); 
        echo form_error('quest'); 
        
        echo form_label('Proposition N°1', 'choice1'); 
        echo form_input(array('name' => 'choice1', 'id' => 'choice1', 'placeholder' => 'Ex: &Eacute;té', 'type' => 'text', 'value' => set_value('choice1'))); 
        echo form_error('choice1'); 
        
        echo form_label('Proposition N°2', 'choice2'); 
        echo form_input(array('name' => 'choice2', 'id' => 'choice2', 'placeholder' => 'Ex: Automne', 'type' => 'text', 'value' => set_value('choice2'))); 
        echo form_error('choice2'); 
        
        echo form_label('Proposition N°3', 'choice3'); 
        echo form_input(array('name' => 'choice3', 'id' => 'choice3', 'placeholder' => 'Ex: Hiver', 'type' => 'text', 'value' => set_value('choice3')));
        echo form_error('choice3'); 
        
        echo form_label('Réponse', 'answer', array('class' => 'answer')); 
        echo form_input(array('name' => 'answer', 'id' => 'answer', 'placeholder' => 'Ex: &Eacute;té', 'type' => 'text', 'value' => set_value('answer')));
        echo form_error('answer'); 
        
        echo form_input(array('name' => 'Ajouter', 'value' => 'Ajouter', 'type' => 'submit')); 
        
        echo form_fieldset_close(); 
        echo form_close(); ?>
</section>

<section id="listQuest">
    <h2>
        Liste des questions
    </h2>
<?php if ( isset($donnees) && count($donnees) !== 0 ) : ?>
    <ul>
        <?php foreach ( $donnees as $donnee ) : ?>
        <li class="question">
            <h3>
                Question&nbsp;:
            </h3>
            <p>
                <?= $donnee->question; ?>
            </p>
            <ul>
                <li>
                    <?= $donnee->choice_1; ?>
                </li>
                <li>
                    <?= $donnee->choice_2; ?>
                </li>
                <li>
                    <?= $donnee->choice_3; ?>
                </li>
            </ul>            
            <p>
                R&eacute;ponse&nbsp;:<em><?= $donnee->answer ?></em>
            </p>
            <div class="actionQuest">
                <?php
                    echo anchor('admin/seeOne/' . $donnee->id.'/question', '<p>Modifier</p>', array('title' => 'Modifier cette question', 'class' => 'modifier icon-pencil'));
                    echo anchor('admin/confirme/' . $donnee->id.'/question', '<p>Supprimer</p>', array('title' => 'Supprimer cette question', 'class' => 'supprimer icon-trash'));
                ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>
        Il n'y a aucune question
    </p>
<?php endif; ?>

</section>