<?php
    if(!empty($_GET['code'])){

        $releve = $_GET['code'];
        $titre = "Edition d'un relevé";
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("SELECT * FROM releve WHERE CodeReleve = :code");
        $stmt->bindValue(':code', $releve);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        //get and print results
        $releve = $stmt->fetch();
    }
    include('includes/utils.php');
   
?>
<!-- insérer header ici -->
<?=template_header($titre)?>
<div class="content update">
    <form action="update_releve.php" method="post">
        <div>
            <label>Code</label>
            <input type="text" name="code" value="<?=$releve['CodeReleve']?>" readonly>
        </div>
        <div>
            <label>Compteur</label>
            <input type="text" name="compteur" value="<?=$releve['CodeCompteur']?>" readonly >
        </div>
        <div>
            <label>Valeur</label>
            <input type="number"  min="0" name="valeur" value="<?=$releve['Valeur']?>" >
        </div>
        <div>
            <label>Date du relevé</label>
            <input type="date" name="datereleve" value="<?=$releve['Date_releve']?>" >
        </div>
        <div>
            <label>Date du présentation</label>
            <input type="date" name="datepresentation" value="<?=$releve['Date_presentation']?>" >
        </div>
        <div>
            <label>Date du limite de paiment</label>
            <input type="date" name="datelimite" value="<?=$releve['Date_limite_paiement']?>" >
        </div>
        <div>
        <input type="submit"  value="Enregistrer">
        </div>
    </form>
</div>
<!-- footer -->
<?=template_footer()?>