<?php 
    require('includes/connexion.php');
    $db = connect_bd();
    
    if(!empty($_POST)){
        //récupérer les données du formulaire
        $codecompteur = $_POST['code'];
        $type = $_POST['type'];
        $pu = $_POST['pu'];
        $client = $_POST['client'];
        
        //connexion à la BD
        $stmt = $db->prepare("INSERT INTO compteur VALUES(?,?,?,?)");
        $stmt->execute([$codecompteur, $client,$type,$pu]);
        //rediriger vers la page Liste des clients
        header('location:compteurs.php');
        die();
    }else{
        $stmt = $db->prepare("SELECT CodeCli,Nom FROM client");
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    include('includes/utils.php');
?> 
<!-- header ici -->
<?=template_header('Create')?>
<!-- contenu ici -->
<div class="content update">
    <form action="add_compteur.php" method="post">
        <div>
            <label>Code</label>
            <input type="text" name="code">
        </div>
        <div>
            <label>Type</label>
            <select  name="type" >
                <option value="ELECTRICITE">ELECTRICITE</option>
                <option value="EAU">EAU</option>         
            </select>
        </div>
        <div>
            <label>Prix unitaire</label>
            <input type="number" name="pu">
        </div>
        <div>
            <label>Client</label>
            <select  name="client" >
                <option value="">Choisir un client</option>
                <?php foreach($clients as $client): ?>
                <option value="<?=$client['CodeCli']?>"><?=$client['Nom']?></option>   
                <?php endforeach; ?>      
            </select>
        </div>
        <div>
            <input type="submit"  value="Enregistrer">
        </div>
    </form>
</div> <!-- fin contenu -->
<!-- footer ici -->
<?=template_footer()?>