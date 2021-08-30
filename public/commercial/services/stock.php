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
                            <li class="breadcrumb-item active">Stock & Mouvements</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Stock & Mouvements</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-etat-tab" data-toggle="pill" href="#pills-etat" role="tab"
                            aria-controls="pills-etat" aria-selected="true">État du stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-stock-tab" data-toggle="pill" href="#pills-stock" role="tab"
                            aria-controls="pills-stock" aria-selected="false">Stock par produit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-mproduit-tab" data-toggle="pill" href="#pills-mproduit" role="tab"
                            aria-controls="pills-mproduit" aria-selected="false">Mouvements par produit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-mstock-tab" data-toggle="pill" href="#pills-mstock" role="tab"
                            aria-controls="pills-contact" aria-selected="false">Mouvements de stock</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane row fade show active" id="pills-etat" role="tabpanel"
                        aria-labelledby="pills-etat-tab">
                        <div class="col-12 row">
                            <div class="col-sm-2">
                                <select id="etat_select" name="etat_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Catégorie</option>
                                    <option value="">Sous-catégorie</option>
                                    <option value="">Marque</option>
                                    <option value="">Produit</option>
                                    <option value="">Ajouter un indicateur</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select id="filtrer_select" name="filtrer_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Tous les dépôts</option>
                                    <option value="">Par dépôt</option>
                                    <option value="">Dépôt principal</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>Catégorie</th>
                                        <th>M3</th>
                                        <th>M2</th>
                                        <th>ML</th>
                                        <th>P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                    <div class="tab-pane row fade" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab">
                        <div class="col-12 row">
                            <div class="col-sm-2">
                                <select id="etat2_select" name="etat2_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Tous dépôts ( Inclus en stock global )</option>
                                    <option value="">Dépôt principal</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select id="filtrer2_select" name="filtrer2_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">CUMP Comm.</option>
                                    <option value="">CUMP Comp.</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <table id="datatable-buttons2" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Quantité stock</th>
                                        <th>Unité</th>
                                        <th>CUMP</th>
                                        <th>Valeur stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!--end col-->
                    </div>
                    <div class="tab-pane row fade" id="pills-mproduit" role="tabpanel"
                        aria-labelledby="pills-mproduit-tab">
                        <div class="col-12">
                            <table id="datatable-buttons3" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>E/S Piéce</th>
                                        <th>Référence</th>
                                        <th>Quantité</th>
                                        <th>PU HT</th>
                                        <th>Solde</th>
                                        <th>CUMP Dépôt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!--end col-->
                    </div>
                    <div class="tab-pane row fade" id="pills-mstock" role="tabpanel" aria-labelledby="pills-mstock-tab">
                        <div class="section1 col-12 mb-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle waves-effect"
                                        data-toggle="dropdown" aria-expanded="false"> <i
                                            class="mdi mdi-account-plus"></i> Nouveau <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item nouveau_btn" href="#">Mouvement d'entrée</a>
                                        <a class="dropdown-item nouveau_btn" href="#">Mouvement de sortie</a>
                                        <a class="dropdown-item nouveau_btn" href="#">Transfert de dépôt à dépôt</a>
                                        <a class="dropdown-item nouveau_btn" href="#">Inventaire</a>
                                    </div>
                                </div>
                        </div>
                        <div class="card section2">
                            <div class="card-body mt-2 bg-gray">
                                <div class="row">
                                    <div class="col-12">
                                        <form>
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="reference_input"
                                                            class="col-sm-2 col-form-label">Référence</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control form-control-sm" type="text"
                                                                value="" id="reference_input" name="reference_input">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="libelle_textarea"
                                                            class="col-sm-2 col-form-label">Libellé</label>
                                                        <div class="col-sm-10">
                                                            <textarea id="libelle_textarea"
                                                                class="form-control form-control-sm" maxlength="225"
                                                                rows="3" placeholder="" spellcheck="false"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="date_input"
                                                            class="col-sm-2 col-form-label">Date</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control form-control-sm" type="date"
                                                                value="" id="date_input" name="date_input">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="type_select"
                                                            class="col-sm-2 col-form-label">Type</label>
                                                        <div class="col-sm-10">
                                                            <select id="type_select" name="type_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option value="">Prêt</option>
                                                                <option value="">Régularisation</option>
                                                                <option value="">Utilisation interne</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="depot_select"
                                                            class="col-sm-2 col-form-label">Dépôt</label>
                                                        <div class="col-sm-10">
                                                            <select id="depot_select" name="depot_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option hidden>Choisir</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="ddepot_select" class="col-sm-2 col-form-label">Du
                                                            dépôt</label>
                                                        <div class="col-sm-4">
                                                            <select id="ddepot_select" name="ddepot_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option hidden>Choisir</option>
                                                            </select>
                                                        </div>
                                                        <label for="vdepot_select" class="col-sm-2 col-form-label">Vers
                                                            dépôt</label>
                                                        <div class="col-sm-4">
                                                            <select id="vdepot_select" name="vdepot_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option hidden>Choisir</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="customFile" class="col-sm-2 col-form-label">Pièce
                                                            jointe</label>
                                                        <div class="col-sm-10">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="customFile">
                                                                <label class="custom-file-label"
                                                                    for="customFile">Joindre un fichier</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <button id="enregistrer_btn"
                                                    class="btn btn-primary btn-sm ml-2 mr-2 float-right"
                                                    role="button"><i class="mdi mdi-content-save"></i>
                                                    Enregistrer</button>
                                                <button id="annuler_btn" class="btn btn-warning btn-sm float-right"
                                                    role="button"><i class="mdi mdi-close"></i>
                                                    Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-sm-2">
                                <select id="etat3_select" name="etat3_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Mouvements d'entrées</option>
                                    <option value="">Mouvements de sorties</option>
                                    <option value="">Transfert de dépôt à dépôt</option>
                                    <option value="">Inventaires</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select id="filtrer3_select" name="filtrer3_select"
                                    class="form-control form-control-sm custom-select">
                                    <option value="">Tous</option>
                                    <option value="">Non validés</option>
                                    <option value="">Validés</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <table id="datatable-buttons3" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>Réf.</th>
                                        <th>Date</th>
                                        <th>Libellé</th>
                                        <th>Type</th>
                                        <th>Dépôt</th>
                                        <th>Réalisé par</th>
                                        <th>Produits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!--end col-->
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
            $(".section2").hide();
            $(".nouveau_btn").click(function() {
                $(".section1").hide();
                $(".section2").show();
            });
            $("#annuler_btn").click(function() {
                $(".section2").hide();
                $(".section1").show();
            });
            var option = {
                lengthChange: false,
                buttons: [ /*'copy',*/ 'excel', 'pdf', 'colvis']
            }

            var table1 = $('#datatable-buttons').DataTable(option);

            table1.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

            var table2 = $('#datatable-buttons2').DataTable(option);

            table2.buttons().container()
                .appendTo('#datatable-buttons2_wrapper .col-md-6:eq(0)');

            var table3 = $('#datatable-buttons3').DataTable(option);

            table3.buttons().container()
                .appendTo('#datatable-buttons3_wrapper .col-md-6:eq(0)');

        });
        </script>

        <!-- Footer -->
        <?php 
    include_once './template/footer.php';
?>