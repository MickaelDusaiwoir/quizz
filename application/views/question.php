<?php
if (isset($msg))
    echo $msg;
?>

<section id="addQuestion">
    <h2>
        Ajouter une question
    </h2>
    <?= form_open('admin/addQuestion', array('method' => 'post', 'id' => 'addQuestionForm')); ?>
    <?= form_label('Question', 'quest'); ?>
    <?= form_textarea(array('name' => 'quest', 'id' => 'quest', 'placeholder' => 'Ex: La salade et les tomates je les mange en&nbsp;?', 'type' => 'text')) ?>
    <?php if (isset($erreur['quest'])) : ?>
        <p class="erreur">Entrez une question</p>
    <?php endif; ?>
        
    <?= form_label('Proposition N°1', 'choice1'); ?>
    <?= form_input(array('name' => 'choice1', 'id' => 'choice1', 'placeholder' => 'Ex: &Eacute;té', 'type' => 'text')) ?>
    <?php if (isset($erreur['choice1'])) : ?>
        <p class="erreur">Entrez une proposition</p>
    <?php endif; ?>
        
    <?= form_label('Proposition N°2', 'choice2'); ?>
    <?= form_input(array('name' => 'choice2', 'id' => 'choice2', 'placeholder' => 'Ex: Automne', 'type' => 'text')) ?>
    <?php if (isset($erreur['choice2'])) : ?>
        <p class="erreur">Entrez une proposition</p>
    <?php endif; ?>
        
    <?= form_label('Proposition N°3', 'choice3'); ?>
    <?= form_input(array('name' => 'choice3', 'id' => 'choice3', 'placeholder' => 'Ex: Hiver', 'type' => 'text')) ?>
    <?php if (isset($erreur['choice3'])) : ?>
        <p class="erreur">Entrez une proposition</p>
    <?php endif; ?>   
     
    <?= form_label('Réponse', 'answer'); ?>
    <?= form_input(array('name' => 'answer', 'id' => 'answer', 'placeholder' => 'Ex: &Eacute;té', 'type' => 'text')) ?>
    <?php if (isset($erreur['answer'])) : ?>
        <p class="erreur">Entrez la bonne r&eacute;ponse </p>
    <?php endif; ?>    
        
    <?= form_input(array('name' => 'Ajouter', 'value' => 'Ajouter', 'type' => 'submit')) ?>
    <?= form_close(); ?>
</section>

<section id="listQuest">
    <h2>
        Liste des questions
    </h2>
    
    
        
    
</section>