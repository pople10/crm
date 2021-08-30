<?php
chdir('..');
chdir('..');
include_once './template/header.php';

?>


<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __SERVICESFOLDER__; ?>">Produits &
                                    Services</a></li>
                            <li class="breadcrumb-item active">Alertes
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Alertes de retard des paiments
                    </h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 datatable-btns mb-2"></div>
                        </div>
                        <table id="datatable-produits" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Client</th>
                                <th>Type</th>
                                <th>N° Facture</th>
                                <th>Date</th>
                                <th style="color:black">Durée de retard (en jours)</th>
                                <th>Montant TTC</th>
                                <th>Payée</th>
                                <th>Reste à Payer</th>
                                <th>Blocage</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<!-- Footer -->
<?php
include_once './template/footer.php';
?>

<script src="../../script/alertesretardpaiments.js?r=<?php echo rand();?>" type="text/javascript"></script>