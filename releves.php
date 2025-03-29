<?php 
    require('includes/connexion.php');
    
    $db = connect_bd();
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 5;
    
    $num_contacts = $db->query('SELECT COUNT(*) FROM releve')->fetchColumn();
    $stmt = $db->prepare('SELECT * FROM releve ORDER BY CodeReleve LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $releves = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include('includes/utils.php');
?> 
<?=template_header('Read')?>
<div class="content read">
	<h2>Liste des relevés</h2>
	<a href="add_releve.php" class="create-contact">Nouveau relevé</a>
        <table>
            <tr>
                <th>Code</th>
                <th>Compteur</th>
                <th>Valeur</th>
                <th>Date de relevé</th>
                <th>Date de présentation</th>
                <th>Date de limite de paiement</th>

                <th colspan="2">Actions</th>
            </tr>
            <?php foreach($releves as $releve): ?>
            <tr>
                <td><?=$releve['CodeReleve'];?></td>
                <td><?=$releve['CodeCompteur'];?></td>
                <td><?=$releve['Valeur'];?></td>
                <td><?=$releve['Date_releve'];?></td>
                <td><?=$releve['Date_presentation'];?></td>
                <td><?=$releve['Date_limite_paiement'];?></td>
                <td><a href="edit_releve.php?code=<?=$releve['CodeReleve'];?>">Editer</a></td>
                <td><a href="delete_releve.php?code=<?=$releve['CodeReleve'];?>">Supprimer</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
</div>
<div class="pagination">
	<?php if ($page > 1): ?>
	<a href="releves.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
	<?php endif; ?>
	<?php if ($page*$records_per_page < $num_contacts): ?>
	<a href="releves.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
	<?php endif; ?>
</div>
<?=template_footer()?>