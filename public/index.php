<?php 
include_once './template/header.php';
?>

<script src="script/dashboard.js?r=<?php echo rand();?>" type="text/javascript"></script>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __PUBLICFOLDER__; ?>">CRM</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
		<!-- end page title end breadcrumb -->
		<div class="row">
			<div class="<?php if(hasRole($_SESSION['user_id'],"Directeur")) echo 'col-xl-8'; else echo 'col-xl-12';?>">
				<?php if(hasRole($_SESSION['user_id'],"Directeur")){ ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Evolution des ventes et achats (<span class="year"></span>)</h4>
                                <p class="text-muted mb-4 font-14"></p>
                                <canvas id="lineChart2" height="300" width="480" style="width: 514px; height: 300px;"></canvas>
                            </div>
                            <!--end card-body-->
                        </div>
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h2 class="header-title mt-0  mb-3">
									Meilleurs Article Vendus
								</h2>
								<table class="table table-striped" id="table_products">
								  
								</table>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h2 class="header-title mt-0  mb-3">
									Meilleurs Clients
								</h2>
								<table class="table table-striped" id="table_clients">
								  
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
					    <div class="card">
							<div class="card-body">
								<h2 class="header-title mt-0  mb-3">
									Documents
								</h2>
								<table class="table table-striped" id="tables_docs">
								  
								</table>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h2 class="header-title mt-0  mb-3">
									Evolution de Chiffre d'affaires(<span class="year"></span>)
								</h2>
                                <p class="text-muted mb-4 font-14"></p>
                                <canvas id="lineChart" height="300" width="480" style="width: 514px; height: 400px;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if(hasRole($_SESSION['user_id'],"Directeur")){ ?>
			<div class="col-xl-4">
						<div class="card" style='margin-bottom:0px!important;'>
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
						</div>
				<div class="card">
					<div class="card-body">
								<h2 class="header-title mt-0  mb-3">
									Chiffre d'affaires
								</h2>
								<table class="table table-striped" id="table_chiffre_affaires">
								  
								</table>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
		<div class="modal fade" id="ModalEvolution" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Evolution des ventes - <span id="reference"></span></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center id="graphevolutioncenter">
				<canvas id="evolutionproductchart" height="250" width="317" style="width: 100%!important; height: 100%!important;">
				</canvas>
		</center>
      </div>
    </div>
  </div>
</div>


<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>
<!-- Chart JS -->
    <script src="../assets/plugins/chart.js/chart.min.js"></script>
