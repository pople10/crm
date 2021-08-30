<?php
ini_set('display_errors', 1);
include_once 'global_variables.php';

//if (session_status() != PHP_SESSION_ACTIVE) {

$rootPath = $_SERVER['DOCUMENT_ROOT'];
$thisPath = dirname($_SERVER['PHP_SELF']);
$dir = str_replace($rootPath, '', $thisPath);

include_once $rootPath."/beans/User.php";

session_start();


//}
if (isset($_SESSION['user'])) {
    function findUserPrivilege($user) {
        include_once '../connexion/Connexion.php';
        $connexion = new Connexion();
        $query = "SELECT * FROM UserPrivilege where user_id = ?";
        $req = $connexion->getConnexion()->prepare($query);
        $req->execute(array($user));
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
    function hasRole($user,$role) {
        include_once '../connexion/Connexion.php';
        $connexion = new Connexion();
        $query = "SELECT * FROM UserRole ur inner join Role r on r.id=ur.role where ur.user = ? and r.nom like ?";
        $req = $connexion->getConnexion()->prepare($query);
        $req->execute(array($user,$role));
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
    $_SESSION["privileges"] = findUserPrivilege($_SESSION['user_id']);
    function sectionAllowed($id){
        foreach ($_SESSION["privileges"] as $p){
            if($p->privilege_id == $id)
                return true;
        }
        return false;
    }
    if(isset($_GET['redirect']) && $_GET['redirect'] != "" && filter_var($_GET['redirect'],FILTER_VALIDATE_URL))
        header("Location:".$_GET['redirect']);

    if($dir == "/public/commercial/achats" && !sectionAllowed(Priviliges::ACHATS))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/admin" && !sectionAllowed(Priviliges::ADMINISTRATION))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/analyse" && !sectionAllowed(Priviliges::ANALYSE))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/comptabilite" && !sectionAllowed(Priviliges::COMPTABILITE))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/contacts" && !sectionAllowed(Priviliges::CONTACTS))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/services" && !sectionAllowed(Priviliges::PRODUITS_ET_SERVICES))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/ventes" && !sectionAllowed(Priviliges::VENTES))
        header("Location:".__PUBLICFOLDER__);
    else if($dir == "/public/commercial/statistique" && !sectionAllowed(Priviliges::STATISTIQUE))
        header("Location:".__PUBLICFOLDER__);

} else {
    header("Location:../../../index.html?redirect="."http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>CRM</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo $serverName; ?>/assets/images/favicon.ico">


        <!-- DataTables -->
        <link href="<?php echo $serverName; ?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $serverName; ?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="<?php echo $serverName; ?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- jvectormap -->
        <link href="<?php echo $serverName; ?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
        <link href="<?php echo $serverName; ?>/assets/plugins/fullcalendar/vanillaCalendar.css" rel="stylesheet"
              type="text/css" />

        <link href="<?php echo $serverName; ?>/assets/plugins/morris/morris.css" rel="stylesheet">


        <link href="<?php echo $serverName; ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $serverName; ?>/assets/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $serverName; ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $serverName; ?>/assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $serverName; ?>/public/style/main.css" rel="stylesheet" type="text/css">


        <!-- jQuery  -->
        <script src="<?php echo $serverName; ?>/assets/js/jquery.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/js/popper.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/js/modernizr.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/js/waves.js"></script>
        <script src="<?php echo $serverName; ?>/assets/js/jquery.nicescroll.js"></script>

        <script src="<?php echo $serverName; ?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

        <script src="<?php echo $serverName; ?>/assets/plugins/skycons/skycons.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/fullcalendar/vanillaCalendar.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/morris/morris.min.js"></script>


        <!-- Plugins js -->
        <script src="<?php echo $serverName; ?>/assets/plugins/timepicker/moment.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/timepicker/tempusdominus-bootstrap-4.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/clockpicker/jquery-clockpicker.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/colorpicker/jquery-asColor.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/colorpicker/jquery-asGradient.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/colorpicker/jquery-asColorPicker.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/select2/select2.min.js"></script>

        <script src="<?php echo $serverName; ?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="<?php echo $serverName; ?>/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>

</head>


    <body>


        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner"></div>
            </div>
        </div>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                    <div class="logo" style="margin-top: 10px;">
                        <!-- Text Logo -->
                        <!--<a href="index.html" class="logo">-->
                        <!--Zoter-->
                        <!--</a>-->
                        <!-- Image Logo -->
                        <a href="./" class="logo">
                            <img src="<?php echo $serverName; ?>/assets/images/logoCRM.png" height="40"  alt="" class="&">
                            <!--<h4 class="logo-large" style="color:#283179;">CRM</h4>-->
                        </a>
                        
                    </div>
                    <!-- End Logo container-->

                    <div class="menu-extras topbar-custom">

                        <ul class="list-inline float-right mb-0">
                            <li class="list-inline-item hide-phone app-search">
                                <form role="search" class="">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <!-- language
            <li class="list-inline-item dropdown notification-list hide-phone">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <img src="<?php echo $serverName; ?>/assets/images/flags/us_flag.jpg" class="ml-2" height="16" alt="" />
                </a>
                <div class="dropdown-menu dropdown-menu-right language-switch">
                    <a class="dropdown-item" href="#"><img src="<?php echo $serverName; ?>/assets/images/flags/italy_flag.jpg" alt=""
                            height="16" /><span> Italian </span></a>
                    <a class="dropdown-item" href="#"><img src="<?php echo $serverName; ?>/assets/images/flags/french_flag.jpg" alt=""
                            height="16" /><span> French </span></a>
                    <a class="dropdown-item" href="#"><img src="<?php echo $serverName; ?>/assets/images/flags/spain_flag.jpg" alt=""
                            height="16" /><span> Spanish </span></a>
                    <a class="dropdown-item" href="#"><img src="<?php echo $serverName; ?>/assets/images/flags/russia_flag.jpg" alt=""
                            height="16" /><span> Russian </span></a>
                </div>
            </li>
                            -->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" href="#" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="ti-email noti-icon"></i>
                                    <span class="badge badge-danger noti-icon-badge" id="messagesAlert">0</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg" id="textMessages">
                                    
                                </div>
                            </li>
                            <!-- notification-->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                                   role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="ti-bell noti-icon"></i>
                                    <span class="badge badge-danger noti-icon-badge"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5>Notification (<span class="notiiconbadgeTotal"></span>)</h5>
                                    </div>

                                    <!-- item-->
                                    <a href="<?php echo __SERVICESFOLDER__; ?>/alertes.php" class="dropdown-item notify-item alertes-item">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details"><b>Vous avez <text class="notiiconbadge"></text> produits en rupture de stock</b><small class="text-muted">Cliquer ici pour aller vers la page des alertes .</small></p>
                                    </a>
                                    <a href="<?php echo __SERVICESFOLDER__; ?>/alertesretardpaiment.php" class="dropdown-item notify-item alertes-item">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-square-inc-cash"></i></div>
                                        <p class="notify-details"><b>Vous avez <text class="notiiconbadgeLate"></text> paiments en retard</b><small class="text-muted">Cliquer ici pour aller vers la page des alertes .</small></p>
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item other-item">
                                        <div class="notify-icon bg-warning"><i class="mdi mdi-message"></i></div>
                                        <p class="notify-details"><b>New Message received</b><small class="text-muted">You
                                                have
                                                87 unread
                                                messages</small></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item other-item">
                                        <div class="notify-icon bg-info"><i class="mdi mdi-martini"></i></div>
                                        <p class="notify-details"><b>Your item is shipped</b><small class="text-muted">It is
                                                a
                                                long
                                                established fact that a reader will</small></p>
                                    </a>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item other-item">
                                        View All
                                    </a>

                                </div>
                            </li>
                            <!-- User-->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                                   href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img id="nav_user_img" src="<?php echo $serverName; ?>/public/images/<?php echo $_SESSION["user"]->getPhoto() !== null ? $_SESSION["user"]->getPhoto() : "no-photo.png"; ?>" alt="user"
                                         class="rounded-circle" style="object-fit: cover;">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5><?php if ($_SESSION["user"]->getFullName() !== null) echo $_SESSION["user"]->getFullName(); ?> </h5>
                                    </div>
                                    <a class="dropdown-item" href="<?php echo $serverName."/public/profil.php"; ?>"><i
                                            class="mdi mdi-account-circle m-r-5 text-muted"></i>
                                        Profil</a>
                                    <!--<a class="dropdown-item" href="#"><span
                                            class="badge badge-success float-right">5</span><i
                                            class="mdi mdi-settings m-r-5 text-muted"></i> Paramètres</a>-->
                                    <div class="dropdown-divider"></div>
                                    <a id="logout" class="dropdown-item" href="../../../controller/LogoutController.php"><i  class="mdi mdi-logout m-r-5 text-muted"></i>
                                        Déconnexion</a>
                                </div>
                            </li>
                            <li class="menu-item list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <?php include_once './template/menu.php' ?>

        </header>
        <!-- End Navigation Bar-->
