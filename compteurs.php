<?php 
    require('includes/connexion.php');
    
    $db = connect_bd();
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 5;
    
    $num_contacts = $db->query('SELECT COUNT(*) FROM compteur')->fetchColumn();
    $stmt = $db->prepare('SELECT * FROM compteur ORDER BY CodeCompteur LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $compteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include('includes/utils.php');
?> 
<?=template_header('Read')?>
<div class="content read">
	<h2>Liste des compteurs</h2>
	<a href="add_compteur.php" class="create-contact">Nouveau compteur</a>
        <table>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Prix unitaire</th>
                <th>Client</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php foreach($compteurs as $compteur): ?>
            <tr>
                <td><?=$compteur['CodeCompteur'];?></td>
                <td><?=$compteur['TypeCompteur'];?></td>
                <td><?=$compteur['Pu'];?></td>
                <td><?=$compteur['CodeCli'];?></td>
                <td><a href="edit_compteur.php?code=<?=$compteur['CodeCompteur'];?>">Editer</a></td>
                <td><a href="delete_compteur.php?code=<?=$compteur['CodeCompteur'];?>">Supprimer</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
</div>
<div class="pagination">
	<?php if ($page > 1): ?>
	<a href="compteurs.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
	<?php endif; ?>
	<?php if ($page*$records_per_page < $num_contacts): ?>
	<a href="compteurs.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
	<?php endif; ?>
</div>
<?=template_footer()?>