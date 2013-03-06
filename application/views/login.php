<div id="login">
    <?= form_open('admin/login', array('method' => 'post')); ?>
    <?= form_label("Nom d'utilisateur", 'name'); ?>
    <?= form_input(array('name' => 'name', 'id' => 'name', 'placeholder' => 'Ex: John', 'type' => 'text')); ?>
    <?= form_label('Mot de passe', 'pwd'); ?>
    <?= form_input(array('name' => 'pwd', 'id' => 'pwd', 'type' => 'password')); ?>
    <?php if ( isset($erreur) ) : ?>
        <p class="erreur">Vérifiez votre nom d'utilisateur et/ou votre mot de passe</p>
    <?php endif; ?>    
    <?= form_input(array('name' => 'Connection', 'value' => 'Connection', 'type' => 'submit')); ?>
    <?= form_close(); ?>
</div>

