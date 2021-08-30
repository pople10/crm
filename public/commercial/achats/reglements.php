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
                            <li class="breadcrumb-item"><a href="<?php echo __ACHATSFOLDER__; ?>">Comptabilité</a></li>
                            <li class="breadcrumb-item active">Règlements</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Règlements</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="date-range" class="col-sm-12 col-form-label">Periode
                                </label>
                                <div class="col-sm-12">
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" id="datedu_input"
                                               name="du" placeholder="Date début" />
                                        <div class="input-group-addon">Au</div>
                                        <input type="text" class="form-control" id="dateau_input"
                                               name="au" placeholder="Date fin" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="fournisseur_select" class="col-sm-12 col-form-label">Fournisseurs
                                </label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <select id="fournisseur_select" name="fournisseur_select"
                                                class="form-control form-control-sm custom-select">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="types_select" class="col-sm-12 col-form-label">Types
                                </label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <select id="types_select" name="types_select"
                                                class="form-control form-control-sm custom-select">
                                            <option value="">Tous </option>
                                            <option value="Non réglée" data-table="facture">Factures non réglées</option>
                                            <option value="Réglée" data-table="facture">Factures réglées</option>
                                            <option value="Non réglée" data-table="avoir">Avoirs non réglées</option>
                                            <option value="Réglée" data-table="avoir">Avoirs réglées</option>

                                        </select>
                                    </div>
                                </div>
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
                        <a class="btn btn-success buttons-html5 float-right mb-1" href="#" data-toggle="modal" data-animation="bounce" data-target=".reglee-modal" hidden id="reglee_btn"><span>Réglée</span></a>
                        <div class="dt-buttons btn-group mb-2">
                            <a class="btn btn-secondary btn-pdf1 buttons-html5" tabindex="0"
                               data-toggle="modal" data-animation="bounce" data-target=".pdf-modal" data-dismiss="modal"  href="#"><span>Imprimer</span></a>
                        </div>
                        <table id="datatable-releves" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="" id="maincheck" data-parsley-multiple="groups"></th>
                                <th></th>
                                <th>Etat</th>
                                <th>Date</th>
                                <th>Fournisseur</th>
                                <th>Montant TTC</th>
                                <th>Reste à payer</th>
                                <th></th>

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
<div class="modal fade pdf-modal" style="z-index: 1060!important;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"><span class="date_modal"></span><span
                        class="fournisseur_modal"></span></h5>
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
<div class="modal fade reglee-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"><span class="tablename"></span><span class="citems"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-5">
                        <label for="date-range" class="col-sm-12 col-form-label">Montant
                        </label>
                        <div class="col-sm-12">
                            <div class="input-group montantinput" >
                                <input type="number" min="1" class="form-control" id="montant_input"
                                       name="montant" placeholder="" value="1" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-5">
                        <label for="typer_select" class="col-sm-12 col-form-label">Type
                        </label>
                        <div class="col-sm-12">
                            <div class="input-group typeselect">
                                <select id="typer_select" name="typer_select"
                                        class="form-control form-control-sm custom-select">
                                    <option value="espèces">Espèces</option>
                                    <option value="chèque">Chèque</option>
                                </select>
                                <div class="input-group-addon ncheque">N°</div>
                                <input type="text" class="form-control ncheque" id="numcheque_input"
                                       name="numcheque_input" placeholder="" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label class="col-sm-12 col-form-label"></label>
                        <button class="btn-sm btn-success mt-3" id="transfer_btn">Réglée</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade paiment-modal" tabindex="-1"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"><span class="tablename"></span><span
                        class="citems"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="dt-buttons exportsection btn-group mb-2">
                    <a class="btn btn-secondary btn-pdf2 buttons-html5" tabindex="0"
                       data-toggle="modal" data-animation="bounce" data-target=".pdf-modal"  href="#"><span>Imprimer</span></a>
                </div>
                <table class="table" id="paiment-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Numéro de chèque</th>
                        <th>Montant</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div>

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

    <script src="../../script/reglementsachat.js?r=<?php echo rand();?>"></script>
