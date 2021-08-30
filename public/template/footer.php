<?php

    
?>

<!-- Required datatable js -->
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/jszip.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

<script src="<?php echo $serverName; ?>/assets/plugins/tiny-editable/mindmup-editabletable.js?r=<?php echo rand();?>"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/tiny-editable/numeric-input-example.js"></script>
<script src="<?php echo $serverName; ?>/assets/plugins/tabledit/jquery.tabledit.js?r=<?php echo rand();?>"></script>

<script src="<?php echo $serverName; ?>/assets/plugins/alertify/js/alertify.js"></script>

<script src="<?php echo $serverName; ?>/assets/pages/dashborad.js"></script>

<script src="<?php echo $serverName; ?>/assets/js/jspdf.min.js"></script>
<script src="<?php echo $serverName; ?>/assets/js/jspdf.plugin.autotable.js"></script>

<script src="<?php echo $serverName; ?>/assets/js/tableHTMLExport.js"></script>

<script src="<?php echo $serverName; ?>/assets/js/selectize.js"></script>



<!-- Datatable init js -->
<!--<script src="<?php //echo $serverName; ?>/assets/pages/datatables.init.js"></script>-->
<!-- Plugins Init js -->
<script src="<?php echo $serverName; ?>/assets/pages/form-advanced.js"></script> 

<!-- Parsley js -->
<script type="text/javascript" src="<?php echo $serverName; ?>/assets/plugins/parsleyjs/parsley.min.js"></script>

<!-- App js -->
<script src="<?php echo $serverName; ?>/assets/js/app.js?r=<?php echo rand();?>"></script>

<!-- Main js -->
<script src="<?php echo $serverName; ?>/public/script/main.js?r=<?php echo rand();?>"></script>

<!-- For Blocking clients by limit date -->
<script src="../../script/checkclientdatelimit.js?r=<?php echo rand();?>" type="text/javascript"></script>

<script>

$(document).ready(function () {
    getAlertes = function () {
        var r = null;
        $.ajax({
            url: "../../../controller/ProduitController.php",
            type: 'POST',
            async: false,
            data: { op: "findAllAlertesCount"},
            success: function(result) {
                r = isNaN(result.data)? 0 : parseInt(result.data);
            },
            error: function(xhr, status, error) {

            }
        });
        
        return r;
    };
    getAlertsLatePayment = function(){
        var r = null;
        $.ajax({
            url: "../../../controller/AlertLatePaymentController.php",
            type: 'POST',
            async: false,
            data: { op: "Count"},
            success: function(result) {
                r = isNaN(result.data)? 0 : parseInt(result.data);
            },
            error: function(xhr, status, error) {

            }
        });
        return r;
    };
    getMessagesAlert = function(){
        var r =0;
        $.ajax({
            url: "../../../controller/ActionController.php",
            type: 'POST',
            async: false,
            data: { op: "getAlert"},
            success: function(result) {
                result.forEach(function(d){
                r = isNaN(d.nbr)? 0 : parseInt(d.nbr);});
            },
            error: function(xhr, status, error) {

            }
        });
        return r;
    };
    getMessages = function(){
        var r =0;
        $.ajax({
            url: "../../../controller/ActionController.php",
            type: 'POST',
            async: false,
            data: { op: "getAlertData"},
            success: function(result) {
                result.forEach(function(d){
                    var text = "";
                    if(d.client!==null && d.fournisseur === null)
                        {text =" Vous avez une action à réaliser pour le client";
                        var datos = $.ajax({url:"../../../controller/ClientController.php",type:"POST",async:false,data:{op:"findById",id:d.client}}).responseText;
                        datos=JSON.parse(datos);
                        text+= " " + (datos.nom==null?"":datos.nom) + " " + (datos.prenom==null?"":datos.prenom);}
                    else if(d.client===null && d.fournisseur !== null)
                        {text =" Vous avez une action à réaliser pour le client";
                        var datos = $.ajax({url:"../../../controller/FornisseurController.php",type:"POST",async:false,data:{op:"findById",id:d.fournisseur}}).responseText;
                        datos=JSON.parse(datos);
                        text+= " " + (datos.nom==null?"":datos.nom) + " " + (datos.prenom==null?"":datos.prenom);}
                    else
                        alert("There is an error at the footer");
                    $("#textMessages").append('<a href="<?php echo __CONTACTSFOLDER__; ?>/actions.php?id='+d.id+'" class="dropdown-item notify-item alertes-item"><div class="notify-icon bg-success"><i class="mdi mdi-message-reply-text"></i></div><p class="notify-details"><b>Vous avez une action</b><small class="text-muted">'+text+'</small></p></a>');
                });
            },
            error: function(xhr, status, error) {

            }
        });
        return r;
    };
    $(".other-item").hide();
    var alertes = getAlertes()+getAlertsLatePayment();
    var AlertMessages = getMessagesAlert();
    if(alertes == 0){
        $(".noti-icon-badge").hide();
        $(".notiiconbadge").text(0);
        $(".notiiconbadgeTotal").text(0);
        $(".alertes-item").hide();
    }
    else{
        $(".noti-icon-badge").text(alertes);
        $(".notiiconbadgeTotal").text(alertes);
        $(".notiiconbadge").text(getAlertes());
        $(".notiiconbadgeLate").text(getAlertsLatePayment());

    }
    if(AlertMessages==0){
        {$("#messagesAlert").hide();$("#textMessages").hide()}
    }
    else
    $("#messagesAlert").text(AlertMessages);
    getMessages();
});

</script>



<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                &copy; <?php echo date("Y"). ' <a href="'.$serverName.'">CRM</a>'; ?>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

</body>

</html>