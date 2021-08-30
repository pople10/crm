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
                            <li class="breadcrumb-item active">Gestion des utilisateurs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Gestion des utilisateurs</h4>
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
                                <div class="col-md-8">
                                    <h6>Informations personnelles</h6>
                                    <div class="form-group row" id="personne_section">
                                        <label for="prenom_input" class="col-sm-2 col-form-label">Prénom</label>
                                        <div class="col-sm-4">
                                            <input class="form-control form-control-sm" type="text" value=""
                                                   id="prenom_input" name="prenom_input">
                                        </div>
                                        <label for="nom_input" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-4">
                                            <input class="form-control form-control-sm" type="text" value=""
                                                   id="nom_input" name="nom_input">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="telephone_input"
                                           class="col-sm-2 col-form-label">Téléphone</label>
                                    <div class="col-sm-4">
                                        <input class="form-control form-control-sm" type="tel" value=""
                                               id="telephone_input" name="telephone_input">
                                    </div>
                                    <label for="email_input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-4">
                                        <input class="form-control form-control-sm" type="email" value=""
                                               id="email_input" name="email_input">
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-12">
                                            <h6>Mot de passe</h6>
                                            <div class="card bg-gray">
                                                <div class="card-body">
                                                    <div class="form-group row oldpassword">
                                                        <label for="oldpassword_input"
                                                               class="col-sm-4 col-form-label">Ancien mot de passe</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm" type="password"
                                                                   value="" id="oldpassword_input"
                                                                   name="oldpassword_input">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="newpassword_input"
                                                               class="col-sm-4 col-form-label">Nouveau mot de passe</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm" type="password"
                                                                   value="" id="newpassword_input"
                                                                   name="newpassword_input">
                                                        </div>
                                                    </div>
                                                </div>
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
                        <button id="enregistrer_btn" class="btn btn-primary btn-sm ml-2 mr-2 float-right" role="button"><i
                                class="mdi mdi-content-save"></i>
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
                        <table id="datatable-users" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Role</th>
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
<div class="modal fade roles-modal" style="z-index: 1060!important;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Gérer les roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="role_select" class="col-sm-2 col-form-label">Role
                            </label>
                            <div class="col-sm-9">
                                <select id="role_select" name="role_select"
                                        class="form-control form-control-sm custom-select" style="height: fit-content;padding-bottom: 2px;">
                                    <option hidden>Choisir</option>
                                </select>
                            </div>
                            <button id="ajouter-role" class="btn-sm btn-success col-sm-1" style="height: fit-content">Ajouter</button>

                        </div>
                    </div>
                    <div class="col-12 row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <table id="currentroles-table" class="w-100">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        $(".section2").hide();
        $("#nouveau_btn").click(function () {
            $(".section1").hide();
            $(".section2").show();
            $(".oldpassword").hide();
            $("#oldpassword_input").val("");
            var op = 'add';
            var id = 0;
        });
        $("#annuler_btn").click(function () {
            $(".section2").hide();
            $(".section1").show();
            $(".oldpassword").show();
            var op = 'add';
            var id = 0;
        });
    });
</script>

<!-- Footer -->
<?php
include_once './template/footer.php';
?>

<script src="../../script/users.js?r=<?php echo rand();?>" type="text/javascript"></script>