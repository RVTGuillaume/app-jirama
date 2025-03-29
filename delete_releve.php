<?php 
    //https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/

    require('includes/connexion.php');
    
    $db = connect_bd();

    if(isset($_GET['code']) && !empty($_GET['code'])){
        $stmt = $db->prepare("SELECT * FROM releve WHERE CodeReleve = ?");
        $stmt->execute([$_GET['code']]);
        $releve = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // supprimer ce client si l'Utilisateur a cliqué sur le bouton Confirm
        $stmt = $db->prepare('DELETE FROM releve WHERE CodeReleve = ?');
        $stmt->execute([$_GET['code']]);
        //rediriger vers la page Liste des clients   
        header('Location: releves.php');
        die();
    }
    include('includes/utils.php');
?> 

<?=template_header('Supprimer')?>

<div class="content delete">
	<h2>Supprimer un relevé</h2>
    <p>Code: <?=$releve['CodeReleve']?> </p>
    <p>Compteur: <?=$releve['CodeCompteur']?> </p>
    <p>Valeur: <?=$releve['Valeur']?> </p>
    <p>Date du relevé: <?=$releve['Date_releve']?> </p>
    <p>Date de presentation: <?=$releve['Date_presentation']?> </p>
    <p>Date de limite de paiement: <?=$releve['Date_limite_paiement']?> </p>

    &nbsp;
    <p>Voulez-vous vraiement supprimer le releve  <?=$releve['CodeReleve']?>?</p>
    <div class="yesno">
        <a href="delete_releve.php?code=<?=$releve['CodeReleve']?>&confirm=yes">Oui</a>
        <a href="releves.php">Non</a>
    </div>
</div>
<?=template_footer()?>