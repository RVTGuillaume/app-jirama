<?php 
    //https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/
    
    if(!empty($_POST)){
        //récupérer les données mises à jour du formulaire
        $codecompteur = $_POST['code'];
        $client = $_POST['client'];
        $type = $_POST['type'];
        $pu = $_POST['pu'];
        //connexion à la BD
        require('includes/connexion.php');
        $db = connect_bd();
        //Mettre à jour un client avec codecli = code
        $stmt = $db->prepare("UPDATE compteur SET  CodeCli = ?, 
                      TypeCompteur= ?, Pu = ? WHERE CodeCompteur = ?");
        $stmt->execute([$client,$type,$pu,$codecompteur]);
        //rediriger vers la page Liste des clients
        header('location:compteurs.php');
        die();
    }
    
?> 