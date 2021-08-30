    function block(id)
    {
        $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            async:true,
            data:{op:"UpdateEtat",etat:"bloqué",id:id},
            success:function(datos){
                alertify.success("Le client " + (datos.nom===null?"":datos.nom) + " " + (datos.prenom===null?"":datos.prenom) + " a été bloqué avec sucess" );
                table.ajax.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr + " - " + status + " - " + error);
                alertify.error("Le client " + (datos.nom===null?"":datos.nom) + " " + (datos.prenom===null?"":datos.prenom) + " n'est pas bloqué avec sucess" );
            }
        });
    }
    function unblock(id)
    {
        $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            async:true,
            data:{op:"UpdateEtat",etat:"",id:id},
            success:function(datos){
                alertify.success("Le client " + (datos.nom===null?"":datos.nom) + " " + (datos.prenom===null?"":datos.prenom) + " a été debloqué avec sucess" );
                table.ajax.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr + " - " + status + " - " + error);
                alertify.error("Le client " + (datos.nom===null?"":datos.nom) + " " + (datos.prenom===null?"":datos.prenom) + " n'est pas debloqué avec sucess" );
            }
        });
    }
$(document).ready(() => {
    table = $('#datatable-produits').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/AlertLatePaymentController.php",
            cache: false,
            dataSrc: 'data',
            type:"POST"
        },
        "columns": [
            { "data": "client" },
            { "data": "genre" },
            { "data": "id" },
            { "data": "date" },
            { "data": "duration","className": "red" },
            { "data": null,"render":function(data){return (data.total_ht==null && data.tva==null)?"":parseFloat(data.total_ht)+parseFloat(data.tva);} },
            { "data": "paid" },
            { "data": "unpaid" },
            { "data": null, "render" : function(data){ if(data.etat==null || data.etat!="bloqué") {return '<button onclick="block('+data.clientID+')" class="btn btn-danger"><i class="mdi mdi-account-off" style="margin-right:5px;font-size: 16px;"></i>Bloquer</button>';} else return 'Bloqué';} }
        ]
    });
    //console.log(table);
    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });
     function isNormalInteger(str) {
    var n = Math.floor(Number(str));
    return n !== Infinity && String(n) === str && n >= 0;
    }
    function isNormalFloat(str) {
    var n = Number(str);
    return n !== Infinity && String(n) === str;
    }
    table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));
});