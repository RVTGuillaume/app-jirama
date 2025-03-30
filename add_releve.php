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
<!-- header ici -->
<?php include('includes/header.php'); ?>  
<!-- contenu ici -->
<div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Relevés</li>
            </ol>
            <div class="row">
                <div class="col-12">
                    <h1>Nouveau Relevé</h1>
                </div>
                <div class="col-md-8">
    <form action="add_releve.php" method="post">
        <div class="form-group">
            <label>Code</label>
            <input type="text" name="code" class="form-control">
        </div>
        <div class="form-group">
            <label>Valeur</label>
            <input type="number" name="valeur" class="form-control">
        </div>
        <div class="form-group">
            <label>Date de relevé</label>
            <input type="date" name="datereleve" class="form-control">
        </div>
        <div class="form-group">
            <label>Compteur</label>
            <select  name="compteur" class="form-control" >
                <option value="">Choisir un compteur</option>
                <?php foreach($compteurs as $compteur): ?>
                <option value="<?=$compteur['CodeCompteur']?>"><?=$compteur['CodeCompteur']?></option>   
                <?php endforeach; ?>      
            </select>
        </div>
        <div class="form-group">
            <label>Date de présentation</label>
            <input type="date" name="datepresentation" class="form-control">
        </div>
        <div class="form-group">
            <label>Date de limite de paiement</label>
            <input type="date" name="datelimite" class="form-control">
        </div>
        <input type="submit"  value="Enregistrer" class="btn btn-primary">
    </form>
    </div>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>  