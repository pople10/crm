/* ------------------------  VARIABLES ---------------------------- */

var enregistrer_btn = $("#enregistrer_btn");
var client_select = $("#client_select");
var date_input = $("#date_input");
var ajouter_btn = $("#ajouter_btn");
var produit_select = $("#produit_select");
var prix_input = $("#prix_input");
var quantite_input = $("#quantite_input");
var remise_input = $("#remise_input");
var transfer_btn = $("#transferer_btn");
var __COMPROLENGTH__ = 0;
var __ETAT__ = "";
var __DATA__ = [];
var __CURRENTCOMMANDE__ = {};
var __CURRENTCOMMANDEREF__ = {};
var cl = null;
var mode=null;


/* ------------------------- FUNCTIONS ----------------------------- */
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
var getQuantiteMax = function(produit){
    var r = 0;
    $.ajax({
        url: "../../../controller/ProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "findById", reference: produit },
        success: function(result) {
            if(typeof (result) == "object" && result.data != false)
                r = parseInt(result.data.quantite_en_stock);
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
    return r;
}

var getAllProducts = function(commande) {
    var d = "";
    /*$.ajax({
        url: "../../../controller/ProduitController.php",
        type: 'POST',
        async: false,
        data: { op:"findAllByCommandeVente",commande : commande},
        success: function(result) {
            //console.log(result);
            result.data.forEach((e, i) => {
                if(e.designation_vente)
                d += '<option value="' + e.reference + '" >' + e.designation_vente + ' ( Quantité : '+ e.quantite_en_stock +" "+ e.unite_principale+ ' ) </option>';
                else
                d += '<option value="' + e.reference + '" >' + e.designation_achat + ' ( Quantité : '+ e.quantite_en_stock +" "+ e.unite_principale+ ' ) </option>';
            });
            produit_select.selectize()[0].selectize.destroy();
            produit_select.empty().append(d);


        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
    var qmax = getQuantiteMax(produit_select.val());
    quantite_input.val(qmax);
    getLastPrice(commande,produit_select.val());
    produit_select.selectize({
        sortField: 'text'
    });
    $("#quantitemax_span").text("Max : " + qmax);
    // quantite_input.prop("max",qmax);*/
    
    produit_select.selectize()[0].selectize.destroy();
    $('#produit_select').selectize({
            valueField: 'reference',
            labelField: '_designation',
            searchField: '_designation',
            options: [],
            create: false,
            render: {
                option: function(item, escape) {
                    return "<div><span class='ml-2'>"+escape(item._designation)+"</span></div>";
                }
            },
            load: function(query, callback) {
                this.clearOptions();        // clear the data
                this.renderCache = {};      // clear the html template cache
                if (!query.length) return callback();
                $.ajax({
                    url: "../../../controller/ProduitController.php",
                    type: 'POST',
                    data: { 
                        op:"findAllByCommandeVente",
                        commande : commande,
                        query: query
                    },
                    dataType: 'json',
                    error: function() {
                        //console.log("error")
                        callback();
                    },
                    success: function(res) {
                        //console.log("success");
                        callback(res.data);
                    }
                });
            }
        });
        
    return d;
}
var add_err = function(element, msg) {
    var e = '<ul class="parsley-errors-list filled" id="' + element.prop("id") + '-error"><li class="">' + msg + '</li></ul>';
    element.addClass("parsley-error");
    element.parent().append(e);

}
var delete_err = function(element) {
    element.removeClass("parsley-error");
    element.parent().find(".parsley-errors-list").remove();
}
var getFinalQuantiteMax = function (e,quantiteMax) {
    var currentQuantite = parseInt(e.parent().find(".tabledit-span").eq(0).text());
    var sumMax = quantiteMax+currentQuantite;
    var thisVal = parseInt(e.val())
    var final = thisVal-currentQuantite;
    // e.prop("max",sumMax);
    e[0].classList.remove('parsley-error-focus');
    $(".tabledit-save-button").prop("disabled",false);
    if(!e[0].checkValidity())
    {
        e.attr("title","La quantité doit être inférieur où égale : "+sumMax);
        e[0].classList.add('parsley-error-focus');
        $(".tabledit-save-button").prop("disabled",true);
    }


    return final;
}
var fillCommandeTable = function(_commande) {
    getAllProducts(_commande);
    $("#prix_input , #remise_input , #quantite_input").val(0);
    $(".quantitemax_span").text(0);
    getTotalPrix();
    transfer_btn.hide();
    var thead = ajouter_btn.attr("data-type") == "demande" ? "<tr><th>Commande</th><th>Quantite</th></tr>" : "<tr><th>Produit</th><th>Prix</th><th>Remise</th><th>Quantite</th><th>Total HT</th></tr>";
    $("#commande-table").find("tbody").empty();
    $("#commande-table").find("thead").empty().append(thead);
    $(".exportsection").show();
    $.ajax({
        url: "../../../controller/CommandeVenteProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "findByCommande", commande: _commande },
        success: function(result) {

            __COMPROLENGTH__ = result.data.length ;
            __DATA__ = result.data;
            //console.log(__DATA__);
            if (result.data.length > 0) {
                var t = "";
                const r = __ETAT__ == "Livrée" ? false : true;
                var editable = [];
                if(r)
                    editable = [
                        [1, 'prix'],
                        [2,'remise'],
                        [3, 'quantite']
                    ];
                var options = {
                    columns: {
                        identifier: [0, 'produit'],
                        editable: editable
                    },
                    onDraw: function() {
                        if(r) {
                            var quantiteMax = parseInt(getQuantiteMax($(this).parent().parent().find("td[data-produit]").eq(0).attr('data-produit')));
                            getFinalQuantiteMax($("input[name='quantite']"), quantiteMax);
                            $("input[name='prix']").prop("step", "0.1").prop("pattern", "^\d+(?:\.\d{1,2})?$").prop("type", "number").prop("min", 0);
                            // $("input[name='quantite']").prop("type", "number").prop("min", 1).on('input', function () {
                            //     var quantiteMax = parseInt(getQuantiteMax($(this).parent().parent().find("td[data-produit]").eq(0).attr('data-produit')));
                            //     getFinalQuantiteMax($(this), quantiteMax);
                            //
                            // })
                            $("input[name='quantite']").prop("type", "number").prop("min", 1);
                            $("input[name='remise']").prop("step", "0.1").prop("pattern", "^\d+(?:\.\d{1,2})?$").prop("type", "number").prop("min", 0).prop('max',getRemiseClient(cl)).on('input',function () {
                                $(this).removeClass('parsley-error-focus parsley-error');
                                $(".tabledit-save-button").prop("disabled",false);
                                if(!$(this)[0].checkValidity())
                                {
                                    $(this).attr("title","La remise doit être inférieur où égale : "+$(this).prop('max'));
                                    $(this).addClass('parsley-error-focus parsley-error');
                                    $(".tabledit-save-button").prop("disabled",true);
                                }
                            });
                            $(".tabledit-save-button").attr("onclick", "updateD(this)");
                            $(".tabledit-confirm-button").attr("onclick", "deleteD(this)");
                            $(".tabledit-edit-button").attr("onclick", "editButton(this)");
                            $(".tabledit-confirm-button").closest("td").addClass("buttons");
                        }
                    },
                    restoreButton: false
                };


                result.data.forEach(e => {
                    var prix = "<td>" + e.prix + "</td>";
                    var total_ht = "<td>" + (e.total_ht ? parseFloat(e.total_ht).toFixed(2) : "")  + "</td>";
                    var remise = "<td>" + e.remise + "</td>";
                    if(e.designation_vente)
                    t += "<tr><td data-commande='" + e.commande + "' data-produit='" + e.produit + "' >" + e.designation_vente + "</td>" + prix+ remise + "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                    else
                    t += "<tr><td data-commande='" + e.commande + "' data-produit='" + e.produit + "' >" + e.designation_achat + "</td>" + prix+ remise + "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                });

                $("#commande-table").find("tbody").empty().append(t);
                $('#commande-table').Tabledit(options);

                if(!r){
                    $("#commande-table").find("thead tr").find("th:last").remove();
                    $("#commande-table").find("tbody tr").find("td:last").remove();
                }

                if(__ETAT__!= "Livrée")
                    transfer_btn.show();

            }else
                $(".exportsection").hide();


        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
}

var editButton = function (e) {
    var button = $(e);
    var td = button.closest("tr").find("td");
    var produit_id = td.eq(0).attr("data-produit");
    var quantiteMax = parseInt(getQuantiteMax(produit_id));
    var quantiteInput = td.eq(3).find("input:eq(0)");
    $('input[name="remise"]').removeClass('parsley-error-focus parsley-error');
    getFinalQuantiteMax(quantiteInput,quantiteMax);
}

var updateD = function(e) {
    var button = $(e);
    var td = button.closest("tr").find("td");
    var produit_id = td.eq(0).attr("data-produit");
    var commande = td.eq(0).attr("data-commande");
    var prix = td.eq(1).find("input:eq(0)").val();
    var remise = td.eq(2).find("input:eq(0)").val();
    var quantite = td.eq(3).find("input:eq(0)").val();
    var quantiteMax = getFinalQuantiteMax(td.eq(3).find("input:eq(0)"),produit_id);

     $.ajax({
         url: "../../../controller/CommandeVenteProduitController.php",
         type: 'POST',
         async: false,
         data: { op: "update",commande: commande, produit: produit_id,remise:remise,prix: prix, quantite: quantite,quantiteMax: quantiteMax},
         success: function(result) {

             //console.log(result);
             alertify.success("Modifié avec succès");
             fillCommandeTable(commande);
             table.ajax.reload();
         },
         error: function(xhr, status, error) {
             console.log(xhr + " - " + status + " - " + error);
         }
     });

}

var deleteD = function(e) {
    var button = $(e);
    var td = button.closest("tr").find("td");
    var produit_id = td.eq(0).attr("data-produit");
    var commande = td.eq(0).attr("data-commande");

    $.ajax({
        url: "../../../controller/CommandeVenteProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "delete", commande: commande,produit:produit_id },
        success: function(result) {
            if (typeof result == "string" && result.includes("error"))
                alertify.error("Echec de supprimer");
            else
                alertify.success("Supprimé avec succès");
            fillCommandeTable(commande);
            table.ajax.reload();
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
}

var generatePDF = function (filename){
    __CURRENTCOMMANDE__ = __CURRENTCOMMANDEREF__.data()[0];
    var nCommande = __CURRENTCOMMANDE__.id || "";
    var devis = __CURRENTCOMMANDE__.devis || "";
    var nDate = __CURRENTCOMMANDE__.date || "";
    var nEntreprise = __CURRENTCOMMANDE__.nomE || "";
    var nEAdresse = __CURRENTCOMMANDE__.adresseE || "";
    var nEVille = __CURRENTCOMMANDE__.villeE || "";
    var nETele = __CURRENTCOMMANDE__.teleE || "";
    var nEFax = __CURRENTCOMMANDE__.faxE || "";
    var nECodeICE = __CURRENTCOMMANDE__.codeICE || "";
    var nFournisseur = __CURRENTCOMMANDE__.nomF || "";
    var nFAdresse = __CURRENTCOMMANDE__.adresseF || "";
    var nFVille = __CURRENTCOMMANDE__.villeF || "";
    var nFTele = __CURRENTCOMMANDE__.teleF || "";
    var nFFax = __CURRENTCOMMANDE__.faxF || "";
    var totalTTC = __CURRENTCOMMANDE__.total_ttc || 0;
    var tva = __CURRENTCOMMANDE__.tva || 0;
    var totalHT = __CURRENTCOMMANDE__.total_ht || 0;
    var image = "http://"+document.location.host+"/public/images/"+__CURRENTCOMMANDE__.image;
    var totalPagesExp = '{total_pages_count_string}';
    var length = 0;

    devis = devis == null ? "":devis;

    function convertImgToBase64(url, callback, outputFormat){
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
        var img = new Image;
        img.crossOrigin = 'Anonymous';
        img.onload = function(){
            canvas.height = img.height;
            canvas.width = img.width;
            imgwidth = img.width;
            ctx.drawImage(img,0,0);
            var dataURL = canvas.toDataURL(outputFormat || 'image/png');
            callback.call(this, dataURL);
            // Clean up
            canvas = null;
        };
        img.src = url;
    }

    convertImgToBase64(image, function(base64Img){
        image = base64Img;
    });

    var data=__DATA__;
    var columns = [
        {title: "Produit", dataKey: "produit"},
        {title: "Unité", dataKey: "unite"},
        {title: "Quantite", dataKey: "quantite"},
        {title: "Prix HT", dataKey: "prix"},
        {title: "Montant HT", dataKey: "total_ht"}
    ];

    var doc = new jsPDF('p', 'pt');
    doc.page = 1;
    var res = doc.autoTableHtmlToJson(document.getElementById("table"));

    //doc.autoTable(res.columns, res.data, {margin: {top: 80}});

    var centeredText = function(text, y) {
        var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
        doc.text(textOffset, y, text);
    }
    function chunkString(str, length) {
        return str.match(new RegExp('.{1,' + length + '}', 'g'));
    }

    var header = function(data) {
        //xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
        //onsole.log(doc.internal.pageSize.width)
        var h = 70;
        doc.setFontSize(18);
        doc.setTextColor(40);
        doc.setFontStyle('bold');
        //doc.addImage(headerImgData, 'JPEG', data.settings.margin.left, 20, 50, h);
        doc.addImage(image, 'JPEG', 50, 30, 80, 50);
        centeredText("Bon de commande".toUpperCase(),h);
        h += 20;
        doc.line(30, h, doc.internal.pageSize.width-30,h);
        h += 15;
        doc.setFontSize(12);
        doc.text("Commande N° : "+nCommande,30,h);
        doc.setFontSize(10);
        doc.setFontStyle('normal');
        doc.text("Devis N° : "+devis,34,h+10);
        doc.text("Le : "+nDate,doc.internal.pageSize.width-30,h-3,'right');
        h +=30;
        doc.setFontSize(13);
        doc.setFontStyle('bold');
        doc.text(nEntreprise.toUpperCase(),40,h);
        h += 14;
        doc.setFontSize(10);
        doc.setFontStyle('bold');
        doc.text("Client : ",doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+80,h,'right');
        doc.setFontSize(8);
        doc.setFontStyle('normal');
        var adresse = chunkString(nEAdresse.toUpperCase(),55);
        for (var i = 0 ; i< (adresse != null ? adresse.length : 0 ) ; i++){
            doc.text(adresse[i],40,h,'left');
            h+=10;
        }
        for (var i = 2 ; i< (adresse != null ? adresse.length : 0 ) ; i++){
            h-=10;
        }
        doc.text(nEVille.toUpperCase(),40,h,'left');
        h += 10;
        doc.text("CODE ICE : "+nECodeICE.toUpperCase(),40,h,'left');
        h += 10;
        doc.text("Tel : "+nETele.toUpperCase(),40,h,'left');
        h += 10;
        doc.text("Fax : "+nEFax.toUpperCase(),40,h,'left');
        h -= 20;
        doc.setFontSize(10);
        doc.setFontStyle('bold');
        doc.text(nFournisseur.toUpperCase(),doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+22,h,'left');
        doc.setFontSize(8);
        doc.setFontStyle('normal');
        h+=10;
        var adresse = chunkString(nFAdresse.toUpperCase(),42);
        length = adresse != null ? (adresse.length*5) : 0;
        doc.setDrawColor(90)
        doc.setFillColor(255, 255, 255)
        doc.roundedRect(doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+14, h-20, 248, 60+length, 3, 3, 'S')
        for (var i = 0 ; i< (adresse != null ? adresse.length : 0); i++){
            doc.text(adresse[i],doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+22,h+2,'left');
            h+=10;
        }
        doc.text(nFVille.toUpperCase(),doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+22,h,'left');
        h += 10;
        doc.text("Tel : "+nFTele.toUpperCase(),doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+22,h,'left');
        h += 10;
        doc.text("Fax : "+nFFax.toUpperCase(),doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+22,h,'left');


    };

    var footer = function(data){
        let height = doc.internal.pageSize.getHeight();
        /*doc.setFontSize(12);
        doc.setFontStyle('bold');
        centeredText("" + doc.page,height-20);
        doc.page+=1;*/
        doc.line(30, height-30, doc.internal.pageSize.width-30,height-30);
        doc.setFontSize(8);
        doc.setFontStyle('bold');
        //centeredText(nEAdresse.toUpperCase(),height-40);
        doc.text(nEAdresse.toUpperCase(),(doc.internal.pageSize.width/2),height-20,'center');
        doc.text("Tel : "+nETele+" - "+"Fax : "+nEFax,(doc.internal.pageSize.width/2),height-10,'center');
        //centeredText("Tel : "+nETele+" - "+"Fax : "+nEFax,height-30);

        var str = doc.internal.getNumberOfPages()
        // Total page number plugin only available in jspdf v1.0+
        if (typeof doc.putTotalPages === 'function') {
            str = str + '/' + totalPagesExp
        }
        doc.setFontSize(10)

        // jsPDF 1.4+ uses getWidth, <1.4 uses .width
        var pageSize = doc.internal.pageSize
        var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight()
        doc.text(str, data.settings.margin.left-10, pageHeight - 20)

    }


    var options = {
        beforePageContent: header,
        afterPageContent: footer,
        theme: 'plain',
        headerStyles: {
            textColor: [255,255,255],
            fillColor: [173, 173, 173]
        },
        bodyStyles: {
            lineColor: [173, 173, 173]
        },
        styles: {
            lineColor: [173, 173, 173],
            lineWidth: 1
        },
        margin: {
            top: 250
        }
        //startY: doc.autoTableEndPosY() + 20
    };

    doc.autoTable(columns, data, options);

    let finalY = doc.lastAutoTable.finalY; // The y position on the page
    /*doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-175, finalY+20, 135, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-170,finalY+34, 'Total TTC');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-168,finalY+56, totalTTC);*/
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-225, finalY+20, 56, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-220,finalY+34, 'Total HT');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-164,finalY+34, (totalHT ? parseFloat(totalHT).toFixed(2)  + " DH": ""));
    finalY += 22;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-225, finalY+20, 56, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-220,finalY+34, 'TVA');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-164,finalY+34, (tva ? parseFloat(tva).toFixed(2) + " DH": ""));
    finalY += 22;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-225, finalY+20, 56, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-220,finalY+34, 'Total TTC');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-164,finalY+34, (totalTTC ? parseFloat(totalTTC).toFixed(2) + " DH" : ""));

    doc.setProperties({
        title: filename,
        subject: 'Bon de commande',
        author: 'crm.toubkalit',
        keywords: '',
        creator: 'toubkalit'
    });

    if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp)
    }


    var iframe = document.getElementById('pdfHolder');
    iframe.src = doc.output('datauristring');


}



var getTotalPrix = function(){
    var prix = parseFloat(prix_input.val());
    var quantite = parseInt(quantite_input.val());
    var remise = parseFloat(remise_input.val());
    var r = prix-(prix*remise/100) || 0;
    var total = r*quantite;
    $("#totalprix").text(r.toFixed(2));
    $("#_totalprix").text(total.toFixed(2));
    return r;

}

var fillSelect = function() {
    var d = {};
    $.ajax({
        url: "../../../controller/ClientController.php",
        type: 'POST',
        async: false,
        data: d,
        success: function(result) {
            var t = "";
            for (var i = 0; i < result.data.length; i++) {
                var value = result.data[i].id;
                var text = result.data[i].prenom + ' ' + result.data[i].nom;
                if(result.data[i].type == "Société")
                    text = result.data[i].nom;
                t += "<option value='" + value + "'>" + text + "</option>";
            }
            client_select.selectize()[0].selectize.destroy();
            client_select.empty();
            client_select.append(t);
            client_select.selectize({
                sortField: 'text'
            });
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

var updateCommande = function(id) {
    $.ajax({
        url: "../../../controller/CommandeVenteController.php",
        type: 'POST',
        async: false,
        data: { op: "findById", id: id },
        success: function(result) {

            if (result.response == true) {
                client_select.selectize()[0].selectize.setValue(result.data.client);
                date_input.val(result.data.date);
                $("#client_select").val(result.data.client);
                $("#NumCommande").html(id);
                if(result.data.devis!="null")
                $("#NumDevis").html(result.data.devis);
                if($("#NumDevis").html()!="")
                {
                    $.ajax({
                        url: "../../../controller/DevisVenteController.php",
                        type: 'POST',
                        async: false,
                        data:{op:"findById",id:$("#NumDevis").html()},
                        success:function(datas){
                            $("#devis_date").val(datas.data.date);
                        },
                        error: function(xhr, status, error){
                            console.log(xhr + " - " + status + " - " + error);
                        }
                    });
                }
                else
                $("#devis_date").val("mm-dd-yyyy");
                $(".section1").hide();
                $(".section2").show();
                $('html, body').animate({
                    scrollTop: 0
                }, 1000);
                enregistrer_btn.attr("op", "M").attr("data-id", id);
                enregistrer_btn.find("span:eq(0)").text("Modifier");
            }

        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
}

var getLastPrice = function(commande,produit){
    $.ajax({
        url: "../../../controller/CommandeVenteController.php",
        type: 'POST',
        async: false,
        data: { op: "getLastPrice", produit: produit, commande:commande },
        success: function(result) {
            var dato = $.ajax({
                    url : "../../../controller/ProduitController.php",
                    type : "POST",
                    async : false,
                    data: {op : "findById",reference : produit}
                }).responseText;
            dato=JSON.parse(dato);
            var TempValuePrice = 0;
            TempValuePrice= (parseFloat(dato.data.tarif_ttc)).toFixed(2); 
            prix_input.val(result.data.prix == null ? TempValuePrice : result.data.prix);
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
    getTotalPrix();
}

var getRemiseClient = function(client){
    var remise_client = 0;
    $.ajax({
        url: "../../../controller/ClientController.php",
        type: 'POST',
        async: false,
        data: { op: "update", id: client},
        success: function(data) {
            remise_input.val( (data.web == "" || data.web == null)  ? 0 : data.web);
            remise_input.prop("max", (data.web == "" || data.web == null)  ? 0 : data.web);
            $("#remisemax_span").text((data.web == "" || data.web == null) ? 0 : data.web);
            remise_client = (data.web == "" || data.web == null) ? 0 : data.web;
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });

    //console.log(remise_client);
    return remise_client;
}


var deleteCommande = function(id) {
    alertify.confirm("Voulez vous vraiment supprimer cette commande?", function(asc) {
        if (asc) {
            $.ajax({
                url: "../../../controller/CommandeVenteController.php",
                type: 'POST',
                async: false,
                data: { op: "delete", id: id },
                success: function(result) {
                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec de supprimer la commande");
                    else
                        alertify.success("Commande supprimée avec succès");

                    table.ajax.reload();

                },
                error: function(xhr, status, error) {
                    alertify.error("Echec de supprimer la commande");
                    console.log(xhr + " - " + status + " - " + error);
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


/* -------------------------- ON DOCUMENT READY ------------------------------ */

$(document).ready(function(){
    table = $('#datatable-commandes').DataTable({
        'processing':true,
        'serverSide':true,
         "scrollX": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/CommandeVenteController.php",
            cache: false,
            data:{
                op : 'datatable'
            },
            type : 'POST'
        },
        "order": [],
        "aaSorting": [],
        "columns": [
            { "data": "etat" },
            { "data": "id" },
            { "data": "devis" },
            { "data": "date" },
            { "data": "nom" },
            {
                "data": "total_ht",
                "render": function (data) {
                        return data ? parseFloat(data).toFixed(2) : "";
                }
            },
            {
                "data": "tva",
                "render": function (data) {
                        return data ? parseFloat(data).toFixed(2) : "";
                }
            },
            {
                "data": "total_ttc",
                "render": function (data) {
                        return data ? parseFloat(data).toFixed(2) : "";
                }
            },
            {
                "data": null,
                "render": function(data) {
                    var d = "";
                    if(data.etat !=  "Livrée")
                        d = '<button onclick="updateCommande(' + data.id + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button>';

                    return '<button client="'+data.client+'"  data-id="' + data.id + '" data-etat="' + data.etat + '" data-toggle="modal" data-animation="bounce" data-target=".commande-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Details</button>'+d+'<button data="" onclick="deleteCommande(' + data.id + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
                }
            }
        ],
        /*'createdRow':function(row,_data,index){
            var data = {
                etat : _data[0],
                id : _data[1],
                client : _data[8]
            }
            var d = "";
            
            if(data.etat !=  "Livrée")
                d = '<button onclick="updateCommande(' + data.id + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button>';
                
            var cell =  '<button client="'+data.client+'"  data-id="' + data.id + '" data-etat="' + data.etat + '" data-toggle="modal" data-animation="bounce" data-target=".commande-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Details</button>'+d+'<button data="" onclick="deleteCommande(' + data.id + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
            $(row).find('td:last').html(cell);
        },*/
        "initComplete": function(settings, json) {
            if(getUrlParameter('id'))
                table.columns(1).search("\\b"+getUrlParameter('id')+"\\b",true,false).draw();
            /* Pour afficher le pop à partir du Devis */
                var show = findGetParameter("show");
                if(show !== null && show!=="")
                { 
                    $("button[data-target='.commande-modal'][data-id='"+show+"']").click();
                    
                }
            /* Fin */
          }
    });

    $('#datatable-commandes tbody').on( 'click', 'tr', function () {
        __CURRENTCOMMANDEREF__ = table.rows(table.row( this ).index());
        //console.log(__CURRENTCOMMANDE__);
    } );

    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });

    table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));

    fillSelect();
    
    
    
    $("#nouveau_btn").click(function() {$("#devis_date").val("mm-dd-yyyy");
        setTodayDateMax("date_input");
        enregistrer_btn.attr("op", "N");
        date_input.val("");
        var LastCommandeID = 0;
        $.ajax({
            url: "../../../controller/CommandeVenteController.php",
            type:"POST",
            data:{op:"lastID"},
            async:false,
            success: function(datas){
                datas.data.forEach(function(d){
                LastCommandeID = parseInt(d.Max);});
                $("#NumCommande").html(LastCommandeID + 1);
            },
            error: function(xhr, status, error){
                console.log(xhr + " - " + status + " - " + error);
            }
        });
        $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            data:{op:"findById",id:$("#client_select option:selected").val()},
            async:false,
            success: function(datas){
                var d=datas;
                var fullAddress = "";
                if(d.adresse != null && d.adresse != "" && d.adresse != "null")
                    fullAddress += d.adresse + ", ";
                if(d.ville != null && d.ville != "" && d.ville != "null")
                    fullAddress += d.ville + ", ";
                if(d.pays != null && d.pays != "" && d.pays != "null")
                    fullAddress += d.pays;
                $("#address_client").html(fullAddress);
                var remise = (d.web == "" || d.web == null)  ?0:d.web;
                $("#remise_input1").html(remise);
                $("#mode_input").val(d.mode);
                mode=d.mode;
                var ClassNameCheck="";var labelCheck="";var color="";
                if(parseFloat(d.plafondEmpye)<parseFloat(d.plafond))
                    {classNameCheck= "mdi mdi-checkbox-marked-circle-outline";labelCheck="Validé";color="green";}
                else
                    {classNameCheck= "mdi mdi-close-circle-outline";labelCheck="Invalidé";color="red";}
                $("#checkStatus").html("<span id=\"checkStatusBadge\" style=\"margin-right:5px;\"></span>");
                $("#checkStatusBadge").addClass(classNameCheck);
                $("#checkStatusBadge").css("color",color);
                $("#checkStatus").append(labelCheck);
            },
            error: function(xhr, status, error){
                console.log(xhr + " - " + status + " - " + error);
            }
        });
        $("#client_select").change(function(){
            $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            data:{op:"findById",id:$("#client_select option:selected").val()},
            async:false,
            success: function(datas){
                var d=datas;
                var fullAddress = "";
                if(d.adresse != null && d.adresse != "" && d.adresse != "null")
                    fullAddress += d.adresse + ", ";
                if(d.ville != null && d.ville != "" && d.ville != "null")
                    fullAddress += d.ville + ", ";
                if(d.pays != null && d.pays != "" && d.pays != "null")
                    fullAddress += d.pays;
                $("#address_client").html(fullAddress);
                var remise = (d.web == "" || d.web == null)?0:d.web;
                $("#remise_input1").html(remise);
                $("#mode_input").val(d.mode);
                mode=d.mode;
                var ClassNameCheck="";var labelCheck="";var color="";
                if(parseFloat(d.plafondEmpye)<parseFloat(d.plafond))
                    {classNameCheck= "mdi mdi-checkbox-marked-circle-outline";labelCheck="Validé";color="green";}
                else
                    {classNameCheck= "mdi mdi-close-circle-outline";labelCheck="Invalidé";color="red";}
                $("#checkStatus").html("<span id=\"checkStatusBadge\" style=\"margin-right:5px;\"></span>");
                $("#checkStatusBadge").addClass(classNameCheck);
                $("#checkStatusBadge").css("color",color);
                $("#checkStatus").append(labelCheck);
            },
            error: function(xhr, status, error){
                console.log(xhr + " - " + status + " - " + error);
            }
            });
        });
    });
    $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            data:{op:"findById",id:$("#client_select option:selected").val()},
            async:false,
            success: function(datas){
                var d=datas;
                var fullAddress = "";
                if(d.adresse != null && d.adresse != "" && d.adresse != "null")
                    fullAddress += d.adresse + ", ";
                if(d.ville != null && d.ville != "" && d.ville != "null")
                    fullAddress += d.ville + ", ";
                if(d.pays != null && d.pays != "" && d.pays != "null")
                    fullAddress += d.pays;
                $("#address_client").html(fullAddress);
                var remise = (d.web == "" || d.web == null)?0:d.web;
                $("#remise_input1").html(remise);
                $("#mode_input").val(d.mode);
                mode=d.mode;
                var ClassNameCheck="";var labelCheck="";var color="";
                if(parseFloat(d.plafondEmpye)<parseFloat(d.plafond))
                    {classNameCheck= "mdi mdi-checkbox-marked-circle-outline";labelCheck="Validé";color="green";}
                else
                    {classNameCheck= "mdi mdi-close-circle-outline";labelCheck="Invalidé";color="red";}
                $("#checkStatus").html("<span id=\"checkStatusBadge\" style=\"margin-right:5px;\"></span>");
                $("#checkStatusBadge").addClass(classNameCheck);
                $("#checkStatusBadge").css("color",color);
                $("#checkStatus").append(labelCheck);
            },
            error: function(xhr, status, error){
                console.log(xhr + " - " + status + " - " + error);
            }
        });
        $("#client_select").change(function(){
            $.ajax({
            url: "../../../controller/ClientController.php",
            type:"POST",
            data:{op:"findById",id:$("#client_select option:selected").val()},
            async:false,
            success: function(datas){
                var d=datas;
                var fullAddress = "";
                if(d.adresse != null && d.adresse != "" && d.adresse != "null")
                    fullAddress += d.adresse + ", ";
                if(d.ville != null && d.ville != "" && d.ville != "null")
                    fullAddress += d.ville + ", ";
                if(d.pays != null && d.pays != "" && d.pays != "null")
                    fullAddress += d.pays;
                $("#address_client").html(fullAddress);
                var remise = (d.web == "" || d.web == null)?0:d.web;
                $("#remise_input1").html(remise);
                $("#mode_input").val(d.mode);
                mode=d.mode;
                var ClassNameCheck="";var labelCheck="";var color="";
                if(parseFloat(d.plafondEmpye)<parseFloat(d.plafond))
                    {classNameCheck= "mdi mdi-checkbox-marked-circle-outline";labelCheck="Validé";color="green";}
                else
                    {classNameCheck= "mdi mdi-close-circle-outline";labelCheck="Invalidé";color="red";}
                $("#checkStatus").html("<span id=\"checkStatusBadge\" style=\"margin-right:5px;\"></span>");
                $("#checkStatusBadge").addClass(classNameCheck);
                $("#checkStatusBadge").css("color",color);
                $("#checkStatus").append(labelCheck);
            },
            error: function(xhr, status, error){
                console.log(xhr + " - " + status + " - " + error);
            }
            });
        });
    produit_select.change(function () {
        var qmax = getQuantiteMax(produit_select.val());
        quantite_input.val(qmax);
        getLastPrice(transfer_btn.attr("data-id"),produit_select.val());
        $("#quantitemax_span").text("Max : " + qmax);
        // quantite_input.prop("max",qmax);
        getRemiseClient(cl);
        getTotalPrix();
    });

    enregistrer_btn.click(function() {

        if (client_select.val() != null && client_select.val() != "" && date_input.val() != "") {
            var data = { client: client_select.val(), date: date_input.val()};
            var modeData={client: client_select.val(),mode:$("#mode_input").val(),op:"UpdateMode"};
            if ($(this).attr("op") == "N") {
                data.op = "add";
            } else if ($(this).attr("op") == "M") {
                data.op = "update";
                data.id = $(this).attr("data-id");
            }

            $.ajax({
                url: "../../../controller/CommandeVenteController.php",
                type: 'POST',
                async: false,
                data: data,
                success: function(result) {
                    m = data.op == "add" ? "ajoutée" : "modifiée";
                    var lastIDInserted = 0;
                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec de " + m + " la commande");
                    else {
                        r = result.data;
                        alertify.success("Commande " + m + " avec succès");
                        var last= $.ajax({url: "../../../controller/CommandeVenteController.php",async:false,type:"POST",data:{op:"lastID"}}).responseText;
                        last=JSON.parse(last);
                        last.data.forEach(function(d){lastIDInserted=d.Max;});
                    }
                    table.ajax.reload();
                    setTimeout(function(){$("button[data-target='.commande-modal'][data-id='"+lastIDInserted+"']").click();
                    },1000);
                    if(data.op=="add")
                    {
                        var LastCommandeID = 0;
                        $.ajax({
                            url: "../../../controller/CommandeVenteController.php",
                            type:"POST",
                            data:{op:"lastID"},
                            async:false,
                            success: function(datas){
                                datas.data.forEach(function(d){
                                LastCommandeID = parseInt(d.Max);});
                                $("#NumCommande").html(LastCommandeID + 1);
                            },
                            error: function(xhr, status, error){
                                console.log(xhr + " - " + status + " - " + error);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    m = data.op == "add" ? "d'ajouter" : "de modifier";
                    alertify.error("Echec " + m + " la commande");
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
            if(mode!=$("#mode_input").val()){
                $.ajax({
                    url: "../../../controller/ClientController.php",
                    type: 'POST',
                    async: false,
                    data: modeData,
                    success: function(result) {
                    alertify.success("Mode de réglement a éte modifié pour le client " + client_select.html());
                    },
                    error: function(xhr, status, error) {
                    alertify.error("Mode de réglement n'a pas éte modifié pour le client " + client_select.html());
                    }
                });
            }
                $.ajax({
                    url: "../../../controller/ClientController.php",
                    type:"POST",
                    data:{op:"findById",id:$("#client_select option:selected").val()},
                    async:false,
                    success: function(datas){
                        var d=datas;
                        var fullAddress = "";
                        if(d.adresse != null && d.adresse != "" && d.adresse != "null")
                            fullAddress += d.adresse + ", ";
                        if(d.ville != null && d.ville != "" && d.ville != "null")
                            fullAddress += d.ville + ", ";
                        if(d.pays != null && d.pays != "" && d.pays != "null")
                            fullAddress += d.pays;
                        $("#address_client").html(fullAddress);
                        var remise = (d.web == "" || d.web == null)  ?0:d.web;
                        $("#remise_input1").html(remise);
                        $("#mode_input").val(d.mode);
                        mode=d.mode;
                        var ClassNameCheck="";var labelCheck="";var color="";
                        if(parseFloat(d.plafondEmpye)<parseFloat(d.plafond))
                            {classNameCheck= "mdi mdi-checkbox-marked-circle-outline";labelCheck="Validé";color="green";}
                        else
                            {classNameCheck= "mdi mdi-close-circle-outline";labelCheck="Invalidé";color="red";}
                        $("#checkStatus").html("<span id=\"checkStatusBadge\" style=\"margin-right:5px;\"></span>");
                        $("#checkStatusBadge").addClass(classNameCheck);
                        $("#checkStatusBadge").css("color",color);
                        $("#checkStatus").append(labelCheck);
                    },
                    error: function(xhr, status, error){
                        console.log(xhr + " - " + status + " - " + error);
                    }
                });
        }
        else 
             alertify.error("Veuillez remplir tous les champs");

    });

    $('.commande-modal').on('show.bs.modal', function(event) {
        $(".addsection").show();
        var button = $(event.relatedTarget);
        var _id = button.attr("data-id");
        var etat = button.attr("data-etat");
        ajouter_btn.attr("data-commande", _id);
        cl = button.attr("client");
        var date = button.closest("tr").find("td:eq(3)").text();
        var nom = button.closest("tr").find("td:eq(4)").text();
        __ETAT__ = etat;
        if(etat == "Livrée")
            $(".addsection").hide();
        transfer_btn.attr("data-date",date);
        //transfer_btn.attr("vers",etat == "Demande de prix" ? "devis":"commande").attr("data-id",_id);
        //transfer_btn.find("span:eq(0)").text(etat == "Demande de prix" ? "Transfert vers devis":"Transfert vers commande");
        transfer_btn.attr("data-id",_id);
        $(".date_modal").html("<span class='badge badge-primary'>" + etat +  " - "+ _id +"</span> " + date);
        $(".client_modal").text(" - " + nom);
        
        $("#prix_input , #remise_input , #quantite_input").val(0);
        $(".quantitemax_span").text(0);

        //getAllProducts(_id);

        fillCommandeTable(_id);

        //getRemiseClient(cl);

        getTotalPrix();
        
        $.ajax({
                url : "../../../controller/ClientController.php",
                type:"POST",
                data:{op:"findById",id:cl},
                async:false,
                success:function(datas){
                    var d=datas;
                    if(parseFloat(d.plafond)>(parseFloat(d.plafondEmpye)))
                        {var classNameCheck= "mdi mdi-checkbox-marked-circle-outline";var labelCheck="<span id=\"flagCheck\">Validé</span>";var color="green";}
                    else
                        {var classNameCheck= "mdi mdi-close-circle-outline";var labelCheck="<span id=\"flagCheck\">Invalidé</span>";var color="red";}
                    $("#checkStatus1").html("<span id=\"checkStatusBadge1\" style=\"margin-right:5px;\"></span>");
                    $("#checkStatusBadge1").addClass(classNameCheck);
                    $("#checkStatusBadge1").css("color",color);
                    $("#checkStatus1").append(labelCheck);
                },
                 error: function(xhr, status, error) {
                    console.log(xhr + " - " + status + " - " + error);
                }
            });

        $("#prix_input , #remise_input, #quantite_input").change(function () {
            getTotalPrix();
        });


    });


    ajouter_btn.click(function() {
        var commande = $(this).attr("data-commande");
        if (produit_select.val() == null || produit_select.val() == "")
            alertify.alert("Vous devez chiosir un produit.");
        else if (quantite_input.val() == "0")
            alertify.alert("Vous devez ajouter la quantité de produit.");
        else {
            $.ajax({
                url: "../../../controller/CommandeVenteProduitController.php",
                type: 'POST',
                async: false,
                data: { op: "add", commande: commande,remise:remise_input.val(), produit: produit_select.val(), prix: prix_input.val(), quantite: quantite_input.val() },
                success: function(result) {

                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec d'ajouté la commande");
                    else
                        alertify.success("Ajouté avec succès");
                    fillCommandeTable(commande);
                    table.ajax.reload();

                },
                error: function(xhr, status, error) {
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
        }
    });

    transfer_btn.focus(function () {
        transfer_btn.one("click",function () {
            if(__COMPROLENGTH__ != 0)
            {
                if($("#flagCheck").html()=="Validé"){
                var commande = $(this).attr("data-id");
                $.ajax({
                    url: "../../../controller/CommandeVenteController.php",
                    type: 'POST',
                    async: false,
                    data: { op: "CommandeToBon", commande: commande},
                    success: function(result) {

                        if (result.data == '-1')
                            alertify.error("Echec de livrer cette commande");
                        else
                        {
                            alertify.success("Commande Livrée avec succès");
                            $(".addsection").hide();
                            __ETAT__ = "Livrée";
                            $(".date_modal").html("<span class='badge badge-primary'>LIVRÉE</span> " + transfer_btn.attr("data-date"));
                            fillCommandeTable(commande);
                            table.ajax.reload();
                            var MaxId;
                            var datas=$.ajax({url:"../../../controller/BonVenteController.php",type:"POST",async:false,data:{op:"lastID"}}).responseText;
                            datas=JSON.parse(datas);
                            datas.data.forEach(function(d){MaxId=d.Max;});
                            setTimeout(window.location.href="bons.php?show="+MaxId,1500);

                        }},
                    error: function(xhr, status, error) {
                        console.log(xhr + " - " + status + " - " + error);
                        alertify.error("Echec de livrer cette commande");

                    }
                });
                __TRANSFER_BTN_CLICKED__ = 1;}
                else
                    alertify.alert("Le client a dépassé le plafond.");
            }
        })
    })

    $(".btn-excel").click(function() {
        $("#commande-table").tableHTMLExport({ type: 'csv', filename: 'Commande - ' + $(".date_modal").text().replace("|", "") + $(".client_modal").text() + '.csv', ignoreColumns: '.buttons,.tabledit-toolbar-column' });
    });

    $(".btn-pdf").click(function() {
        //$("#commande-table").tableHTMLExport({ type: 'pdf', filename: 'Commande - ' + $(".date_modal").text().replace("|", "") + $(".client_modal").text() + '.pdf', ignoreColumns: '.buttons,.tabledit-toolbar-column' });

        generatePDF('Bon de commande');
    });

    $('.pdf-modal').on('hidden.bs.modal', function (e) {
        var iframe = document.getElementById('pdfHolder');
        iframe.src = "";
    })

});