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
                    <h4 class="page-title">Alertes de rupture de stock
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
                                <th></th>
                                <th>Référence</th>
                                <th>Désignation</th>
                                <th>Unité</th>
                                <th>Quantité en stock</th>
                                <th>Tarif HT</th>
                                <th>Tarif TTC</th>
                                <th>Commander</th>
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
    <div class="modal fade" id="commandeModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Commander le produit - <span id="reference"></span></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="quantityChosen">Quantité (<span id="quantitemax_span" class="text-danger"></span>)</label>
                </div>
                <div class="col-sm-6">
                    <input id="quantityChosen" name="quantityChosen" type="number" min="0" max="" class="form-control form-control-sm">
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-sm-6">
                    <label for="supplierChosen">Fournisseur</label>
                </div>
                <div class="col-sm-6">
                    <select id="supplierChosen" name="supplierChosen" type="number" class="form-control form-control-sm custom-select">
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-sm-6">
                    <label for="date_input1">Date</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control form-control-sm" type="date" value="" id="date_input1" name="date_input1" max="">
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-sm-6">
                    <label for="price">Prix</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control form-control-sm" id="price" name="price" type="number" min="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$">
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-sm-6">
                    <label>Prix Total</label>
                </div>
                <div class="col-sm-6">
                    <span id="priceTotal">0.00</span>
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-sm-12">
                    <center>
                        <button id="commanderButton" data-reference="" class="btn btn-primary">Commander</button>
                    </center>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer -->
<?php
include_once './template/footer.php';
?>

<script src="../../script/alertes.js?r=<?php echo rand();?>" type="text/javascript"></script>