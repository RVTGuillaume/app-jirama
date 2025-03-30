<?php 
    require('includes/connexion.php');
    
    $db = connect_bd();
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 5;
    $num_clients = $db->query('SELECT COUNT(*) FROM client')->fetchColumn();

    $stmt = $db->prepare('SELECT * FROM client ORDER BY CodeCli LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //include('includes/utils.php');
?> 
<?php include('includes/header.php'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-table"></i> Data Table Example</div>
        <div class="card-body">
            <div class="table-responsive">
                <!-- Table here-->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Sexe</th>
                            <th>Quartier</th>
                            <th>Niveau</th>
                            <th>E-mail</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($clients as $client): ?>
                            <tr>
                                <td> <?=$client['CodeCli'];?></td>
                                <td><?=$client['Nom'];?></td>
                                <td><?=$client['Prenom'];?></td>
                                <td><?=$client['Sexe'];?></td>
                                <td><?=$client['Quartier'];?></td>
                                <td><?=$client['Niveau'];?></td>
                                <td><?=$client['Mail'];?></td>
                                <td><a href="edit_client.php?code=<?=$client['CodeCli'];?>" title="Editer" class="edit"><i class="fas fa-pen fa-xs"></i></a></td>
                                <td><a href="delete_client.php?code=<?=$client['CodeCli'];?>" title="Supprimer" class="trash"><i class="fas fa-trash fa-xs"></i></a></td>
                            </tr>
                    <?php endforeach;?>
                    </tbody>
                </table> <!-- End of table -->
            </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>
</div>

<?php include('includes/footer.php'); ?>          