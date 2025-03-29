<?php 
    //https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/

    require('includes/connexion.php');
    
    $db = connect_bd();

    if(isset($_GET['code']) && !empty($_GET['code'])){
        $stmt = $db->prepare("SELECT * FROM compteur WHERE CodeCompteur = ?");
        $stmt->execute([$_GET['code']]);
        $compteur = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // supprimer ce client si l'Utilisateur a cliqué sur le bouton Confirm
        $stmt = $db->prepare('DELETE FROM compteur WHERE CodeCompteur = ?');
        $stmt->execute([$_GET['code']]);
        //rediriger vers la page Liste des clients   
        header('Location: compteurs.php');
        die();
    }
    include('includes/utils.php');
?> 

<?=template_header('Supprimer')?>

<div class="content delete">
	<h2>Supprimer un client.</h2>
    <p>Code: <?=$compteur['CodeCompteur']?> </p>
    <p>Client: <?=$compteur['CodeCli']?> </p>
    <p>Type: <?=$compteur['TypeCompteur']?> </p>
    <p>Prix unitaire: <?=$compteur['Pu']?> </p>
    &nbsp;
    <p>Voulez-vous vraiement supprimer le compteur<?=$compteur['CodeCompteur']?>?</p>
    <div class="yesno">
        <a href="delete_compteur.php?code=<?=$compteur['CodeCompteur']?>&confirm=yes">Oui</a>
        <a href="compteurs.php">Non</a>
    </div>
</div>
<?=template_footer()?>