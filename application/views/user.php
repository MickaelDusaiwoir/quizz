<section id="updateUser">
    <h2>
        Fiche de l'utilisateur&nbsp;: <?= $donnees->name; ?>
    </h2>

    <?= form_open('admin/updateUser', array('method' => 'post', 'id' => 'updateUserForm')); ?>
    <?= form_label('Nom d\'utilisateur', 'name'); ?>
    <input type="text" name="name" id="name" 
           <?php if ( isset($save->name) )
                    echo 'value="'.$save->name.'"';
               else
                    echo 'value="'.$donnees->name.'"';
               ?> />
    <?php if ( isset($erreur['name']) ) : ?>
        <p class="erreur">Entrez un nom d'utilisateur</p>
    <?php endif; ?>
    <?= form_label('Adresse mail', 'mail'); ?>
    <input type="mail" name="mail" id="mail" 
           <?php if ( isset($save->name) )
                    echo 'value="'.$save->mail.'"';
               else
                    echo 'value="'.$donnees->mail.'"';
               ?> />
    <?php if ( isset($erreur['mail']) ) : ?>
        <p class="erreur">Entrez une adresse mail</p>
    <?php endif; ?>
    <?= form_label('Mot de passe', 'pwd'); ?>
    <?= form_input(array('name' => 'pwd', 'id' => 'pwd', 'type' => 'password')) ?>
    <?php if ( isset($erreur['pwd']) ) : ?>
        <p class="erreur">Entrez un mot de passe</p>
    <?php endif; ?>    
    <?= form_input(array('type' => 'hidden', 'name' => 'id_user', 'id' => 'id_user', 'value' => $donnees->id)); ?>
    <?= form_input(array('name' => 'Modifier', 'value' => 'Modifier', 'type' => 'submit')) ?>
    <?= form_close(); ?>
        
</section>