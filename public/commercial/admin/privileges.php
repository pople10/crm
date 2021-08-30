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
                            <li class="breadcrumb-item active">Gestion des privilèges</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Gestion des privilèges</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 datatable-btns mb-2"></div>
                        </div>
                        <table id="datatable-privileges" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Privilège</th>
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
        $(".section2").hide();
        $("#nouveau_btn").click(function() {
            $(".section1").hide();
            $(".section2").show();
        });
        $("#annuler_btn").click(function() {
            $(".section2").hide();
            $(".section1").show();
        });
    });
</script>

<!-- Footer -->
<?php
include_once './template/footer.php';
?>
<script src="../../script/privilege.js?r=<?php echo rand();?>" type="text/javascript"></script>