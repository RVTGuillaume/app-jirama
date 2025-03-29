<?php 
    //https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/

    require('includes/connexion.php');
    
    $db = connect_bd();

    if(isset($_GET['code']) && !empty($_GET['code'])){
        $stmt = $db->prepare("SELECT * FROM client WHERE CodeCli = ?");
        $stmt->execute([$_GET['code']]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // supprimer ce client si l'Utilisateur a cliqué sur le bouton Confirm
        $stmt = $db->prepare('DELETE FROM client WHERE CodeCli = ?');
        $stmt->execute([$_GET['code']]);
        //rediriger vers la page Liste des clients   
        header('Location: clients.php');
        die();
    }
    include('includes/utils.php');
?> 

<?=template_header('Supprimer')?>

<div class="content delete">
	<h2>Supprimer un client.</h2>
    <p>Nom: <?=$client['Nom']?> </p>
    <p>Prénoms: <?=$client['Prenom']?> </p>
    <p>Quartier: <?=$client['Quartier']?> </p>
    &nbsp;
    <p>Voulez-vous vraiement supprimer le client <?=$client['CodeCli']?>?</p>
    <div class="yesno">
        <a href="delete_client.php?code=<?=$client['CodeCli']?>&confirm=yes">Oui</a>
        <a href="clients.php">Non</a>
    </div>
</div>
<?=template_footer()?>