<?php 
chdir('..');
chdir('..');
include_once './template/header.php';

?>

<script src="../../script/statistique_client.js?r=<?php echo rand();?>" type="text/javascript"></script>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __STATISTIQUEFOLDER__; ?>">Statistiques</a></li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Clients</h4>
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
                                                    <h5 id="nbrclient" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Client <span
                                                            class="badge bg-soft-success"></span></p>
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
                                                    <h5 id="nbrdevisclient" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Devis Clients</p>
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
                                                    <h5 id="nbrcmdclient" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Commandes Clients</p>
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
                                                    <h5 id="nbrcmdclientdelivered" class="mt-0">0</h5>
                                                    <p class="mb-0 text-muted">Livraison Clients</p>
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
								<h5 class="header-title mb-4 mt-0">Classement des clients</h5>
								   <canvas id="clients" height="350" width="540" style="width: 540px; height: 350px;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="card" style='margin-bottom:0px;'>
					<div class="card-body">
								<h5 class="header-title mt-0  mb-3">Etat des livraisons commandes</h5>
                                <canvas id="cmdc" height="365" width="514" style="width: 514px; height: 365px;"></canvas>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
								<h5 class="header-title mt-0  mb-3">Etat des paiments factures</h5>
                                <canvas id="cmdcp" height="365" width="514" style="width: 514px; height: 365px;"></canvas>
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