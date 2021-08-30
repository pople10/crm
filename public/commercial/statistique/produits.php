<?php 
chdir('..');
chdir('..');
include_once './template/header.php';

?>

<script src="../../script/statistique_product.js?r=<?php echo rand();?>" type="text/javascript"></script>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __STATISTIQUEFOLDER__; ?>">Statistiques</a></li>
                            <li class="breadcrumb-item active">Produits</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Produits</h4>
                </div>
            </div>
        </div>
		<!-- end page title end breadcrumb -->
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0 mb-3">évolution de ventes dans l’année courante et année précédente</h5>
                                <select id="productevolution" class="mt-0 mb-2 form-control form-control-sm mr-2 custom-select" style='width:100%;height:50px;'>
								
								</select>
								<center id="graphevolutioncenter">
									<canvas id="evolutionproductchart" height="426" width="512" style="width: 512px!important; height: 426px!important;">
									</canvas>
								</center>
                            </div>
                            <!--end card-body-->
                </div>
				<!--end card-->
			</div>
			<div class="col-lg-6">
				<div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0 mb-3">Nombre des produits par catégorie</h5>
                                <canvas id="doughnut" height="500" width="514" style="width: 514px; height: 500px;"></canvas>
                            </div>
                            <!--end card-body-->
                </div>
				<!--end card-->
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
                            <div class="card-body">
								<h5 class="header-title mt-0  mb-3">Les produits les plus vendus</h5>
                                <canvas id="produits" height="500" width="514" style="width: 514px; height: 500px;"></canvas>
                            </div>
                            <!--end card-body-->
                </div>
				<!--end card-->
			</div>
			<div class="col-lg-6">
				<div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0  mb-3">Produits plus commandés </h5>
                                <canvas id="produit" height="500" width="514" style="width: 514px; height: 500px;"></canvas>
                            </div>
                            <!--end card-body-->
                </div>
                <!--end card-->
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0  mb-3">Produits plus retournées par clients </h5>
                                <canvas id="rvprd" height="500" width="514" style="width: 514px; height: 500px;"></canvas>

                            </div>
                            <!--end card-body-->
                </div>
			</div>
			<div class="col-lg-6">
				<div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0  mb-3">Produits plus retournées aux fornisseurs </h5>
                                <canvas id="raprd" height="500" width="514" style="width: 514px; height: 500px;"></canvas>

                            </div>
                            <!--end card-body-->
                </div>
			</div>
		</div>
		

<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>
<!-- Chart JS -->
    <script src="../../../assets/plugins/chart.js/chart.min.js"></script>