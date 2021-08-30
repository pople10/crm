    var getData = findGetParameter("id");
    var reloadPage = function()
    {   
        window.location.href = "actions.php";
    };
    var regler = function(id)
    {
        $.ajax({url: "../../../controller/ActionController.php",
            type:"POST",
            data:{op:"updateEtat",id:id,etat:"Réglée"},
            async:false,
            success:function(){
                alertify.success("L'action a été reglée");
                if(getData!==null && getData!=="")
                    setTimeout(function(){location.reload();},1000);
                else
                    $('#datatable-actions').DataTable().ajax.reload();
            },
            error:function(){alertify.error("L'action ne peut pas être reglée");}
        });
    };
    var deregler = function(id)
    {
        $.ajax({url: "../../../controller/ActionController.php",
            type:"POST",
            data:{op:"updateEtat",id:id,etat:"Non Réglée"},
            async:false,
            success:function(){
                alertify.success("L'action a été déreglée");
                if(getData!==null && getData!=="")
                    setTimeout(function(){location.reload();},1000);
                else
                    $('#datatable-actions').DataTable().ajax.reload();
            },
            error:function(){alertify.error("L'action ne peut pas être déreglée");}
        });
    };
    var deletes = function(id)
    {
        $.ajax({url: "../../../controller/ActionController.php",
            type:"POST",
            data:{op:"delete",id:id},
            async:false,
            success:function(){
                alertify.success("L'action a été supprimée");
                if(getData!==null && getData!=="")
                    setTimeout(function(){location.reload();},1000);
                else
                    $('#datatable-actions').DataTable().ajax.reload();
            },
            error:function(){alertify.error("L'action ne peut pas être supprimée");}
        });
    };
    var updateAction = function(id)
    {
        $.ajax({url: "../../../controller/ActionController.php",
            type:"POST",
            data:{op:"findById",id:id},
            async:false,
            success:function(d){
                var who;
                if((d.fournisseur===null||d.fournisseur==="")&&(d.client!==null||d.client!==""))
                    who="c"+d.client;
                else if((d.fournisseur!==null||d.fournisseur!=="")&&(d.client===null||d.client===""))
                    who="f"+d.fournisseur;
                $("#civilite_select").val(who);
                $("#date_input").val(d.date);
                $("#dateecheance_input").val(d.dateEchance);
                $("#encharge_select").val(d.enCharge);
                $("#descriptif_textarea").text(d.commentaire);
                $("#enregistrer_btn").attr("n","modify").attr("data-id", id).attr("etat",d.etat);
                $("#enregistrer_btn").html('<i class="mdi mdi-content-save"></i>Modifier');
                $(".section1").hide();
                $(".section2").show();
                $('html, body').animate({
                    scrollTop: 0
                }, 1000);
                
            },
            error:function(){alertify.error("L'action ne peut pas être supprimée");}
        });
    };
    
$(document).ready(function () {
    load();
    var id = 0;
    if(getData!==null && getData!=="")
    {
    var datos= $.ajax({url: "../../../controller/ActionController.php",
            type:"POST",
            data:{op:"findByIdTable",id:parseInt(getData)},
            async:false
            }).responseText;
    datos=JSON.parse(datos);
    var tables=[
        {
            "id": datos.id,
            "date": datos.date,
            "dateEchance": datos.dateEchance,
            "enCharge":datos.enCharge,
            "commentaire": datos.commentaire,
            "client": datos.client,
            "fournisseur": datos.fournisseur,
            "us": datos.us,
            "cl": datos.cl,
            "fo": datos.fo,
            "etat":datos.etat
        }
        ];
    table = $('#datatable-actions').DataTable({
        "scrollX": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        data:tables,
        "columns": [
            {"data": "etat"},
            {"data": "date"},
            {"data": "us"},
            {"data": "dateEchance"},
            {"data": "cl"},
            {"data": "fo"},
            {"data": "commentaire"},
            {
                "data": null,
                "render": function (datas) {
                    if(datas.etat!="Réglée")
                return '<button type="button" class="update tabledit-edit-button btn btn-sm btn-success regler" onclick="regler('+ datas.id +')" style="float: none; margin: 5px;"> <i class="mdi mdi-calendar-check"></i> Régler</button><button type="button" onclick="updateAction('+ datas.id +')" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button type="button" onclick="deletes('+ datas.id +')" class="delete tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;"><span class="ti-trash"></span></button><button type="button" onclick="reloadPage()" class="btn btn-info"><i class="mdi mdi-reload"></i>Voir tous</button>';
                    else 
                return '<button type="button" class="update tabledit-edit-button btn btn-sm btn-warning deregler" onclick="deregler('+ datas.id +')" style="float: none; margin: 5px;"> <i class="mdi mdi-calendar-check"></i>Dérégler</button><button type="button" onclick="updateAction('+ datas.id +')" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button type="button" onclick="deletes('+ datas.id +')" class="delete tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;"><span class="ti-trash"></span></button><button type="button" onclick="reloadPage()" class="btn btn-info"><i class="mdi mdi-reload"></i>Voir tous</button>';
                }
            }

        ]
    });
    }
    else{
        table = $('#datatable-actions').DataTable({
        "scrollX": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/ActionController.php",
            cache: false,
            dataSrc: 'data'
        },
        "columns": [
            {"data": "etat"},
            {"data": "date"},
            {"data": "us"},
            {"data": "dateEchance"},
            {"data": "cl"},
            {"data": "fo"},
            {"data": "commentaire"},
            {
                "data": null,
                "render": function (datas) {
                    if(datas.etat!="Réglée")
                return '<button type="button" class="update tabledit-edit-button btn btn-sm btn-success regler" onclick="regler('+ datas.id +')" style="float: none; margin: 5px;"> <i class="mdi mdi-calendar-check"></i> Régler</button><button type="button" onclick="updateAction('+ datas.id +')" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button type="button" onclick="deletes('+ datas.id +')" class="delete tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
                    else 
                return '<button type="button" class="update tabledit-edit-button btn btn-sm btn-warning deregler" onclick="deregler('+ datas.id +')" style="float: none; margin: 5px;"> <i class="mdi mdi-calendar-check"></i>Dérégler</button><button type="button" onclick="updateAction('+ datas.id +')" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button type="button" onclick="deletes('+ datas.id +')" class="delete tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
                }
            }

        ]
    });}
    
    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });

    table.buttons().container()
            .appendTo($('.datatable-btns', table.table().container()));
    
    function load() {
        $.ajax({
            url: "../../../controller/ActionController.php",
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                //console.log(JSON.stringify(data));
                for (i = 0; i < data["cList"].length; i++) {
                    $("#civilite_select").append('<option value ="c' + data["cList"][i].id + '">' + data["cList"][i].nom + ' (Client)</option>');
                }
                for (i = 0; i < data["fList"].length; i++) {
                    $("#civilite_select").append('<option value ="f' + data["fList"][i].id + '"> ' + data["fList"][i].nom + ' (Fournisseur)</option>');
                }
                for (i = 0; i < data["mList"].length; i++) {
                    $("#encharge_select").append('<option value ="' + data["mList"][i].id + '"> ' + data["mList"][i].nom + ' ' + data["mList"][i].prenom + ' </option>');
                }
            },
            error: function (data) {
                alert(data);
            }
        });

    }
    $("#enregistrer_btn").click(function () {
        
        if($(this).attr("n")=="add"){
        var f = "", c = "";
        if ($("#civilite_select").val().slice(0, 1) === 'c') {
            c = $("#civilite_select").val().slice(1);
        } else if ($("#civilite_select").val().slice(0, 1) === 'f') {
            f = $("#civilite_select").val().slice(1);
        }
        $.ajax({
            url: "../../../controller/ActionController.php",
            data: {
                id: id,
                client: c,
                fournisseur: f,
                date: $("#date_input").val(),
                dateEchance: $("#dateecheance_input").val(),
                enCharge: $("#encharge_select").val(),
                commentaire: $("#descriptif_textarea").val(),
                op: 'add'
            },
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                c = "NULL";
                f = "NULL";
                if(getData!==null && getData!=="")
                    {}
                else
                    table.ajax.reload();
                op = 'add';
                id = 0;
                alertify.success("Opération réussie");
            },
            error: function (data) {
                alert(JSON.stringify(data));
                alertify.error("Opération annulée");
            }
        });}
        //console.log($(this).attr("data-id"),c,f,$(this).attr("etat"),$("#date_input").val(),$("#dateecheance_input").val(),$("#encharge_select").val())
        else if($(this).attr("n")=="modify"){
        var f = "null", c = "null";
        if ($("#civilite_select").val().slice(0, 1) === 'c') {
            c = $("#civilite_select").val().slice(1);
        } else if ($("#civilite_select").val().slice(0, 1) === 'f') {
            f = $("#civilite_select").val().slice(1);
        }
         $.ajax({
            url: "../../../controller/ActionController.php",
            data: {
                id: $(this).attr("data-id"),
                client: c,
                fournisseur: f,
                etat:$(this).attr("etat"),
                date: $("#date_input").val(),
                dateEchance: $("#dateecheance_input").val(),
                enCharge: $("#encharge_select").val(),
                commentaire: $("#descriptif_textarea").val(),
                op: 'update'
            },
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                c = "NULL";
                f = "NULL";
                if(getData!==null && getData!=="")
                    {}
                else
                    table.ajax.reload();
                op = 'update';
                id = 0;
                alertify.success("Modification réussie");
            },
            error: function (data) {
                alert(data.responseText);
                alertify.error("Modification annulée");
            }
        });  
        }
    $(".section2").hide();
    $(".section1").show();
    });

});

