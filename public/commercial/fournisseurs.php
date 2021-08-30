<?php 
chdir('..');
chdir('..');
include_once './template/header.php';

?>

<script src="../../script/statistique.js?r=<?php echo rand();?>" type="text/javascript"></script>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __STATISTIQUEFOLDER__; ?>">Statistiques</a></li>
                            <li class="breadcrumb-item active">Fournisseurs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Fournisseurs</h4>
                </div>
            </div>
        </div>
		<!-- end page title end breadcrumb -->
		<div class="row">
			<div class="col-xl-8">
				<div class="row">
				 <div class="col-lg-6">
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
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->

                            <div class="col-lg-6">
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
                                                    <h5 id="nbrdevisfournisseur" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Devis Fornisseurs</p>
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
				<div class="row">
							<div class="col-lg-6">
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
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
							<div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="search-type-arrow"></div>
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <div class="round ">
                                                    <i class="mdi mdi-truck-delivery"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center text-right">
                                                <div class="m-l-10 ">
                                                    <h5 id="nbrcmdsupplierdelivered" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Bon de réception</p>
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
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h5 class="header-title mt-0 mb-3">Classement Fournisseurs</h5>
                                <canvas id="bar" height="350" width="540" style="width: 540px; height: 350px;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card" style='margin-bottom:0px;'>
					<div class="card-body">
								<h5 class="header-title mt-0  mb-3">Etat des livraisons commandes</h5>
                                <canvas id="cmd" height="365" width="514" style="width: 514px; height: 365px;"></canvas>
					</div>
				</div>
			</div>
		</div>
		

<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>
<!-- Chart JS -->
    <script src="../../../assets/plugins/chart.js/chart.min.js"></script>