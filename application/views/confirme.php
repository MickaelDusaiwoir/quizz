<div id="confirme">
    <h3>
        Tous suppression est définitive&nbsp;! Voulez vous vraiment supprimer cette <?= $content ?>&nbsp;?
    </h3>
    <div>
    <?= anchor('admin/remove/' . $id.'/'.$content, 'Oui', array('title' => 'Confirmer la supprison')); ?>
    <?php 
        if ( $content == 'question' )
            echo anchor('admin/getListQuestion', 'Non', array('title' => 'Retourner voir les question'));
        else
            echo anchor('admin/listUsers', 'Non', array('title' => 'Retourner voir les utilisateur'));
    ?>
    </div>
</div>