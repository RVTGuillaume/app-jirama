<?php 
     require('includes/connexion.php');
    
     $db = connect_bd();

    if(isset($_GET['code'])){
        $stmt = $db->prepare("UPDATE payer SET Etat = ? WHERE Idpaye = ?");
        $stmt->execute([1,$_GET['code']]);
    }
    
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
     // Number of records to show on each page
     $records_per_page = 5;
     $num_paiements = $db->query('SELECT COUNT(*) FROM payer')->fetchColumn();
     
    $stmt = $db->prepare('SELECT * FROM payer ORDER BY Idpaye LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //include('includes/utils.php');
?>
<?php include('includes/header.php'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Paiements</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-table"></i> Liste des paiements</div>
        <div class="card-body">
            <div class="table-responsive">
                <!-- Table here-->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>Code de paiement</th>
                        <th>Client</th>
                        <th>Relevé</th>
                        <th>Montant</th>
                        <th>Date de paiement</th>
                        <th>Etat</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    <?php foreach($paiements as $paiement): ?>
                    <tr>
                        <td> <?=$paiement['Idpaye'];?></td>
                        <td><?=$paiement['CodeCli'];?></td>
                        <td><?=$paiement['CodeReleve'];?></td>
                        <td><?=$paiement['Montant'];?></td>
                        <td><?=$paiement['Date_paiement'];?></td>
                        <?php if($paiement['Etat'] == 0): ?>
                        <td>Non payé</td>
                        <?php else: ?>
                        <td>Payé</td>
                        <?php endif; ?>
                        <td><a href="paiements.php?code=<?=$paiement['Idpaye'];?>" title="Editer" class="edit"><i class="fas fa-pen fa-xs"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            </div>
        </div>
        <div class="card-footer small text-muted"><?php if ($page > 1): ?> 
                <a href="paiements.php?page=<?=$page-1?>">&lt;&lt;<i class="fas fa-angle-double-left fa-sm"></i></a>
                <?php endif; ?>
                <?php if ($page*$records_per_page < $num_paiements): ?>
                <a href="paiements.php?page=<?=$page+1?>"> &gt;&gt;<i class="fas fa-angle-double-right fa-sm"></i></a>
                <?php endif; ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?> 
