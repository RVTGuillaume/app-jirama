<?php
    if(!empty($_GET['code'])){

        $codecli = $_GET['code'];
        $titre = "Edition d'un client";
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("SELECT * FROM client WHERE CodeCli = :code");
        $stmt->bindValue(':code', $codecli);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        //get and print results
        $client = $stmt->fetch();
    }
    include('includes/utils.php');
    $niveaux = array('VIP','REGULIER','FIDELE','NOUVEAU');
?>
<!-- insérer header ici -->
<?=template_header($titre)?>
<div class="content update">
    <form action="update_client.php" method="post">
        <div>
            <label>Code</label>
            <input type="text" name="code" value="<?=$client['CodeCli']?>" readonly>
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="nom" value="<?=$client['Nom']?>" >
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?=$client['Prenom']?>" >
        </div>
        <div>
            <label>Sexe</label>
            <div>
                <input type="radio" name="sexe" 
                        value="Masculin" <?php if($client['Sexe']=='MASCULIN') echo 'checked';?> >Macsulin
                <input type="radio" name="sexe" 
                        value="Féminin" <?php if($client['Sexe']=='FEMININ') echo 'checked';?> >Féminin
            </div>
        </div>
        <div>
            <label>Quartier</label>
            <input type="text" name="quartier" value="<?=$client['Quartier']?>" >
        </div>
        <div>
            <label>Niveau</label>
            <select  name="niveau" >
            <?php foreach($niveaux as $n): ?>
                <option value="<?=$n?>" <?php if($client['Niveau']==$n) echo 'selected';?> >
                    <?=$n?>
                </option>
            <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>E-mail</label>
            <input type="mail" name="mail" value="<?=$client['Mail']?>" >
        </div>
        <input type="submit"  value="Enregistrer">
    </form>
</div>
<!-- footer -->
<?=template_footer()?>