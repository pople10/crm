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
                            <li class="breadcrumb-item active">Bilan clients</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bilan clients</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="client_select" class="col-sm-12 col-form-label">Clients
                                </label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <select id="client_select" name="client_select"
                                                class="form-control form-control-sm custom-select">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 mb-0 d-flex align-items-center">
                                <table class="table-sm table-striped table-borderless w-100">
                            <thead>
                            <tr>
                                <th class="text-danger">Total Débit</th>
                                <th class="text-success">Total Crédit</th>
                                <th>Solde</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="totalDebit">0</td>
                                    <td id="totalCredit">0</td>
                                    <th id="sold">0</th>
                                </tr>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row section2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="form-group col-sm-6 mb-0 d-flex align-items-center">
                                <h5 id="etatCompte" class="ml-4"></h4>
                            </div>
                            <div class="form-group col-sm-6 mb-0">
                                <table class="table-sm table-striped table-borderless w-100">
                            <thead>
                            <tr>
                                <th>Total Débit</th>
                                <th>Total Crédit</th>
                                <th>Solde</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="totalDebit">0</td>
                                    <td id="totalCredit">0</td>
                                    <th id="sold">0</th>
                                </tr>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-buttons exportsection btn-group mb-2">
                            <a class="btn btn-secondary btn-pdf1 buttons-html5" tabindex="0"
                               data-toggle="modal" data-animation="bounce" data-target=".pdf-modal" data-dismiss="modal"  href="#"><span>Imprimer</span></a>
                        </div>
                        <table id="datatable-comptes" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Client</th>
                                <th>Débit</th>
                                <th>Crédit</th>
                                <th>Solde</th>
                                <th>Date dérniere opération</th>
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

<div class="modal fade pdf-modal" style="z-index: 1060!important;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

   <script src="../../script/bilanclient.js?r=<?php echo rand();?>"></script>
