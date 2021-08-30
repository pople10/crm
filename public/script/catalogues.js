
replaceAll = function (Text,searchArray,replaceArray){
    
    if (searchArray.length != replaceArray.length)
        return Text;
    else
    {
       for (var i =0 ; i<searchArray.length;i++){
             Text = Text.replace(searchArray[i].toString(),replaceArray[i].toString());
        }
    }
    
    return Text;
}

$(document).ready(() => {
    $('#datatable-produits tfoot th').each( function () {
        var title = $(this).html();
        $(this).css("border","none");
        if(title!=="")
        $(this).html( '<input style="border: solid black 0.5px;" type="text" placeholder="'+title+'" />' );
    });
    $.fn.dataTable.ext.errMode = 'throw';
    table = $('#datatable-produits').DataTable({
        "columnDefs": [
            { "width": "8%", "targets": 8 }
          ],
		"autoWidth": false,
        "processing": true,
        "serverSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/ProduitController.php",
			type: 'POST',
			data: {op:'datatable'}
            /*dataSrc: function(json){
			  // json.draw = json.draw;
			  // json.recordsTotal = json.recordsTotal;
			   //json.recordsFiltered = json.recordsFiltered;
			   return json.data;
			}*/
        },
        "columns": [{
                "data": "image",
                "render": function(data) {
                    return '<img class="" style="max-width: 81px;height: auto;" src="http://'+window.location.hostname+'/public/images/' + data + '">';
                }
            },
            { "data": "designation_vente" },
            { "data": "designation_achat" },
            { "data": "appellation" },
            { "data": "reference" },
            { "data": "unite_principale" },
            { "data": "tarif_ht" },
            { "data": "tarif_ttc" },
            {
                "data": "reference",
                "render": function(data) {
                    data = "'" + data + "'";
                    return '<button onclick="getProduit(' + data + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button data="" onclick="deleteProduit(' + data + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
                }
            }

        ],
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change clear', function () {

            var v = this.value;
            v = replaceAll(v,["|","?","(",")","[","]","$","*",".","^","\\"], ["\\|","\?","\\(","\\)","\\[","\\]","\\$","\\*","\\.","\\^","\\\\"]);
            console.log(v);
            var vs = v.split("+");

             vs = vs.map(function(v,i,arr){
                return "(?=.*"+v+")";
            });
            
            v = vs.join('');
                    
                    
                    //console.log(this.value);
                    if ( that.search() !== this.value ) {
                        that
                            .search( v )
                            .draw();
                    }
                } );
            } );
        }
    });
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
                        table
                .column( colIdx )
                .search( v )
                .draw();
        } );
    } );
    //console.log(table);
    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });

    table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));

    $("input[type='number']").prop("min", 0)

    var reference_input = $('#reference_input');
    var reference2_input = $('#reference2_input');
    var designationvente_input = $('#designationvente_input');
    var designationachat_input = $('#designationachat_input');
    var appellation_input = $('#appellation_input');
    var description_textarea = $('#description_textarea');
    // var nature_select = $('#nature_select');
    var categorie_select = $('#categorie_select');
    var customFile = $('#customFile');
    var categoriec_select = $('#categoriec_select');
    var famillec_select = $('#famillec_select');
    var sousfamillec_select = $('#sousfamillec_select');
    var marquec_select = $('#marquec_select');
    var gereenstock_check = $('#gereenstock_check');
    var quantite_en_stock_select = $('#quantite_en_stock_select');
    var stockalert_input = $('#stockalert_input');
    var quantitemax_input = $('#quantitemax_input');
    var principaleu_select = $('#principaleu_select');
    var venteu_select = $('#venteu_select');
    var longeur_input = $('#longeur_input');
    var largeur_input = $('#largeur_input');
    var epaisseur_input = $('#epaisseur_input');
    var status1_check = $('#status1_check');
    var status2_check = $('#status2_check');
    var status3_check = $('#status3_check');
    var status4_check = $('#status4_check');
    var tarifht_input = $('#tarifht_input');
    var tva_select = $('#tva_select');
    var tarifttc_input = $('#tarifttc_input');
    var datedu_input = $('#datedu_input');
    var dateau_input = $('#dateau_input');
    var enpromotion_check = $('#enpromotion_check');
    var prixpromoht_input = $('#prixpromoht_input');
    var remise1_input = $('#remise1_input');
    var remise2_input = $('#remise2_input');
    var remise3_input = $('#remise3_input');
    var remise4_input = $('#remise4_input');
    var remise5_input = $('#remise5_input');
    var enregistrer_btn = $("#enregistrer_btn");

    var add_err = function(element, msg) {
        var e = '<ul class="parsley-errors-list filled" id="' + element.prop("id") + '-error"><li class="">' + msg + '</li></ul>';
        element.addClass("parsley-error");
        element.parent().append(e);
        alertify.error(msg);

    }
    var delete_err = function(element) {
        element.removeClass("parsley-error");
        element.parent().find(".parsley-errors-list").remove();
    }

    var enChangeQuantiteMax = function (){
        var r = true;
        delete_err(quantite_en_stock_select);
        var quantiteMax = parseInt(quantitemax_input.val());
        var quantiteStock = parseInt(quantite_en_stock_select.val());

        quantite_en_stock_select.attr("max",quantiteMax);

        if(quantiteMax<quantiteStock)
        {
            add_err(quantite_en_stock_select,"Quantité en stock doit être inférieure à la quantité max");
            r= false;
        }

        return r;
    }

    getProduit = function(ref) {
        $.ajax({
            url: "../../../controller/ProduitController.php",
            type: 'POST',
            async: false,
            data: { op: "findById", reference: ref },
            success: function(result) {
                if (result.response === true) {
                    var data = result.data;
                    $("#_title").text("Modifier Produit");
                    reference_input.val(data.reference);
                    //reference2_input.val(data.reference.match(/[\d\.]+|\D+/g)[1]);
                    reference2_input.attr("hidden", true);
                    reference2_input.attr("disabled", true);
                    designationvente_input.val(data.designation_vente);
                    designationachat_input.val(data.designation_achat);
                    appellation_input.val(data.appellation);
                    description_textarea.val(data.description);
                    tarifht_input.val(data.tarif_ht);
                    tva_select.val("0." + data.tva);
                    tarifttc_input.val(data.tarif_ttc);
                    enpromotion_check.prop("checked", data.en_promotion == "0" ? false : true);
                    datedu_input.val(data.enp_de);
                    dateau_input.val(data.enp_au);
                    prixpromoht_input.val(data.prix_promo);
                    prixpromoht_input.prop("disabled", !enpromotion_check.is(":checked"));
                    remise2_input.val(data.remise_n1);
                    remise3_input.val(data.remise_n2);
                    remise4_input.val(data.remise_n3);
                    remise5_input.val(data.remise_n4);
                    categorie_select.val(data.categorie);
                    famillec_select.val(data.famille);
                    fillSelect(sousfamillec_select, 'SousFamille');
                    sousfamillec_select.prop("disabled", false);
                    sousfamillec_select.val(data.sous_famille);
                    marquec_select.val(data.marque);
                    gereenstock_check.prop("checked", data.gere_en_stock == "0" ? false : true);
                    stockalert_input.val(data.stock_alerte);
                    quantitemax_input.val(data.quantite_max);
                    quantite_en_stock_select.val(data.quantite_en_stock);
                    principaleu_select.val(data.unite_principale);
                    venteu_select.empty();
                    venteu_select.append("<option hidden>" + data.unite_vente + "</option>");
                    $(".unite_span").text(data.unite_principale);
                    longeur_input.val(data.c_longueur);
                    largeur_input.val(data.c_largeur);
                    epaisseur_input.val(data.c_epaisseur);
                    var statut = data.statut.split("");
                    status1_check.prop("checked", statut.includes("F") ? true : false);
                    status2_check.prop("checked", statut.includes("P") ? true : false);
                    status3_check.prop("checked", statut.includes("M") ? true : false);
                    status4_check.prop("checked", statut.includes("A") ? true : false);
                    $("#customFileImg").attr("src", "../../images/" + data.image);
                    $("#customFileImg").attr("lastImg", data.image);
                    $(".custom-file-label").find("span:eq(0)").text("Joindre un fichier");
                    $(".section1").hide();
                    $(".section2").show();
                    $('html, body').animate({
                        scrollTop: 0
                    }, 1000);
                    $("#enregistrer_btn").attr("op", "M");
                }
                //console.log(result);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alertify.error("Opération annulée");
            }
        });
    }

    deleteProduit = function(ref) {
        alertify.confirm("Voulez vous vraiment supprimer ce produit?", function(asc) {
            if (asc) {
                $.ajax({
                    url: "../../../controller/ProduitController.php",
                    type: 'POST',
                    async: false,
                    data: { op: "delete", reference: ref },
                    success: function(result) {
                        //console.log(result);
                        if (typeof(result) == "string" && result.includes("error"))
                            alertify.error("Echec de supprimer ce produit.");
                        else
                            alertify.success("Produit supprimé");

                        table.ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alertify.error("Opération annulée");
                    }
                });
            } else {
                alertify.error("Opération annulée");
            }
        }, function(ev) {
            ev.preventDefault();
            alertify.error("Opération annulée");
        });
    }
    var fillSelect = function(select, table) {
        var d = {};
        if (table == "SousFamille")
            d = { id: famillec_select.find(":selected").val() };

        $.ajax({
            url: "../../../controller/" + table + "Controller.php",
            type: 'POST',
            async: false,
            data: d,
            success: function(result) {
                var t = "";
                //console.log(table);
                if (table == "Famille")
                    result.data = result;
                //console.log(result.data);
                for (var i = 0; i < result.data.length; i++) {
                    var value = result.data[i].id;
                    var text = table == "Categorie" ? result.data[i].libelle : result.data[i].nom;

                    t += "<option value='" + value + "'>" + text + "</option>";
                }
                select.empty();
                select.append(t);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    var calcTTC = function(prixHT, tva) {
        return parseFloat(prixHT) + (parseFloat(prixHT) * parseFloat(tva));
    }

    $(".boolean_check").change(function() {
        if ($(this).is(":checked"))
            $(this).attr("data", 1);
        else
            $(this).attr("data", 0);
    });

    $("input[name='status_check']").change(function() {
        if ($(this).is(":checked"))
            $(this).attr("data", $(this).parent().find("label:eq(0)").text()[0]);
        else
            $(this).attr("data", "");
    });

    customFile.change(function() {
        var filename = "Joindre un fichier";
        var src = "";
        var file = customFile[0];
        if (file != null) {
            filename = file.files[0].name;
            src = file.value;
        } else
            $("#customFileImg").attr("lastImg", "no-photo.png");

        $(".custom-file-label").find("span:eq(0)").text(filename);
        $("#customFileImg").prop("src", "");
    });

    var compareRemises = function() {
        var r = false;
        $.each($(".remisesn"), function(i, v) {
            delete_err($(this));
            var remise = parseFloat(remise1_input.val());
            if (parseFloat($(this).val()) > remise) {
                add_err($(this), "Vous avez dépasser la remise maximale autorisé pour ce produit.");
                r = true;
            }
        });

        return r;
    }

    remise1_input.change(function() {
        compareRemises();
    });
    $(".remisesn").change(function() {
        compareRemises();
    });

    tarifht_input.change(function() {
        tarifttc_input.val(calcTTC($(this).val(), tva_select.val()));
    });
    tva_select.change(function() {
        tarifttc_input.val(calcTTC(tarifht_input.val(), tva_select.val()));
    });

    var uploadImg = function() {
        var r = false;
        var fd = new FormData();
        var files = customFile[0].files[0];
        if (files != null) {
            fd.append('file', files);
            fd.append('reference', reference_input.val());
            $.ajax({
                url: "../../../controller/Upload.php",
                type: 'POST',
                async: false,
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result == 0 || result == 1)
                        r = "no-photo.png";
                    else
                        r = result;
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    r = "no-photo.png";
                }
            });
        } else if (enregistrer_btn.attr("op") == "N")
            r = "no-photo.png";
        else
            r = $("#customFileImg").attr("lastImg");

        return r;
    }


    fillSelect(categoriec_select, 'Categorie');
    fillSelect(famillec_select, 'Famille');
    fillSelect(marquec_select, 'Marque');

    if (famillec_select.find("option").length > 0) {
        fillSelect(sousfamillec_select, 'SousFamille');
        sousfamillec_select.prop("disabled", false);
    }

    famillec_select.change(function() {
        fillSelect(sousfamillec_select, 'SousFamille');
        sousfamillec_select.prop("disabled", false);
        generateRef();
    });

    reference_input.change(function() {
        delete_err(reference_input);
        if (reference_input.val() == "")
            add_err(reference_input, "Merci de renseigner la référence du produit.")
        else if (isRefExists())
            add_err(reference_input, "La référence de produit est déja existe!");
    });
    var isRefExists = function() {
        var r = true;
        $.ajax({
            url: "../../../controller/ProduitController.php",
            type: 'POST',
            async: false,
            data: { op: "findById", reference: reference_input.val() + reference2_input.val() },
            success: function(result) {
                r = result.data;
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
        return r;
    }

    var changeDate = function(date) {
        if (date == "")
            return "";
        var d = date.split("/");
        return d[2] + "-" + d[0] + "-" + d[1];
    }

    enregistrer_btn.click(function() {
        var r = false;
        var ssfamille = sousfamillec_select.val();

        if (sousfamillec_select.val() == null || sousfamillec_select.val() == "")
            ssfamille = famillec_select.val();

        var data = { reference_input: reference_input.val() + reference2_input.val(), designationvente_input: designationvente_input.val(), designationachat_input: designationachat_input.val(),appellation: appellation_input.val(), description_textarea: description_textarea.val(), customFile: uploadImg(), categoriec_select: categoriec_select.val(), famillec_select: ssfamille, marquec_select: marquec_select.val(), gereenstock_check: gereenstock_check.attr('data'), stockalert_input: stockalert_input.val(),quantitemax_input: quantitemax_input.val(), principaleu_select: principaleu_select.val(), venteu_select: venteu_select.val(), longeur_input: longeur_input.val(), largeur_input: largeur_input.val(), epaisseur_input: epaisseur_input.val(), status1_check: status1_check.attr('data'), status2_check: status2_check.attr('data'), status3_check: status3_check.attr('data'), status4_check: status4_check.attr('data'), tarifht_input: tarifht_input.val(), tva_select: parseFloat(tva_select.val()) * 100, tarifttc_input: tarifttc_input.val(), datedu_input: changeDate(datedu_input.val()), dateau_input: changeDate(dateau_input.val()), enpromotion_check: enpromotion_check.attr('data'), prixpromoht_input: prixpromoht_input.val(), remise2_input: remise2_input.val(), remise3_input: remise3_input.val(), remise4_input: remise4_input.val(), remise5_input: remise5_input.val(),quantite_en_stock : quantite_en_stock_select.val() };

        $(".parsley-error").removeClass("parsley-error");
        $(".parsley-errors-list").remove();
        if ($(this).attr("op") == "N") {
            if (reference_input.val() == "" || reference2_input.val() == "") {
                add_err(reference2_input, "Merci de renseigner la référence du produit.");
            }else if (reference2_input.val().length > 8) {
                add_err(reference2_input, "La référence ne doit pas dépasser 8 caractères.");
            } else if (isRefExists()) {
                add_err(reference2_input, "La référence de produit est déja existant!");
            } else if (compareRemises() || enChangeQuantiteMax() == false) {

            } else {
                r = true;
                data.op = "add";
            }
        } else {

            if (!isRefExists())
                add_err(reference_input, "La référence de produit n'est existe pas!");
            else if (compareRemises() || enChangeQuantiteMax()== false) {

            } else {
                r = true;
                data.op = "update";
            }
        }


        if (r) {
            $.ajax({
                url: "../../../controller/ProduitController.php",
                type: 'POST',
                async: false,
                data: data,
                success: function(result) {
                    r = result.data;
                    m = data.op == "add" ? "ajouté" : "modifié";
                    alertify.success("Produit " + m + " avec succès");
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    m = data.op == "add" ? "d'ajouter" : "de modifier";
                    alertify.error("Echec " + m + " le produit");
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
        }
    });

    sousfamillec_select.change(function() {
        generateRef();
    });

    categoriec_select.change(function() {
        generateRef();
    })

    var generateRef = function() {
        var t1 = $("#famillec_select").find("option:selected").text().substring(0, 2);
        var t2 = $("#sousfamillec_select").find("option:selected").text().substring(0, 2);
        var c1 = $("#categoriec_select").find("option:selected").text().substring(0, 2);
        var t = t1 + t2 + c1;
        if (enregistrer_btn.attr("op") == "N")
            reference_input.val(t.toUpperCase());
    }

    $("#nouveau_btn").click(function() {
        generateRef();
        quantitemax_input.val(0);
        quantite_en_stock_select.val(0);
        enChangeQuantiteMax();
    })

    $("#quantitemax_input, #quantite_en_stock_select").change(function(){
        enChangeQuantiteMax();
    })

});

$(document).on('click', '.supprimer', function() {


});