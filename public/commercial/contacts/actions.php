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
                            <li class="breadcrumb-item"><a href="<?php echo __CONTACTSFOLDER__; ?>">Contacts</a></li>
                            <li class="breadcrumb-item active">Actions à réaliser</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Actions à réaliser</h4>
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
                                        <label for="civilite_input" class="col-sm-2 col-form-label">Client /
                                            Fournisseur</label>
                                        <div class="col-sm-10">
                                            <select id="civilite_select" name="civilite_select"
                                                    class="form-control form-control-sm custom-select">
                                                <option hidden>Choisir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_input" class="col-sm-2 col-form-label">Date</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-sm" type="date" value=""
                                                   id="date_input" name="date_input">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dateecheance_input" class="col-sm-2 col-form-label">Date d'échéance</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-sm" type="date" value=""
                                                   id="dateecheance_input" name="dateecheance_input">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="encharge_select" class="col-sm-2 col-form-label">En charge</label>
                                        <div class="col-sm-10">
                                            <select  id="encharge_select" name="encharge_select"
                                                     class="form-control form-control-sm custom-select">
                                                <option hidden>Choisir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="descriptif_textarea" class="col-sm-2 col-form-label">Descriptif
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea id="descriptif_textarea" class="form-control form-control-sm"
                                                      maxlength="225" rows="5" placeholder=""></textarea>
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
                        <table id="datatable-actions" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Etat</th>
                                    <th>Date</th>
                                    <th>En charge</th>
                                    <th>Echéance</th>
                                    <th>Client</th>
                                    <th>Fournisseur</th>
                                    <th>Commentaire</th>
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
    function resetData(){
        $("#civilite_select").val("");
        $("#date_input").val("mm-dd-yyyy");
        $("#dateecheance_input").val("mm-dd-yyyy");
        $("#encharge_select").val("");
        $("#descriptif_textarea").val("");
        $("#enregistrer_btn").attr("n","add").removeAttr("data-id").removeAttr("etat");
        $("#enregistrer_btn").html('<i class="mdi mdi-content-save"></i>Enregistrer');
    }
    $(document).ready(function () {
        $(".section2").hide();
        $("#nouveau_btn").click(function () {
            resetData()
            $(".section1").hide();
            $(".section2").show();
        });
        $("#annuler_btn").click(function () {
            $(".section2").hide();
            $(".section1").show();
            resetData()
        });
    });
</script>

<!-- Footer -->
<?php
include_once './template/footer.php';
?>

<script src="../../script/action.js?r=<?php echo rand();?>" type="text/javascript"></script>