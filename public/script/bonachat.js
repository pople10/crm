/* ------------------------  VARIABLES ---------------------------- */

var enregistrer_btn = $("#enregistrer_btn");
var fournisseur_select = $("#fournisseur_select");
var date_input = $("#date_input");
var ajouter_btn = $("#ajouter_btn");
var produit_select = $("#produit_select");
var prix_input = $("#prix_input");
var quantite_input = $("#quantite_input");
var transfer_btn = $("#transferer_btn");
var __DATA__ = [];
var __CURRENTBON__ = {};
var __CURRENTBONREF__ = {};

/* ------------------------- FUNCTIONS ----------------------------- */

var generatePDF = function (filename){
    __CURRENTBON__ = __CURRENTBONREF__.data()[0];
    var nBon = __CURRENTBON__.id || "";
    var commande = __CURRENTBON__.commande || "";
    var nDate = __CURRENTBON__.date || "";
    var nEntreprise = __CURRENTBON__.nomE || "";
    var nEAdresse = __CURRENTBON__.adresseE || "";
    var nEVille = __CURRENTBON__.villeE || "";
    var nETele = __CURRENTBON__.teleE || "";
    var nEFax = __CURRENTBON__.faxE || "";
    var nECodeICE = __CURRENTBON__.codeICE || "";
    var nFournisseur = __CURRENTBON__.nomF || "";
    var nFAdresse = __CURRENTBON__.adresseF || "";
    var nFVille = __CURRENTBON__.villeF || "";
    var nFTele = __CURRENTBON__.teleF || "";
    var nFFax = __CURRENTBON__.faxF || "";
    var totalTTC = __CURRENTBON__.total_ttc || 0;
    var tva = __CURRENTBON__.tva || 0;
    var totalHT = __CURRENTBON__.total_ht || 0;
    var image = "http://"+document.location.host+"/public/images/"+__CURRENTBON__.image;
    var totalPagesExp = '{total_pages_count_string}';
    var length = 0;

     
    function convertImgToBase64(url, callback, outputFormat){
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
        var img = new Image;
        img.crossOrigin = 'Anonymous';
        img.onload = function(){
            canvas.height = img.height;
            canvas.width = img.width;
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
        {title: "Prix", dataKey: "prix"},
        {title: "Quantite", dataKey: "quantite"},
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
        centeredText(filename.toUpperCase(),h);
        h += 20;
        doc.line(30, h, doc.internal.pageSize.width-30,h);
        h += 15;
        doc.setFontSize(12);
        doc.text("Réception N° : "+nBon,30,h);
        doc.setFontSize(10);
        doc.setFontStyle('normal');
        doc.text(commande != "" ? "Commande N° : "+commande : "",34,h+10);
        doc.text("Le : "+nDate,doc.internal.pageSize.width-30,h-3,'right');
        h +=30;
        doc.setFontSize(13);
        doc.setFontStyle('bold');
        doc.text(nEntreprise.toUpperCase(),40,h);
        h += 14;
        doc.setFontSize(10);
        doc.setFontStyle('bold');
        doc.text("Fournisseur : ",doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+80,h,'right');
        doc.setFontSize(8);
        doc.setFontStyle('normal');
        var adresse = chunkString(nEAdresse.toUpperCase(),55);
        for (var i = 0 ; i< adresse.length ; i++){
            doc.text(adresse[i],40,h,'left');
            h+=10;
        }
        for (var i = 2 ; i< adresse.length ; i++){
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
        length = (adresse.length*5);
        doc.setDrawColor(90)
        doc.setFillColor(255, 255, 255)
        doc.roundedRect(doc.internal.pageSize.width-(doc.internal.pageSize.width/2)+14, h-20, 248, 60+length, 3, 3, 'S')
        for (var i = 0 ; i< adresse.length ; i++){
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
    doc.text(doc.internal.pageSize.width-164,finalY+34, (tva ? parseFloat(tva).toFixed(2)  + " DH": ""));
    finalY += 22;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-225, finalY+20, 56, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-220,finalY+34, 'Total TTC');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-164,finalY+34, (totalTTC ? parseFloat(totalTTC).toFixed(2)  + " DH": ""));

    doc.setProperties({
        title: filename,
        subject: 'Bon de réception',
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
                r = parseInt(result.data.quantite_max_c);
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
    return r;
}

var getAllProducts = function(bon) {
    var d = "";
    /*$.ajax({
        url: "../../../controller/ProduitController.php",
        type: 'POST',
        async: false,
        data: { op:"findAllByBon",bon : bon},
        success: function(result) {
            console.log(result);
            result.data.forEach((e, i) => {
                if(e.designation_achat)
                d += '<option value="' + e.reference + '" >' + e.designation_achat + '</option>';
                else
                d += '<option value="' + e.reference + '" >' + e.designation_vente + '</option>';
            });
            produit_select.selectize()[0].selectize.destroy();
            produit_select.empty().append(d);


        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
    getLastPrice(bon,produit_select.val());
    produit_select.selectize({
        sortField: 'text'
    });
    var qmax = getQuantiteMax(produit_select.val());
    quantite_input.val(qmax);
    $("#quantitemax_span").text("Max : " + qmax);
    quantite_input.prop("max",qmax);*/
    
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
                        op:"findAllByBon",
                        bon : bon,
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

var getFinalQuantiteMax = function (e,quantiteMax) {
    var currentQuantite = parseInt(e.parent().find(".tabledit-span").eq(0).text());
    var sumMax = quantiteMax+currentQuantite;
    var thisVal = parseInt(e.val())
    var final = thisVal-currentQuantite;
    e.prop("max",sumMax);
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

var fillBonTable = function(_bon) {
    getAllProducts(_bon);
    transfer_btn.hide();
    var thead = ajouter_btn.attr("data-type") == "demande" ? "<tr><th>Bon</th><th>Quantite</th></tr>" : "<tr><th>Produit</th><th>Prix</th><th>Quantite</th><th>Total HT</th></tr>";
    $("#bon-table").find("tbody").empty();
    $("#bon-table").find("thead").empty().append(thead);
    $(".exportsection").show();
    $.ajax({
        url: "../../../controller/BonAchatProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "findByBon", bon: _bon },
        success: function(result) {

            //console.log(result.data.length);
            __DATA__ = result.data;

            if (result.data.length > 0) {
                var t = "";

                result.data.forEach(e => {
                    var prix = "<td>" + e.prix + "</td>";
                    var total_ht = "<td>" + e.total_ht + "</td>";
                    if(e.designation_achat)
                    t += "<tr><td data-bon='" + e.bon + "' data-produit='" + e.produit + "' >" + e.designation_achat + "</td>" + prix + "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                    else
                    t += "<tr><td data-bon='" + e.bon + "' data-produit='" + e.produit + "' >" + e.designation_vente + "</td>" + prix + "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                });

                $("#bon-table").find("thead").empty().append(thead);
                $("#bon-table").find("tbody").empty().append(t);

                $('#bon-table').Tabledit({
                    columns: {
                        identifier: [0, 'produit'],
                        editable: [
                            [1, 'prix'],
                            [2, 'quantite']
                        ]
                    },
                    onDraw: function() {
                        var quantiteMax = parseInt(getQuantiteMax($(this).parent().parent().find("td[data-produit]").eq(0).attr('data-produit')));
                        getFinalQuantiteMax($("input[name='quantite']"),quantiteMax);
                        $("input[name='prix']").prop("step", "0.1").prop("pattern", "^\d+(?:\.\d{1,2})?$").prop("type", "number").prop("min",0);
                        $("input[name='quantite']").prop("type", "number").prop("min",1).on('input',function () {
                            var quantiteMax = parseInt(getQuantiteMax($(this).parent().parent().find("td[data-produit]").eq(0).attr('data-produit')));
                            getFinalQuantiteMax($(this),quantiteMax);

                        });
                        $(".tabledit-save-button").attr("onclick", "updateD(this)");
                        $(".tabledit-confirm-button").attr("onclick", "deleteD(this)");
                        $(".tabledit-edit-button").attr("onclick", "editButton(this)");
                        $(".tabledit-confirm-button").closest("td").addClass("buttons");
                    },
                    restoreButton: false
                });
                //transfer_btn.show();
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
    var quantiteInput = td.eq(2).find("input:eq(0)");
    getFinalQuantiteMax(quantiteInput,quantiteMax);
}

var updateD = function(e) {
    var button = $(e);
    var td = button.closest("tr").find("td");
    var produit_id = td.eq(0).attr("data-produit");
    var bon = td.eq(0).attr("data-bon");
    var prix = td.eq(1).find("input:eq(0)").val();
    var quantite = td.eq(2).find("input:eq(0)").val();
    var quantiteMax = getFinalQuantiteMax(td.eq(2).find("input:eq(0)"),produit_id);



    $.ajax({
        url: "../../../controller/BonAchatProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "update",bon: bon, produit: produit_id, prix: prix, quantite: quantite,quantiteMax: quantiteMax },
        success: function(result) {

            //console.log(result);
            alertify.success("Modifié avec succès");
            fillBonTable(bon);
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
    var bon = td.eq(0).attr("data-bon");

    $.ajax({
        url: "../../../controller/BonAchatProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "delete", bon: bon,produit:produit_id },
        success: function(result) {
            if (typeof result == "string" && result.includes("error"))
                alertify.error("Echec de supprimer");
            else
                alertify.success("Supprimé avec succès");
            fillBonTable(bon);
            table.ajax.reload();
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
}


var fillSelect = function() {
    var d = {};
    $.ajax({
        url: "../../../controller/FournisseurController.php",
        type: 'POST',
        async: false,
        data: d,
        success: function(result) {
            var t = "";
            //console.log(result.data);
            for (var i = 0; i < result.data.length; i++) {
                var value = result.data[i].id;
                var text = result.data[i].prenom + ' ' + result.data[i].nom;
                if(result.data[i].type == "Société")
                    text = result.data[i].nom;
                t += "<option value='" + value + "'>" + text + "</option>";
            }
            fournisseur_select.empty();
            fournisseur_select.append(t);
            fournisseur_select.selectize({
                sortField: 'text'
            });
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });

}

var updateBon = function(id) {
    $.ajax({
        url: "../../../controller/BonAchatController.php",
        type: 'POST',
        async: false,
        data: { op: "findById", id: id },
        success: function(result) {

            if (result.response == true) {
                console.log(result.data);
                fournisseur_select.selectize()[0].selectize.setValue(result.data.fournisseur);
                date_input.val(result.data.date);

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

var deleteBon = function(id) {
    alertify.confirm("Voulez vous vraiment supprimer ce bon?", function(asc) {
        if (asc) {
            $.ajax({
                url: "../../../controller/BonAchatController.php",
                type: 'POST',
                async: false,
                data: { op: "delete", id: id },
                success: function(result) {
                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec de supprimer le bon");
                    else
                        alertify.success("Bon supprimé avec succès");

                    table.ajax.reload();

                },
                error: function(xhr, status, error) {
                    alertify.error("Echec de supprimer le bon");
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

var getLastPrice = function(bon,produit){
    $.ajax({
        url: "../../../controller/BonAchatController.php",
        type: 'POST',
        async: false,
        data: { op: "getLastPrice", produit: produit, bon:bon },
        success: function(result) {
            //prix_input.val(result.data == false ? 0 : result.data.prix);
            var prix = result.data.prix== null ? 0 + " DH" : result.data.prix + " DH";
            $("#lastPrice").text(prix);
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
}


/* -------------------------- ON DOCUMENT READY ------------------------------ */

$(document).ready(function(){
    table = $('#datatable-bon').DataTable({
         "scrollX": true,
        "processing": true,
        "serverSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/BonAchatController.php",
            type : 'POST',
            data : {op:'datatable'}
        },
        "order": [],
        "aaSorting": [],
        "columns": [
            { "data": "etat" },
            { "data": "id" },
            { "data": "commande" },
            { "data": "date" },
            { "data": "nom" },
            {
                "data": "total_ht",
                "render":function(data){
                    return data ? parseFloat(data).toFixed(2) : "";
                }
            },
            {
                "data": "tva",
                "render":function(data){
                    return data ? parseFloat(data).toFixed(2) : "";
                }
            },
            {
                "data": "total_ttc",
                "render":function(data){
                    return data ? parseFloat(data).toFixed(2) : "";
                }
            },
            {
                "data": null,
                "render": function(data) {
                    return '<button data-id="' + data.id + '" data-etat="' + data.etat + '" data-toggle="modal" data-animation="bounce" data-target=".bon-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Détails</button><button  data-id="' + data.id + '" supplier="'+data.fournisseur+'"  type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-animation="bounce" data-target=".retour-modal" style="float: none; margin: 5px;">Retour</button><button onclick="updateBon(' + data.id + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button data="" onclick="deleteBon(' + data.id + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
                }
            }

        ],/*
        "createdRow": function ( row, _data, index ) {
            var data = {id:_data[1],etat:_data[0]};
            var cell = '<button data-id="' + data.id + '" data-etat="' + data.etat + '" data-toggle="modal" data-animation="bounce" data-target=".bon-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Détails</button><button onclick="updateBon(' + data.id + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button data="" onclick="deleteBon(' + data.id + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
            $(row).find('td:last').html(cell);
        },*/
        "initComplete": function(settings, json) {
            if(getUrlParameter('id'))
                table.columns(1).search("\\b"+getUrlParameter('id')+"\\b",true,false).draw();
            /* Pour afficher le pop à partir du Commande */
                var show = findGetParameter("show");
                if(show !== null && show!=="")
                { 
                    $("button[data-target='.bon-modal'][data-id='"+show+"']").click();
                    
                }
            /* Fin */
          }
    });

    $('#datatable-bon tbody').on( 'click', 'tr', function () {
        __CURRENTBONREF__ = table.rows(table.row( this ).index());
        //console.log(__CURRENTBON__);
    } );

    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });

    table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));

    fillSelect();

    $(".nouveau_btn").click(function() {
        var index = parseInt($(".nouveau_btn").index(this));
        setTodayDateMax("date_input");
        enregistrer_btn.attr("t", index);
        enregistrer_btn.attr("op", "N");

    })

    produit_select.change(function () {
        getLastPrice(transfer_btn.attr("data-id"),produit_select.val());
        var qmax = getQuantiteMax(produit_select.val());
        quantite_input.val(qmax);
        $("#quantitemax_span").text("Max : " + qmax);
        quantite_input.prop("max",qmax);
    });

    enregistrer_btn.click(function() {

        if (fournisseur_select.val() != null && fournisseur_select.val() != "" && date_input.val() != "") {
            var t = $(this).attr("t") == 0 ? "Non Facturé" : "Bon de retour";
            var data = { fournisseur: fournisseur_select.val(), date: date_input.val(),etat:t};

            if ($(this).attr("op") == "N") {
                data.op = "add";
            } else if ($(this).attr("op") == "M") {
                data.op = "update";
                data.id = $(this).attr("data-id");
            }

            $.ajax({
                url: "../../../controller/BonAchatController.php",
                type: 'POST',
                async: false,
                data: data,
                success: function(result) {
                    m = data.op == "add" ? "ajouté" : "modifié";
                    var lastIDInserted = 0;
                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec de " + m + " le bon");
                    else {
                        r = result.data;
                        alertify.success("Bon " + m + " avec succès");
                        var last= $.ajax({url: "../../../controller/BonAchatController.php",async:false,type:"POST",data:{op:"lastID"}}).responseText;
                        last=JSON.parse(last);
                        lastIDInserted=last.data.Max;
                    }
                    table.ajax.reload();
                    setTimeout(function(){$("button[data-target='.bon-modal'][data-id='"+lastIDInserted+"']").click();
                    },1000);
                },
                error: function(xhr, status, error) {
                    m = data.op == "add" ? "d'ajouter" : "de modifier";
                    alertify.error("Echec " + m + " le bon");
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
        }

    });

    $('.bon-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var _id = button.attr("data-id");
        $('#produitModalBtn').attr('data-id',_id);
        var etat = button.attr("data-etat");
        ajouter_btn.attr("data-bon", _id);
        var date = button.closest("tr").find("td:eq(2)").text();
        var nom = button.closest("tr").find("td:eq(4)").text();

        transfer_btn.attr("data-id",_id);
        //transfer_btn.find("span:eq(0)").text(etat == "Demande de prix" ? "Transfert vers devis":"Transfert vers commande");

        $(".date_modal").html("<span class='badge badge-primary'>" + etat + " - "+ _id +"</span> " + date);
        $(".fournisseur_modal").text(" - " + nom);

        //getAllProducts(_id);

        fillBonTable(_id);

    });

    $('.retour-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var fr = button.attr("supplier");
        var _id = button.attr("data-id");
        ajouter_btn.attr("data-bon", _id);
        var date = button.closest("tr").find("td:eq(3)").text();
        var nom = button.closest("tr").find("td:eq(4)").text();
        $(".date_modal").html(date);
        $(".supplier_modal").text(" - " + nom);
        $('#retour-table tbody').html("");
        $('.retour-modal .modal-footer').html("");
        $.ajax({
            url: "../../../controller/BonAchatProduitController.php",
            type: 'POST',
            async: false,
            data: { op: "findByBon", bon: _id },
            success: function(result) {
                result.data.forEach(function(v,i){
                    $("#retour-table tbody").append("<tr>" +
                        "<th data-id='"+v.produit+"'>"+(v.designation_achat?v.designation_achat:v.designation_vente)+"</th>" + "<td data-prix='"+v.prix+"'>"+v.prix+"</td>" +
                        "<td><div class='d-flex'><input type='number' min='1' max='"+v.quantite+"' value='"+v.quantite+"' class='w-100 form-control h-auto' style='margin-right: -5px' onchange=\"this.value = this.checkValidity()? this.value : this.attributes['max'].value\"><div class='input-group-addon' style='display: grid;'><small>Max</small><small>"+v.quantite+"</small></div></div></td>" +
                        "<td><button class='delete-line btn btn-sm btn-danger'><span class='ti-trash'></span></button></td></tr>");
                });
                if(result.data.length != 0)
                    $('.retour-modal .modal-footer').append('<div class="form-group m-0">\n' +
                        '                    <button id="retour_btn" class="btn btn-primary btn-sm ml-2 mr-2 float-right" role="button"><i class="mdi mdi-content-save"></i>\n' +
                        '                        Ajouter</button>\n' +
                        '                </div>');
            },
            error: function(xhr, status, error) {
                console.log(xhr + " - " + status + " - " + error);
            }
        });
        $('.retour-modal .delete-line').click(function(){
            $(this).closest('tr').remove();
        });
        $('#retour_btn').focus(function(){
            $('#retour_btn').one("click",function(){
                let data = {fournisseur : fr , data: [],bon:_id} ;
                $('#retour-table tbody tr').each(function(v,i){
                    let line = {};
                    line.produit = $(this).find('th').attr('data-id');
                    line.prix = $(this).find('td').attr('data-prix');
                    line.quantite = $(this).find('input:eq(0)').val();
                    data.data.push(line);
                });
                $.ajax({
                    url: "../../../controller/RetourAchatProduitController.php",
                    type: 'POST',
                    async: false,
                    data: { op: "addMany", retour: data },
                    success: function(result) {
                        if(result.data)
                        {
                            alertify.success("Retour ajouté avec success");
                            $('.retour-modal').modal('hide');
                        }
                        else
                        {
                            alertify.error("Echec d'ajouter le retour");
                            console.log(result);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        })


    });
    
    ajouter_btn.click(function() {
        var bon = $(this).attr("data-bon");
        if (produit_select.val() == null || produit_select.val() == "")
            alertify.alert("Vous devez chiosir un produit.");
        else if (quantite_input.val() == "0")
            alertify.alert("La quantité disponible de ce produit égale à la quantité max à commander.");
        else {
            $.ajax({
                url: "../../../controller/BonAchatProduitController.php",
                type: 'POST',
                async: false,
                data: { op: "add", bon: bon, produit: produit_select.val(), prix: prix_input.val(), quantite: quantite_input.val() },
                success: function(result) {

                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec d'ajouté le bon");
                    else
                        alertify.success("Ajouté avec succès");
                    fillBonTable(bon);
                    table.ajax.reload();

                },
                error: function(xhr, status, error) {
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
        }
    });

    $(".btn-excel").click(function() {
        $("#bon-table").tableHTMLExport({ type: 'csv', filename: 'Bon - ' + $(".date_modal").text().replace("|", "") + $(".fournisseur_modal").text() + '.csv', ignoreColumns: '.buttons,.tabledit-toolbar-column' });
    });

    $(".btn-pdf").click(function() {
        //$("#bon-table").tableHTMLExport({ type: 'pdf', filename: 'Bon - ' + $(".date_modal").text().replace("|", "") + $(".fournisseur_modal").text() + '.pdf', ignoreColumns: '.buttons,.tabledit-toolbar-column' });
        generatePDF('Bon de réception');
    });

    $('.pdf-modal').on('hidden.bs.modal', function (e) {
        var iframe = document.getElementById('pdfHolder');
        iframe.src = "";
    });
    
    
    $('.produit-modal').on('hidden.bs.modal', function (e) {
        var _id = $('#produitModalBtn').attr("data-id");
        var iframe = document.getElementById('produitHolder');
        iframe.src = "";
        getAllProducts(_id);
        
    });
    
    $('.produit-modal').on('show.bs.modal', function (e) {
        var iframe = document.getElementById('produitHolder');
        iframe.src = "http://crm.toubkalit.com/public/commercial/services/catalogues.php";
        
        iframe.onload = function(){
            $(this).contents().find('header').remove();
            $(this).contents()
            .find('.wrapper').css('padding-top','0px')
            .find('div:eq(0)').css('margin-top','0px').addClass('w-100')
            .find('.page-title-box .btn-group.pull-right').remove();
            $(this).contents().find('.footer').remove();
        }
    });
});