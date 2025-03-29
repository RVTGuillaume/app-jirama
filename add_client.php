<?php 

    if(!empty($_POST)){
        //récupérer les données du formulaire
        $codecli = $_POST['code'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $sexe = $_POST['sexe'];
        $quartier = $_POST['quartier'];
        $niveau = $_POST['niveau'];
        $mail = $_POST['mail'];
        //connexion à la BD
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("INSERT INTO client VALUES(?,?,?,?,?,?,?)");
        $stmt->execute([$codecli, $nom,$prenom,$sexe,$quartier,$niveau,$mail]);
        //rediriger vers la page Liste des clients
        header('location:clients.php');
        die();
    }
    include('includes/utils.php');
?> 
<!-- header ici -->
<?=template_header('Create')?>
<!-- contenu ici -->
<div class="content update">
    <form action="add_client.php" method="post">
        <div>
            <label>Code</label>
            <input type="text" name="code">
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="nom">
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="prenom">
        </div>
        <div>
            <label>Sexe</label>
            <div>
                <input type="radio" name="sexe" value="Masculin" checked >Macsulin
                <input type="radio" name="sexe" value="Féminin">Féminin
            </div>
        </div>
        <div>
            <label>Quartier</label>
            <input type="text" name="quartier">
        </div>
        <div>
            <label>Niveau</label>
            <select  name="niveau" >
                <option value="VIP">VIP</option>
                <option value="REGULIER">REGULIER</option>
                <option value="FIDELE">FIDELE</option>
                <option value="NOUVEAU">NOUVEAU</option>         
            </select>
        </div>
        <div>
            <label>E-mail</label>
            <input type="mail" name="mail">
        </div>
        <input type="submit"  value="Enregistrer">
    </form>
</div> <!-- fin contenu -->
<!-- footer ici -->
<?=template_footer()?>