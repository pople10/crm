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
                            <li class="breadcrumb-item active">Compte clients</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Compte clients</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="form-group col-sm-4">
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
                            <div class="form-group col-sm-8">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row section2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="form-group col-sm-8 mb-0 d-flex align-items-center">
                                <h5 id="etatCompte" class="ml-4"></h4>
                            </div>
                            <div class="form-group col-sm-4 mb-0">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!--<div class="dt-buttons exportsection btn-group mb-2">
                            <a class="btn btn-secondary btn-pdf buttons-html5" tabindex="0"
                               data-toggle="modal" data-animation="bounce" data-target=".pdf-modal" data-dismiss="modal"  href="#"><span>Imprimer</span></a>
                        </div>-->
                        <table id="datatable-comptes" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Opération</th>
                                <th>Détail</th>
                                <th>Débit</th>
                                <th>Crédit</th>
                                <th>Solde</th>
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

   <script src="../../script/comptesclient.js?r=<?php echo rand();?>"></script>
