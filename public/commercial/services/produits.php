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
                            <li class="breadcrumb-item active">Produits et Commandes</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Produits et Commandes</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-sm-2">
                                <select id="etat_select" name="etat_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Flux physique</option>
                                    <option value="">Flux financier</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select id="filtrer_select" name="filtrer_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Tous les produits</option>
                                    <option value="">Tous les services</option>
                                    <option value="">Gérés en stock</option>
                                    <option value="">Stock = 0</option>
                                    <option value="">Stock > 0</option>
                                    <option value="">En commande client</option>
                                    <option value="">En commande fournisseur</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Réf.</th>
                                    <th>Désignation</th>
                                    <th>Unité</th>
                                    <th>Stock</th>
                                    <th>CC</th>
                                    <th>CF</th>
                                    <th>Stock Prev.</th>
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

<script>
$(document).ready(function() {

    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: [ /*'copy',*/ 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

});
</script>

<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>

<script src="../../script/produit.js?r=<?php echo rand();?>" type="text/javascript"></script>