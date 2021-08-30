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
                            <li class="breadcrumb-item"><a href="<?php echo __VENTESFOLDER__; ?>">Ventes</a></li>
                            <li class="breadcrumb-item active">Commandes</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bons de commande</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="btn-group">
                            <button id="nouveau_btn" class="btn btn-success btn-sm" role="button"><i
                                    class="mdi mdi-account-plus"></i> Nouveau</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row section2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="client_select" class="col-sm-2 col-form-label">Client </label>
                                        <div class="col-sm-4">
                                            <select id="client_select" name="client_select"
                                                class="form-control form-control-sm custom-select">
                                                <option hidden>Choisir</option>
                                            </select>
                                        </div>
                                        <label for="mode_input" class="col-sm-2 col-form-label">Mode de réglement </label>
                                        <div class="col-sm-4">
                                            <select id="mode_input" name="mode_input"
                                                        class="form-control form-control-sm custom-select">
                                                        <option hidden>Choisir</option>
                                                        <option value="espèce">Espèce</option>
                                                        <option value="chèque">Chèque</option>
                                                        <option value="effet">Effet</option>
                                                        <option value="avoir">Avoir</option>
                                                        <option value="virement">Virement</option>
                                                        <option value="solde">Solde excel</option>
                                                        <option value="bon">Bon de livraison</option>
                                                    </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_input" class="col-sm-2 col-form-label">Date</label>
                                        <div class="col-sm-4">
                                            <input class="form-control form-control-sm" type="date" value=""
                                                id="date_input" name="date_input">
                                        </div>
                                        <label for="devis_date" class="col-sm-2 col-form-label">Date Devis</label>
                                        <div class="col-sm-4">
                                            <input class="form-control form-control-sm" type="date" value=""
                                                id="devis_date" name="devis_date" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
										<label for="address_client" class="col-sm-2 col-form-label">Adresse </label>
                                        <div class="col-sm-4">
                                            <div id="address_client">
                                            </div>
                                        </div>
                                        <label for="remise_input1" class="col-sm-2 col-form-label">Remise </label>
                                        <div class="col-sm-4">
                                            <div id="remise_input1"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
										<label class="col-sm-2 col-form-label">Statut</label>
                                        <div class="col-sm-4" id="checkStatus">
                                            <span id="checkStatusBadge" style="margin-right:5px;font-size:large;"></span>
                                        </div>
                                        <label for="NumDevis" class="col-sm-2 col-form-label">N° Devis </label>
                                        <div class="col-sm-4">
                                            <div id="NumDevis">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="NumCommande" class="col-sm-2 col-form-label">N° Commande </label>
                                        <div class="col-sm-4">
                                            <div id="NumCommande">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <div class="row section2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <button id="enregistrer_btn" class="btn btn-primary btn-sm ml-2 mr-2 float-right"
                            role="button"><i class="mdi mdi-content-save"></i>
                            <span>Enregistrer</span></button>
                        <button id="annuler_btn" class="btn btn-warning btn-sm float-right" role="button"><i
                                class="mdi mdi-close"></i>
                            Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-commandes" class="table table-striped table-bordered w-100">
                            <thead>
                                 <tr>
                                    <th>Etat</th>
                                    <th>Commande N°</th>
                                    <th>Devis N°</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Montant HT</th>
                                    <th>TVA</th>
                                    <th>Montant TTC</th>
                                    <th></th>
                                    <!--<th>Délai Livraison</th>
                                    <th>Montant TTC</th>-->
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
<!--  Modal content for the above example -->
<div class="modal fade commande-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"><span class="date_modal"></span><span
                            class="client_modal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row addsection">
                    <div class="form-group col-md-12 produit row">
                        <label for="produit_select" class="col-sm-1 col-form-label">Produit
                        </label>
                        <div class="col-sm-11 d-flex">
                            <!--
                             <input list="produit_select" class="form-control form-control-sm mr-">
                            <datalist id="produit_select" name="produit_select"
                                class="form-control form-control-sm mr-2 custom-select">
                            </datalist>
                            -->
                            <select id="produit_select" name="produit_select"
                                    class="form-control form-control-sm mr-2 custom-select" placeholder="Chercher un produit...">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4 prix row">
                        <label for="prix_input" class="col-sm-3 col-form-label"> Prix
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control form-control-sm" id="prix_input" name="prix_input" type="number" min="0" value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$"
                                   onchange="this.value = this.checkValidity()? this.value : this.attributes['min'].value"
                                   oninput="this.checkValidity()? this.classList.remove('parsley-error-focus'):this.classList.add('parsley-error-focus')">
                        </div>
                    </div>
                    <div class="form-group col-md-4 quantite row">
                        <label for="quantite_input" class="col-sm-8 col-form-label"> Quantite (<span id="quantitemax_span" class="text-danger"></span>)
                        </label>
                        <div class="col-sm-4">
                            <input class="form-control form-control-sm" id="quantite_input" name="quantite_input" type="number" min="0" value="0"
                                   onchange="this.value = this.checkValidity()? this.value : this.attributes['min'].value"
                                   oninput="this.checkValidity()? this.classList.remove('parsley-error-focus'):this.classList.add('parsley-error-focus')">
                        </div>
                    </div>
                    <div class="form-group col-md-4 remise row">
                        <label for="remise_input" class="col-sm-6 col-form-label"> Remise (<span id="remisemax_span" class="text-danger"></span>)
                        </label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" id="remise_input" name="remise_input" type="number" min="0" value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$"
                                   onchange="this.value = this.checkValidity()? this.value : this.attributes['max'].value"
                                   oninput="this.checkValidity()? this.classList.remove('parsley-error-focus parsley-error'):this.classList.add('parsley-error-focus')">
                        </div>
                    </div>
                    <div class="col-sm-12 row">
                        <label class="col-sm-3 col-form-label"> Prix Unitaire
                        </label>
                        <label id="totalprix" class="col-sm-9" style="align-items: center;display: flex; justify-content: flex-start;"></label>
                    </div>
                    <div class="col-sm-12 row">
                        <label class="col-sm-3 col-form-label"> Prix Total
                        </label>
                        <label id="_totalprix" class="col-sm-9" style="align-items: center;display: flex; justify-content: flex-start;"></label>
                    </div>
                    <div class="col-sm-12 row">
                            <label class="col-sm-3 col-form-label">Statut</label>
                            <div class="col-sm-9" id="checkStatus1" style="align-items: center;display: flex; justify-content: flex-start;">
                                <span id="checkStatusBadge1" style="margin-right:5px;font-size:large;"></span>
                            </div>
                        </div>
                    <div class="form-group col-md-12">
                        <button id="ajouter_btn" class="btn btn-primary btn-sm ml-2 mr-2 float-right" role="button"
                                op="N"><i class="mdi mdi-content-save"></i>
                            Ajouter</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="dt-buttons exportsection btn-group">
                            <a class="btn btn-secondary btn-excel buttons-html5" tabindex="0"
                               aria-controls="datatable-commande" href="#"><span>Excel</span></a>
                            <a class="btn btn-secondary btn-pdf buttons-html5" tabindex="0"
                               data-toggle="modal" data-animation="bounce" data-target=".pdf-modal"   href="#"><span>PDF</span></a>
                        </div>
                        <button id="transferer_btn" class="btn btn-success btn-sm mr-5 float-right"
                                role="button"><i class="fas fa-share"></i>
                            <span>Transferer</span></button>
                    </div>
                </div>
                <table class="table" id="commande-table">
                    <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantite</th>
                        <th>Total HT</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade pdf-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"><span class="date_modal"></span><span
                            class="client_modal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="height: 90vh;">
                <row>
                    <iframe id="pdfHolder" frameborder="0" style="position:absolute; top:0;bottom:0;right:0;left:0; height:100%; width:100%">

                    </iframe>
                </row>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- /.modal -->
<script>
$(document).ready(function() {
    $(".section2").hide();
    $("#nouveau_btn").click(function() {
        $("#enregistrer_btn").find("span:eq(0)").text("Enregistrer");
        $("#enregistrer_btn").attr("op", "N");
        $(".section1").hide();
        $(".section2").show();
    });
    $("#annuler_btn").click(function() {
        $("#enregistrer_btn").find("span:eq(0)").text("Enregistrer");
        $("#enregistrer_btn").attr("op", "N");
        $(".section2").hide();
        $(".section1").show();
    });
});
</script>

<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>

<script src="../../script/commandevente.js?r=<?php echo rand();?>" type="text/javascript"></script>
