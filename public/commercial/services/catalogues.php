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
                            <li class="breadcrumb-item active">Catalogue & Tarif
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Liste des Produits
                    </h4>
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
                    <div class="card-body formulaire">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-9">
                                        <h6 id="_title">Nouveau produit</h6>
                                        <div class="form-group row">
                                            <label for="reference_input"
                                                class="col-sm-3 col-form-label">Référence</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <div class="col-sm-4">
                                                    <input class="form-control form-control-sm pr-2" type="text"
                                                        value="" id="reference_input" name="reference_input" disabled="true">
                                                </div>
                                                <div class="col-sm-8 pr-0">
                                                    <input class="form-control form-control-sm" type="text" id="reference2_input" name="reference2_input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="designationvente_input"
                                                class="col-sm-3 col-form-label">Désignation vente</label>
                                            <div class="col-sm-9">
                                                <input class="form-control form-control-sm  mr-1" type="text" value=""
                                                    id="designationvente_input" name="designationvente_input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="designationachat_input"
                                                class="col-sm-3 col-form-label">Désignation achat</label>
                                            <div class="col-sm-9">
                                                <input class="form-control form-control-sm  mr-1" type="text" value=""
                                                    id="designationachat_input" name="designationachat_input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="appellation_input"
                                                class="col-sm-3 col-form-label">Appellation</label>
                                            <div class="col-sm-9">
                                                <input class="form-control form-control-sm  mr-1" type="text" value=""
                                                    id="appellation_input" name="appellation_input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description_textarea"
                                                class="col-sm-3 col-form-label">Description
                                            </label>
                                            <div class="col-sm-9">
                                                <textarea id="description_textarea" class="form-control form-control-sm"
                                                    maxlength="225" rows="3" placeholder=""></textarea>
                                            </div>
                                        </div>
                                        <!--<div class="form-group row">
                                                <label for="nature_select" class="col-sm-3 col-form-label">Nature /
                                                    Type
                                                </label>
                                                <div class="col-sm-9 d-flex">
                                                    <select id="nature_select" name="nature_select"
                                                        class="form-control form-control-sm mr-2 custom-select">
                                                        <option hidden>Choisir</option>
                                                        <option value="1">Produit</option>
                                                        <option value="2">Services & travaux</option>
                                                        <option value="3">Matière première</option>
                                                        <option value="4">Autre</option>
                                                    </select>
                                                    <select id="categorie_select" name="categorie_select"
                                                        class="form-control form-control-sm custom-select">
                                                        <option hidden>Choisir</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                        <div class="form-group row">
                                            <label for="customFile" class="col-sm-3 col-form-label">Image du
                                                produit</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">
                                                        <img id="customFileImg" src="" class="rounded-circle"
                                                            style="height: calc(2rem + 2px);margin: -10px;margin-right: 8px;">
                                                        <span>Joindre un
                                                            fichier</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="card col-lg-4">
                                                <div class="">
                                                    <h6>Classement</h6>
                                                </div>
                                                <div class="card-body bg-gray">
                                                    <div class="form-group row">
                                                        <label for="categoriec_select"
                                                            class="col-sm-4 col-form-label">Catégorie
                                                        </label>
                                                        <div class="col-sm-8 d-flex">
                                                            <select id="categoriec_select" name="categoriec_select"
                                                                class="form-control form-control-sm mr-2 custom-select">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="famillec_select"
                                                            class="col-sm-4 col-form-label">Famille
                                                        </label>
                                                        <div class="col-sm-8 d-flex">
                                                            <select id="famillec_select" name="famillec_select"
                                                                class="form-control form-control-sm mr-2 custom-select">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="sousfamillec_select"
                                                            class="col-sm-4 col-form-label">Sous-Famille
                                                        </label>
                                                        <div class="col-sm-8 d-flex">
                                                            <select id="sousfamillec_select" name="sousfamillec_select"
                                                                class="form-control form-control-sm mr-2 custom-select"
                                                                disabled>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="marquec_select"
                                                            class="col-sm-4 col-form-label">Marque
                                                        </label>
                                                        <div class="col-sm-8 d-flex">
                                                            <select id="marquec_select" name="marquec_select"
                                                                class="form-control form-control-sm mr-2 custom-select">
                                                                <option hidden>Choisir</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card col-md-6 col-lg-4">
                                                <div class="">
                                                    <h6>Gestion du stock</h6>
                                                </div>
                                                <div class="card-body bg-gray">
                                                    <div class="form-group row checkbox">
                                                        <div class="custom-control custom-checkbox mr-auto ml-auto">
                                                            <input type="checkbox"
                                                                class="boolean_check custom-control-input"
                                                                id="gereenstock_check" data="0">
                                                            <label class="custom-control-label"
                                                                for="gereenstock_check">Produit géré en
                                                                stock</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="stockalert_input"
                                                            class="col-sm-4 col-form-label">Stock d'alerte</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm"
                                                                id="stockalert_input" name="stockalert_input"
                                                                type="number" placeholder="0" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="quantitemax_input"
                                                               class="col-sm-4 col-form-label">Quantité max</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm"
                                                                   id="quantitemax_input" name="quantitemax_input"
                                                                   type="number" placeholder="0" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="quantite_en_stock_select"
                                                               class="col-sm-4 col-form-label">Quantite en stock
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm"
                                                                   id="quantite_en_stock_select" name="quantite_en_stock_select"
                                                                   type="number" placeholder="0" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card col-md-6 col-lg-4">
                                                <div class="">
                                                    <h6>Unités</h6>
                                                </div>
                                                <div class="card-body bg-gray">
                                                    <div class="form-group row">
                                                        <label for="principaleu_select"
                                                            class="col-sm-4 col-form-label">Principale
                                                        </label>
                                                        <div class="col-sm-8 d-flex">
                                                            <select id="principaleu_select" name="principaleu_select"
                                                                class="form-control form-control-sm mr-2 custom-select">
                                                                <option selected="" data-code="P">P</option>
                                                                <option data-code="ML">ML</option>
                                                                <option data-code="M2">M2</option>
                                                                <option data-code="M3">M3</option>
                                                                <option data-code="Cm">Cm</option>
                                                                <option data-code="M">M</option>
                                                                <option data-code="Km">Km</option>
                                                                <option data-code="Gr">Gr</option>
                                                                <option data-code="Kg">Kg</option>
                                                                <option data-code="L">L</option>
                                                                <option data-code="T">T</option>
                                                                <option data-code="U">U</option>
                                                                <option data-code="H">H</option>
                                                                <option data-code="J">J</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="venteu_select" class="col-sm-4 col-form-label">Vente
                                                        </label>
                                                        <div class="col-sm-8 d-flex">
                                                            <select id="venteu_select" name="venteu_select"
                                                                class="form-control form-control-sm mr-2 custom-select"
                                                                disabled>
                                                                <option value="" hidden></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <h6>Caractéristiques (mètre)</h6>
                                                    <table class="w-100">
                                                        <tbody>
                                                            <tr>
                                                                <th>Longueur</th>
                                                                <td><input class="form-control mr-1 form-control-sm"
                                                                           id="longeur_input" name="longeur_input" type="number"
                                                                           placeholder="0.00" value="0" step="0.1"
                                                                           pattern="^\d+(?:\.\d{1,2})?$"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Largeur</th>
                                                                <td><input class="form-control mr-1 form-control-sm"
                                                                           id="largeur_input" name="largeur_input" type="number"
                                                                           placeholder="0.00" value="0" step="0.1"
                                                                           pattern="^\d+(?:\.\d{1,2})?$"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Epaisseur</th>
                                                                <td><input class="form-control form-control-sm" id="epaisseur_input"
                                                                           name="epaisseur_input" type="number" placeholder="0.00"
                                                                           value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--<div class="d-flex justify-content-around">
                                                        <p>Longueur</p>
                                                        <p>Largeur</p>
                                                        <p>Epaisseur</p>
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <input class="form-control mr-1 form-control-sm"
                                                            id="longeur_input" name="longeur_input" type="number"
                                                            placeholder="0.00" value="0" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                        <input class="form-control mr-1 form-control-sm"
                                                            id="largeur_input" name="largeur_input" type="number"
                                                            placeholder="0.00" value="0" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                        <input class="form-control form-control-sm" id="epaisseur_input"
                                                            name="epaisseur_input" type="number" placeholder="0.00"
                                                            value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="">
                                                <h6>Statut</h6>
                                            </div>
                                            <div class="card-body bg-gray d-flex justify-content-around">
                                                <div class="form-group row checkbox">
                                                    <div class="custom-control custom-checkbox mr-auto ml-auto">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="status1_check" name="status_check" data="">
                                                        <label class="custom-control-label" for="status1_check">Figure
                                                            sur le catalogue de
                                                            vente</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row checkbox">
                                                    <div class="custom-control custom-checkbox mr-auto ml-auto">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="status2_check" name="status_check" data="">
                                                        <label class="custom-control-label" for="status2_check">Produit
                                                            obsolète</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row checkbox">
                                                    <div class="custom-control custom-checkbox mr-auto ml-auto">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="status3_check" name="status_check" data="">
                                                        <label class="custom-control-label" for="status3_check">Masquer
                                                            le produit</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row checkbox">
                                                    <div class="custom-control custom-checkbox mr-auto ml-auto">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="status4_check" name="status_check" data="">
                                                        <label class="custom-control-label" for="status4_check">Ajouter
                                                            aux signets</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="">
                                                <h6>Tarification DH (<span class="unite_span"></span>)</h6>
                                            </div>
                                            <div class="card-body bg-gray">
                                                <div class="form-group row">
                                                    <label for="tarifht_input" class="col-sm-4 col-form-label">Tarif
                                                        HT
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-sm" id="tarifht_input"
                                                            name="tarifht_input" name="tarifht_input" type="number"
                                                            placeholder="0.00" value="0" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tva_select" class="col-sm-4 col-form-label">TVA
                                                    </label>
                                                    <div class="col-sm-8 d-flex">
                                                        <select id="tva_select" name="tva_select"
                                                            class="form-control form-control-sm mr-2 custom-select">
                                                            <option value="0.20">20%</option>
                                                            <option value="0.14">14%</option>
                                                            <option value="0.10">10%</option>
                                                            <option value="0">0%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tarifttc_input" class="col-sm-4 col-form-label">Tarif
                                                        TTC
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-sm" id="tarifttc_input"
                                                            name="tarifttc_input" type="number" placeholder="0.00"
                                                            min="0" value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="">
                                                <h6>Prix promo DH (<span class="unite_span"></span>)</h6>
                                            </div>
                                            <div class="card-body bg-gray">
                                                <div class="form-group row">
                                                    <label for="date-range" class="col-sm-4 col-form-label">Periode
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <div class="input-daterange input-group" id="date-range">
                                                            <input type="text" class="form-control" id="datedu_input"
                                                                name="du" placeholder="Du" />
                                                            <input type="text" class="form-control" id="dateau_input"
                                                                name="au" placeholder="Au" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row checkbox">
                                                    <div class="custom-control custom-checkbox  mr-auto ml-auto">
                                                        <input type="checkbox"
                                                            class="boolean_check custom-control-input"
                                                            id="enpromotion_check" data="0">
                                                        <label class="custom-control-label" for="enpromotion_check">En
                                                            promotion</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prixpromoht_input" class="col-sm-4 col-form-label">Prix
                                                        Promo HT
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-sm"
                                                            id="prixpromoht_input" name="prixpromoht_input"
                                                            type="number" placeholder="0.00" name="price" min="0"
                                                            value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$"
                                                            onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="">
                                                <h6>Gestion des remises (%)</h6>
                                            </div>
                                            <div class="card-body bg-gray">
                                                <div class="form-group row">
                                                    <label for="remise1_input" class="col-sm-4 col-form-label">Remise
                                                        max</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-sm" type="number"
                                                            id="remise1_input" name="remise1_input" min="0" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="remise2_input" class="col-sm-4 col-form-label">Remise
                                                        niveau 1</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-sm remisesn"
                                                            type="number" placeholder="0.00" min="0" value="0.00"
                                                            step="0.1" pattern="^\d+(?:\.\d{1,2})?$" id="remise2_input"
                                                            name="remise2_input">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="remise3_input" class="col-sm-4 col-form-label">Remise
                                                        niveau 2</label>
                                                    <div class="col-sm-8">
                                                        <input id="remise3_input" name="remise3_input"
                                                            class="form-control form-control-sm remisesn" type="number"
                                                            placeholder="0.00" min="0" value="0.00" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="remise4_input" class="col-sm-4 col-form-label">Remise
                                                        niveau 3</label>
                                                    <div class="col-sm-8">
                                                        <input id="remise4_input" name="remise4_input"
                                                            class="form-control form-control-sm remisesn" type="number"
                                                            placeholder="0.00" min="0" value="0.00" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="remise5_input" class="col-sm-4 col-form-label">Remise
                                                        niveau 4</label>
                                                    <div class="col-sm-8">
                                                        <input id="remise5_input" name="remise5_input"
                                                            class="form-control form-control-sm remisesn" type="number"
                                                            placeholder="0.00" min="0" value="0.00" step="0.1"
                                                            pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-12">

                                    </div>
                                </div>
                            </div>

                        </div>
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
                        <button id="enregistrer_btn" class="btn btn-primary btn-sm ml-2 mr-2 float-right" role="button"
                            op="N"><i class="mdi mdi-content-save"></i>
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
                        <table id="datatable-produits" class="table table-striped table-bordered w-100 display">
                            <tfoot style="display: table-header-group;">
                                <tr>
                                    <th></th>
                                    <th>Désignation Vente</th>
                                    <th>Désignation Achat</th>
                                    <th>Appellation</th>
                                    <th>Référence</th>
                                    <th>Unité</th>
                                    <th>Tarif HT</th>
                                    <th>Tarif TTC</th>
                                    <th></th>  
                                </tr>
                            </tfoot>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Désignation Vente</th>
                                    <th>Désignation Achat</th>
                                    <th>Appellation</th>
                                    <th>Référence</th>
                                    <th>Unité</th>
                                    <th>Tarif HT</th>
                                    <th>Tarif TTC</th>
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

<script>
$(document).ready(function() {


    var clearInputs = function() {
        $("#_title").text("Nouveau Produit");
        $("#enregistrer_btn").attr("op", "N");
        $(".parsley-error").removeClass("parsley-error");
        $(".parsley-errors-list").remove();
        $("input").val("");
        $("input[type='checkbox']").prop("checked", false);
        $("#reference2_input").prop("disabled", false);
        $("#customFileImg").attr("src", "").attr("lastImg", "no-photo.png");
        $("#reference2_input").attr("hidden",false);
        $("#reference2_input").val("");
        $("#reference_input").val("");
    }

    $(".unite_span").text($("#principaleu_select").val());
    $("#venteu_select").find("option:eq(0)").text($("#principaleu_select").val());

    $("#principaleu_select").change(function() {
        $(".unite_span").text($(this).val());
        $("#venteu_select").find("option:eq(0)").text($(this).val());
        $("#venteu_select").find("option:eq(0)").val($(this).val());
    });

    $("#enpromotion_check").change(function() {
        $("#prixpromoht_input").prop("disabled", !$(this).is(":checked"));
    });

    $(".section2").hide();
    $("#nouveau_btn").click(function() {
        clearInputs();
        $(".section1").hide();
        $(".section2").show();
    });
    $("#annuler_btn").click(function() {
        clearInputs();
        $(".section2").hide();
        $(".section1").show();
    });
});
</script>

<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>

<script src="../../script/catalogues.js?r=<?php echo rand();?>" type="text/javascript"></script>