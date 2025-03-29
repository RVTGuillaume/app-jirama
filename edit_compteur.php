<?php
    if(!empty($_GET['code'])){

        $compteur = $_GET['code'];
        $titre = "Edition d'un client";
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("SELECT * FROM compteur WHERE CodeCompteur = :code");
        $stmt->bindValue(':code', $compteur);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        //get and print results
        $compteur = $stmt->fetch();
    }
    include('includes/utils.php');
   
?>
<!-- insérer header ici -->
<?=template_header($titre)?>
<div class="content update">
    <form action="update_compteur.php" method="post">
        <div>
            <label>Code</label>
            <input type="text" name="code" value="<?=$compteur['CodeCompteur']?>" readonly>
        </div>
        <div>
            <label>Client</label>
            <input type="text" name="client" value="<?=$compteur['CodeCli']?>" >
        </div>
        <div>
            <label>Type</label>
            <div>
                <input type="radio" name="type" 
                        value="EAU" <?php if($compteur['TypeCompteur']=='EAU') echo 'checked';?> >EAU
                <input type="radio" name="type" 
                        value="ELECTRICITE" <?php if($compteur['TypeCompteur']=='ELECTRICITE') echo 'checked';?> >ELECTRICITE
            </div>
        </div>
        <div>
            <label>Prix unitaire</label>
            <input type="number" name="pu" value="<?=$compteur['Pu']?>" >
        </div>
        <div>
        <input type="submit"  value="Enregistrer">
        </div>
    </form>
</div>
<!-- footer -->
<?=template_footer()?>