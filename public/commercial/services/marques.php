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
                            <li class="breadcrumb-item active">Marques</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Marques</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <button id="nouveau_btn" class="btn btn-success btn-sm" role="button"><i
                                class="mdi mdi-account-plus"></i> Nouveau</button>
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
                                        <label for="nom_input" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-sm" type="text" value=""
                                                id="nom_input" name="nom_input">
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
                            Enregistrer</button>
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
                        <div class="row">
                            <div class="col-12 datatable-btns mb-2"></div>
                        </div>
                        <table id="datatable-marques" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Actions</th>
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
    $(".section2").hide();
    $("#nouveau_btn").click(function() {
        $(".section1").hide();
        $(".section2").show();
    });
    $("#annuler_btn").click(function() {
        $(".section2").hide();
        $(".section1").show();
    });
});
</script>

<!-- Footer -->
<?php
include_once './template/footer.php';
?>
<script src="../../script/marque.js?r=<?php echo rand();?>" type="text/javascript"></script>