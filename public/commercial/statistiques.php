<?php 
chdir('..');
chdir('..');
include_once './template/header.php';

?>

<script src="../../script/statistique.js" type="text/javascript"></script>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __PUBLICFOLDER__; ?>">Accueil</a></li>
                            <li class="breadcrumb-item active">Statistiques</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Statistiques</h4>
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
									Documents
								</h2>
								<table class="table table-striped" id="tables_docs">
								  
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
									Meilleurs Clients
								</h2>
								<table class="table table-striped" id="table_clients">
								  
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
			<div class="col-xl-4">
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
		</div>


<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>
<!-- Chart JS -->
    <script src="../../../assets/plugins/chart.js/chart.min.js"></script>