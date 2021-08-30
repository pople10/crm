$(document).ready(() => {
    table = $('#datatable-produits').DataTable({
        'serverSide':true,
        'processing':true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/ProduitController.php",
            cache: false,
            dataSrc: 'data',
            data:{op:"findAllAlertes"},
            type:"POST"
        },
        /*'createdRow':function(row,_data,index){
            var data = {reference:_data[1],quantite_max:_data[7]};
            var cell = '<button type="button" data-toggle="modal" data-reference="'+data.reference+'" quantite-max="'+data.quantite_max+'" data-animation="bounce" data-target="#commandeModal" type="button" class="btn btn-sm btn-success" style="float: none;" ><span class="mdi mdi-cart-plus" style="margin-right:2px;"></span>Commander</button>';
            $(row).find('td:last').html(cell);
        }*/
        "columns": [{
            "data": "image",
            "render": function(data) {
                return '<img class="" style="max-width: 81px;height: auto;" src="http://'+window.location.hostname+'/public/images/' + data + '">';
            }
        },

            { "data": "reference" },
            { "data": "designation_vente" },
            { "data": "unite_principale" },
            { "data": "quantite_en_stock" },
            { "data": "tarif_ht" },
            { "data": "tarif_ttc" },
            { "data" : null, "render" : function(data){
                    return '<button data-toggle="modal" data-reference="'+data.reference+'" quantite-max="'+data.quantite_max+'" data-animation="bounce" data-target="#commandeModal" type="button" class="btn btn-sm btn-success" style="float: none;" ><span class="mdi mdi-cart-plus" style="margin-right:2px;"></span>Commander</button>';} }

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
    var suppliers = [];
    var MaxVal = 0;
    var prodID = 0;
    var setTodayDateMax = function (e) {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }
    
        today = yyyy+'-'+mm+'-'+dd;
        document.getElementById(e).setAttribute("max", today);
    }
    $("#commandeModal").on('show.bs.modal',function(event){
        var button = $(event.relatedTarget);
        $("#reference").html(button.attr("data-reference"));
        $.ajax({
             url : "../../../controller/FournisseurController.php",
                async : false,
                success: function(datos){
                    var da="";
                    datos.data.forEach(function(d){
                        var prenom="";
                        var nom="";
                        if(d.prenom!=null)
                            prenom=d.prenom;
                        if(d.nom!=null)
                            nom=d.nom;
                        suppliers.push(d.id);da+="<option value='"+d.id+"'>"+nom+" " +prenom+"</option>";
                    });
                    $("#supplierChosen").selectize()[0].selectize.destroy();
        			$("#supplierChosen").empty().append(da);
        			$("#supplierChosen").selectize({
                        sortField: 'text'
                    });
                }
        });
        $("#quantityChosen").attr("max",parseInt(button.attr("quantite-max")));
        MaxVal=parseInt(button.attr("quantite-max"));
        $("#quantitemax_span").html("Max : "+button.attr("quantite-max"));
        $("#commanderButton").attr("data-reference",button.attr("data-reference"));
        prodID=button.attr("data-reference");
        setTodayDateMax("date_input1");
    });
    $("#commanderButton").click(function(){
        if($("#quantityChosen").val()!="" && parseInt($("#quantityChosen").val())!=0)
        {   var qty = $("#quantityChosen").val();
            var supplierID = $("#supplierChosen").val();
            var date = $("#date_input1").val();
            var price = $("#price").val();
            var priceToInsert = parseFloat(price).toFixed(2).toString();
            if(isNormalInteger(qty)){
            if(parseInt(qty)<=MaxVal){
            var LastInseredID=0;
            var flag=false;
            suppliers.forEach(function(d){if(d==supplierID) flag=true;});
            if(flag===true){
                if(prodID!=0)
                {
                    if(date!="")
                    {   
                        if(isNormalFloat(price)&&parseFloat(price)>0)
                        {
                            $.ajax({
                                url: "../../../controller/CommandeAchatController.php",
                                type: 'POST',
                                async: true,
                                data: {op : "add",fournisseur : supplierID,date : date},
                                success: function(result) {
                                    alertify.success("La commande est creée avec succes");
                                    $.ajax({
                                        url : "../../../controller/CommandeAchatController.php",
                                        type:"POST",
                                        data:{op:"lastID"},
                                        async : false,
                                        success: function(datos){var MaxId=0;
                                            datos.data.forEach(function(d){
                                            MaxId=d.Max;});
                                            LastInseredID=parseInt(MaxId);
                                        }
                                    });
                                    $.ajax({
                                        url: "../../../controller/CommandeAchatProduitController.php",
                                        type: 'POST',
                                        async: true,
                                        data: { op: "add", commande: LastInseredID, produit: prodID, prix: priceToInsert, quantite: qty },
                                        success: function(result) {
                        
                                            if (typeof result == "string" && result.includes("error"))
                                                alertify.error("Echec d'ajouté le produit à la commande");
                                            else
                                                alertify.success("Ajouté avec succès");
                                            table.ajax.reload();
                        
                                        },
                                        error: function(xhr, status, error) {
                                            alertify.error("Echec d'ajouté le produit à la commande");
                                        }
                                    });
                                },
                                error: function(xhr, status, error) {
                                    alertify.error("Echec de commander le produit " + prodID);
                                    console.log(xhr + " - " + status + " - " + error);
                                }
                            });
                        }
                        else alertify.error("Le prix doit être un reel");
                    }
                    else alertify.error("Veuillez choisir une date");
                }
                else alertify.error("Le produit n'existe pas");
            }
            else alertify.error("Le fournissuer n'existe pas");
        }
                else alertify.error("La quantité doit être inférieure à la quantité maximale");
            }
            else alertify.error("La quantité doit être un entier naturel");
        }
        else alertify.error("Veuillez choisir une quantité");
    });
    $("#price , #quantityChosen").change(function(){
        var price_Total = parseFloat(parseInt($("#quantityChosen").val()==""?0:$("#quantityChosen").val())*parseFloat($("#price").val()==""?0:$("#price").val())).toFixed(2);
        $("#priceTotal").html(price_Total);
    });
});