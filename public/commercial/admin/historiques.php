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
                            <li class="breadcrumb-item"><a href="<?php echo __ADMINFOLDER__; ?>">Administration</a></li>
                            <li class="breadcrumb-item active">Historiques
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Historiques des actions
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
                                <th>Date</th>
                                <th>Utilisateur</th>
                                <th>Action</th>
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

<div class="modal fade action-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel"><span class="date_modal"></span><span
                            class="user_modal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" >
                <table id="table1" class="table table-striped table-bordered w-100">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Ancien</th>
                        <th>Nouveau</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Footer -->
<?php
include_once './template/footer.php';
?>

<script src="../../script/historiques.js?r=<?php echo rand();?>" type="text/javascript"></script>
