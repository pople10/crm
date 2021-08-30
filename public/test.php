<?php
include_once './template/header.php';
?>
<script src="script/dashbord.js" type="text/javascript"></script>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">CRM</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="<?php if(!hasRole($_SESSION['user_id'],"directeur")) echo 'w-100';?>">
                <div class="row">
                    <div class="<?php if(hasRole($_SESSION['user_id'],"directeur")) echo 'col-xl-8'; else echo 'w-100';?>">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round">
                                                    <i class="mdi mdi-account-multiple-plus"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center text-right">
                                                <div class="m-l-10">
                                                    <h5 id="nbrclient" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Client <span
                                                            class="badge bg-soft-success"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height:3px;">
                                            <div class="progress-bar  bg-success" role="progressbar" style="width: 35%;"
                                                 aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round">
                                                    <i class="mdi mdi-eye"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 text-right align-self-center">
                                                <div class="m-l-10 ">
                                                    <h5 id="nbrdevisclient" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Devis Clients</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height:3px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 48%;"
                                                 aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="search-type-arrow"></div>
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round ">
                                                    <i class="mdi mdi-cart"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center text-right">
                                                <div class="m-l-10 ">
                                                    <h5 id="nbrcmdclient" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Commandes Clients</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height:3px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 61%;"
                                                 aria-valuenow="61" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <?php if(hasRole($_SESSION['user_id'],"directeur")) {?>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round">
                                                    <i class="mdi mdi-account-multiple-plus"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center text-right">
                                                <div class="m-l-10">
                                                    <h5 id="nbrfournisseur" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Fornisseurs <span class="badge bg-soft-success"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height:3px;">
                                            <div class="progress-bar  bg-success" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round">
                                                    <i class="mdi mdi-eye"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 text-right align-self-center">
                                                <div class="m-l-10 ">
                                                    <h5 id="nbrdevisfournisseur" class="mt-0">562</h5>
                                                    <p class="mb-0 text-muted">Devis Fornisseurs</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height:3px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 48%;" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="search-type-arrow"></div>
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round ">
                                                    <i class="mdi mdi-cart"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center text-right">
                                                <div class="m-l-10 ">
                                                    <h5 id="nbrcmdfournisseur" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Commandes Fornisseurs</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height:3px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 61%;" aria-valuenow="61" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Evolution des ventes et achats (<span class="year"></span>)</h4>
                                <p class="text-muted mb-4 font-14"></p>
                                <canvas id="lineChart" height="300" width="480" style="width: 514px; height: 300px;"></canvas>
                            </div>
                            <!--end card-body-->
                        </div>
                    </div>
                    <?php if(hasRole($_SESSION['user_id'],"directeur")) {?>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 id="montant" style="color:green"> 0 DH</h6>
                                            <h6 class="text-lightdark">Total revenus</h6>
                                            <span class="text-muted"> <small class="year"></small></span>
                                        </div>
                                        <div class="col-6">
                                            <h6 id="depense" style="color:red"> 0 DH </h6>
                                            <h6 class="text-lightdark">Total dépenses</h6>
                                            <span class="text-muted"> <small class="year"></small></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 center" >
                                            <h6 class="text-lightdark">Gains : <span id="gain" style="color:blue"> </span></h6>
                                            <span class="text-muted"> <small class="year"></small></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="header-title mt-0  mb-3">Etat des commandes (Fournisseur) </h5>
                                        <canvas id="cmd" height="365" width="514" style="width: 514px; height: 365px;"></canvas>

                                    </div>


                                    <!--end card-->
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="header-title mt-0  mb-3">Etat des commandes (Client) </h5>
                                        <canvas id="cmdc" height="365" width="514" style="width: 514px; height: 365px;"></canvas>

                                    </div>


                                    <!--end card-->
                                </div>

                                <!--end card-->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-xl-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0  mb-3">Produits plus commandés </h5>
                                <canvas id="produit" height="500" width="514" style="width: 514px; height: 500px;"></canvas>

                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0 mb-0">Nombre des produits par catégorie</h5>
                                <canvas id="doughnut" height="500" width="514" style="width: 514px; height: 500px;"></canvas>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->


                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0 mb-3">Classement Fournisseurs</h5>
                                <canvas id="bar" height="500" width="514" style="width: 514px; height: 500px;"></canvas>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>


                    <!--end col-->
                </div> <!-- end row -->
                <?php } ?>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body new-user">
                                <h5 class="header-title mb-4 mt-0">Classement des clients</h5>
                                <canvas id="clients" height="350" width="540" style="width: 540px; height: 350px;"></canvas>

                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body new-user">
                                <h5 class="header-title mb-4 mt-0">Les produits les plus vendus</h5>
                                <canvas id="produits" height="350" width="540" style="width: 540px; height: 350px;"></canvas>

                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <!--end row-->
        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->


    <!-- Footer -->
    <?php
    include_once './template/footer.php';
    ?>

    <!-- Chart JS -->
    <script src="../assets/plugins/chart.js/chart.min.js"></script>
