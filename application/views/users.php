<?php
if (isset($msg))
    echo $msg;
?>

<section id="addUser">
    <h2>
        Ajouter un utilisateur
    </h2>
    <?= form_open('admin/addUser', array('method' => 'post', 'id' => 'addUserForm')); ?>
    <?= form_fieldset(); ?>
    <?= form_label('Nom d\'utilisateur', 'name'); ?>
    <?= form_input(array('name' => 'name', 'id' => 'name', 'placeholder' => 'Ex: John', 'type' => 'text')) ?>
    <?php if (isset($erreur['name'])) : ?>
        <p class="erreur">Entrez un nom d'utilisateur</p>
    <?php endif; ?>
    <?= form_label('Adresse mail', 'mail'); ?>
    <?= form_input(array('name' => 'mail', 'id' => 'mail', 'placeholder' => 'Ex: admin@hotmail.com', 'type' => 'mail')) ?>
    <?php if (isset($erreur['mail'])) : ?>
        <p class="erreur">Entrez une adresse mail</p>
    <?php endif; ?>
    <?= form_label('Mot de passe', 'pwd'); ?>
    <?= form_input(array('name' => 'pwd', 'id' => 'pwd', 'type' => 'password')) ?>
    <?php if (isset($erreur['pwd'])) : ?>
        <p class="erreur">Entrez un mot de passe</p>
    <?php endif; ?>     
    <?= form_input(array('name' => 'Ajouter', 'value' => 'Ajouter', 'type' => 'submit')) ?>
    <?= form_fieldset_close(); ?>
    <?= form_close(); ?>
</section>

<?php if (isset($donnees)) { ?>
    <section id="listUsers">        
        <h2>
            Liste des utilisateurs
        </h2>

        <table>
            <thead>
                <tr>
                    <th>
                        Nom d'utilisateur
                    </th>
                    <th>
                        Mail
                    </th>
                    <th>
                        ...
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donnees as $donnee) : ?>
                    <tr>
                        <td>
                            <?= $donnee->name; ?>
                        </td>
                        <td>
                            <?= $donnee->mail; ?>
                        </td>
                        <td>
                            <?php
                            if ($this->session->userdata('status_user') == 'admin') :
                                echo anchor('admin/seeOne/' . $donnee->id.'/user', '<p>Modifier</p>', array('title' => 'Modifier cet utilisateur', 'class' => 'modifier icon-pencil'));
                                if ($donnee->status !== 'admin'):  
                                    echo anchor('admin/confirme/' . $donnee->id.'/user', '<p>Supprimer</p>', array('title' => 'Supprimer cet utilisateur', 'class' => 'supprimer icon-trash'));
                                endif;
                            elseif ($donnee->status !== 'admin' && $this->session->userdata('id_user') == $donnee->id) :
                                echo anchor('admin/seeOne/' . $donnee->id.'/user', '<p>Modifier</p>', array('title' => 'Modifier cet utilisateur', 'class' => 'modifier icon-pencil'));
                                echo anchor('admin/confirme/' . $donnee->id.'/user', '<p>Supprimer</p>', array('title' => 'Supprimer cet utilisateur', 'class' => 'supprimer icon-trash'));
                            endif;
                            ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section> 
<?php } ?>