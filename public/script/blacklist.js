    function unblock(id)
    {   
        var client = $.ajax({url: "../../../controller/ClientController.php", type:"POST", async:false, data:{op:"findById",id:id}}).responseText;
        client=JSON.parse(client);
        var dateLimit;
        if(client.dateLimit!==null && client.dateLimit!=="0000-00-00")
            dateLimit="0000-00-00";
        $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            async:true,
            data:{op:"UpdateEtat",etat:"",id:id,dateLimit:dateLimit},
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
    table = $('#datatable-clients').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/ClientController.php",
            cache: false,
            dataSrc:'data',
            type:"POST",
            data:{op:"getBlackListed"}
        },
        /*'createdRow':function(row,_data,index){
            var data = {reference:_data[1],quantite_max:_data[7]};
            var cell = '<button type="button" data-toggle="modal" data-reference="'+data.reference+'" quantite-max="'+data.quantite_max+'" data-animation="bounce" data-target="#commandeModal" type="button" class="btn btn-sm btn-success" style="float: none;" ><span class="mdi mdi-cart-plus" style="margin-right:2px;"></span>Commander</button>';
            $(row).find('td:last').html(cell);
        }*/
        "columns": [
            { "data": "id" },
            { "data": "nom" },
            { "data": "prenom" },
            { "data": "email" },
            { "data": "telephone" },
            { "data": null,"render":function(data){return "<p>Adresse : "+(data.adresse===null?"":data.adresse)+"</p>"+"<p>ville : "+(data.ville===null?"":data.ville)+"</p>"+"<p>Pays : "+(data.pays===null?"":data.pays)+"</p>";} },
            { "data": null, "render" : function(data){ return '<center><button onclick="unblock('+data.id+')" class="btn btn-success"><i class="mdi mdi-account-key" style="margin-right:5px;font-size: 16px;"></i>Débloquer</button></center>'; }}
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