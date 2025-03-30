<?php 
    require('includes/connexion.php');
    
    $db = connect_bd();
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 5;
    
    $num_comteurs = $db->query('SELECT COUNT(*) FROM compteur')->fetchColumn();
    $stmt = $db->prepare('SELECT * FROM compteur ORDER BY CodeCompteur LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $compteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include('includes/utils.php');
?> 
<!-- insérer header ici -->
<?php include('includes/header.php'); ?>
<!-- contenu va ici -->
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Compteurs</li>
        </ol>
      <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Liste des compteurs
            </div>
            <div class="card-body">
                <a href="add_compteur.php" class="btn btn-primary"> Nouveau</a>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Prix unitaire</th>
                                <th>Client</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($compteurs):
                            foreach($compteurs as $compteur): ?>
                            <tr>
                                <td><?=$compteur['CodeCompteur'];?></td>
                                <td><?=$compteur['TypeCompteur'];?></td>
                                <td><?=$compteur['Pu'];?></td>
                                <td><?=$compteur['CodeCli'];?></td>
                                <td><a href="edit_compteur.php?code=<?=$compteur['CodeCompteur'];?>">Editer</a></td>
                                <td><a href="delete_compteur.php?code=<?=$compteur['CodeCompteur'];?>">Supprimer</a></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="6" style="text-align:center;">Pas de données à afficher</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <?php if ($page > 1): ?> 
                    <a href="compteurs.php?page=<?=$page-1?>">&lt;&lt;<i class="fas fa-angle-double-left fa-sm"></i></a>
                    <?php endif; ?>
                    <?php if ($page*$records_per_page < $num_comteurs): ?>
                    <a href="compteurs.php?page=<?=$page+1?>"> &gt;&gt;<i class="fas fa-angle-double-right fa-sm"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer -->
<?php include('includes/footer.php'); ?>