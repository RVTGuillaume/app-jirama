<?php 
    require('includes/connexion.php');
    $db = connect_bd();
    
    if(!empty($_POST)){
        //récupérer les données du formulaire
        $codereleve = $_POST['code'];
        $compteur = $_POST['compteur'];
        $valeur = $_POST['valeur'];
        $datereleve = $_POST['datereleve'];
        $datepresentation = $_POST['datepresentation'];
        $datelimite = $_POST['datelimite'];
        
        //connexion à la BD
        $stmt = $db->prepare("INSERT INTO releve VALUES(?,?,?,?,?,?)");
        $stmt->execute([$codereleve, $compteur,$valeur,$datereleve,$datepresentation,$datelimite]);

        $sql = "SELECT cp.CodeCli AS CodeCli,cp.Pu AS Pu FROM  compteur AS cp
                WHERE cp.CodeCompteur = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$compteur,]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if($res){
            $stmt = $db->prepare('INSERT INTO payer(Idpaye,CodeCli,Montant,CodeReleve) VALUES (?,?,?,?)');
            $idpaye = $codereleve + $compteur;
            $codecli = $res['CodeCli'];
            $montant = $valeur * $res['Pu'];
            $stmt->execute([$idpaye, $codecli,$montant,$codereleve]);
            
        }
        //rediriger vers la page Liste des clients
        header('location:releves.php');
        die();
    }else{
        $stmt = $db->prepare("SELECT CodeCompteur FROM compteur");
        $stmt->execute();
        $compteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    include('includes/utils.php');
?> 
<!-- header ici -->
<?=template_header('Create')?>
<!-- contenu ici -->
<div class="content update">
    <form action="add_releve.php" method="post">
        <div>
            <label>Code</label>
            <input type="text" name="code">
        </div>
        <div>
            <label>Valeur</label>
            <input type="number" name="valeur">
        </div>
        <div>
            <label>Date de relevé</label>
            <input type="date" name="datereleve">
        </div>
        <div>
            <label>Compteur</label>
            <select  name="compteur" >
                <option value="">Choisir un compteur</option>
                <?php foreach($compteurs as $compteur): ?>
                <option value="<?=$compteur['CodeCompteur']?>"><?=$compteur['CodeCompteur']?></option>   
                <?php endforeach; ?>      
            </select>
        </div>
        <div>
            <label>Date de présentation</label>
            <input type="date" name="datepresentation">
        </div>
        <div>
            <label>Date de limite de paiement</label>
            <input type="date" name="datelimite">
        </div>
        <div>
            <input type="submit"  value="Enregistrer">
        </div>
    </form>
</div> <!-- fin contenu -->
<!-- footer ici -->
<?=template_footer()?>