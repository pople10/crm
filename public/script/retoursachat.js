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
var __CURRENTRETOUR__ = {};
var __CURRENTRETOURREF__ = {};
var __RETPROLENGTH__ =0;

/* ------------------------- FUNCTIONS ----------------------------- */

var generatePDF = function (filename){
    __CURRENTRETOUR__ = __CURRENTRETOURREF__.data()[0];
    var nRetour = __CURRENTRETOUR__.id || "";
    var nDate = __CURRENTRETOUR__.date_creation || "";
    var nEntreprise = __CURRENTRETOUR__.nomE || "";
    var nEAdresse = __CURRENTRETOUR__.adresseE || "";
    var nEVille = __CURRENTRETOUR__.villeE || "";
    var nETele = __CURRENTRETOUR__.teleE || "";
    var nEFax = __CURRENTRETOUR__.faxE || "";
    var nECodeICE = __CURRENTRETOUR__.codeICE || "";
    var nFournisseur = __CURRENTRETOUR__.nomF || "";
    var nFAdresse = __CURRENTRETOUR__.adresseF || "";
    var nFVille = __CURRENTRETOUR__.villeF || "";
    var nFTele = __CURRENTRETOUR__.teleF || "";
    var nFFax = __CURRENTRETOUR__.faxF || "";
    var totalTTC = __CURRENTRETOUR__.total_ttc || 0;
    var tva = __CURRENTRETOUR__.tva || 0;
    var totalHT = __CURRENTRETOUR__.total_ht || 0;
    var image = "http://"+document.location.host+"/public/images/"+__CURRENTRETOUR__.image;
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
        {title: "Unit??", dataKey: "unite"},
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
        doc.text("Bon de reteur N?? : "+nRetour,30,h);
        doc.setFontSize(10);
        doc.setFontStyle('normal');
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
        subject: 'Retour de r??ception',
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
                r = parseInt(result.data.quantite_en_stock);
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
    return r;
}

var getAllProducts = function(retour) {
    var d = "";
    /*$.ajax({
        url: "../../../controller/ProduitController.php",
        type: 'POST',
        async: false,
        data: { op:"findAllByRetour",retour : retour},
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
    getLastPrice(retour,produit_select.val());
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
                        op:"findAllByRetour",
                        retour : retour,
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
        e.attr("title","La quantit?? doit ??tre inf??rieur o?? ??gale : "+sumMax);
        e[0].classList.add('parsley-error-focus');
        $(".tabledit-save-button").prop("disabled",true);
    }


    return final;
}

var fillRetourTable = function(_retour) {
    getAllProducts(_retour);
    transfer_btn.hide();
    var thead = ajouter_btn.attr("data-type") == "demande" ? "<tr><th>Retour</th><th>Quantite</th></tr>" : "<tr><th>Produit</th><th>Prix</th><th>Quantite</th><th>Total HT</th></tr>";
    $("#retour-table").find("tbody").empty();
    $("#retour-table").find("thead").empty().append(thead);
    $(".exportsection").show();
    $.ajax({
        url: "../../../controller/RetourAchatProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "findByRetour", retour: _retour },
        success: function(result) {

            //console.log(result.data.length);
            __DATA__ = result.data;
            __RETPROLENGTH__ = result.data.length ;

            if (result.data.length > 0) {
                var t = "";

                result.data.forEach(e => {
                    var prix = "<td>" + e.prix + "</td>";
                    var total_ht = "<td>" + e.total_ht + "</td>";
                    if(e.designation_achat)
                    t += "<tr><td data-retour='" + e.retour + "' data-produit='" + e.produit + "' >" + e.designation_achat + "</td>" + prix + "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                    else
                    t += "<tr><td data-retour='" + e.retour + "' data-produit='" + e.produit + "' >" + e.designation_vente + "</td>" + prix + "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                });

                $("#retour-table").find("thead").empty().append(thead);
                $("#retour-table").find("tbody").empty().append(t);

                $('#retour-table').Tabledit({
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
    var quantiteInput = td.eq(2).find("input:eq(0)");
    getFinalQuantiteMax(quantiteInput,quantiteMax);
}

var updateD = function(e) {
    var button = $(e);
    var td = button.closest("tr").find("td");
    var produit_id = td.eq(0).attr("data-produit");
    var retour = td.eq(0).attr("data-retour");
    var prix = td.eq(1).find("input:eq(0)").val();
    var quantite = td.eq(2).find("input:eq(0)").val();
    var quantiteMax = getFinalQuantiteMax(td.eq(2).find("input:eq(0)"),produit_id);



    $.ajax({
        url: "../../../controller/RetourAchatProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "update",retour: retour, produit: produit_id, prix: prix, quantite: quantite,quantiteMax: quantiteMax },
        success: function(result) {

            //console.log(result);
            alertify.success("Modifi?? avec succ??s");
            fillRetourTable(retour);
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
    var retour = td.eq(0).attr("data-retour");

    $.ajax({
        url: "../../../controller/RetourAchatProduitController.php",
        type: 'POST',
        async: false,
        data: { op: "delete", retour: retour,produit:produit_id },
        success: function(result) {
            if (typeof result == "string" && result.includes("error"))
                alertify.error("Echec de supprimer");
            else
                alertify.success("Supprim?? avec succ??s");
            fillRetourTable(retour);
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
                if(result.data[i].type == "Soci??t??")
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

var updateRetour = function(id) {
    $.ajax({
        url: "../../../controller/RetourAchatController.php",
        type: 'POST',
        async: false,
        data: { op: "findById", id: id },
        success: function(result) {

            if (result.response == true) {
                fournisseur_select.selectize()[0].selectize.setValue(result.data.fournisseur);
                date_input.val(result.data.date_creation);

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

var deleteRetour = function(id) {
    alertify.confirm("Voulez vous vraiment supprimer ce retour?", function(asc) {
        if (asc) {
            $.ajax({
                url: "../../../controller/RetourAchatController.php",
                type: 'POST',
                async: false,
                data: { op: "delete", id: id },
                success: function(result) {
                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec de supprimer le retour");
                    else
                        alertify.success("Retour supprim?? avec succ??s");

                    table.ajax.reload();

                },
                error: function(xhr, status, error) {
                    alertify.error("Echec de supprimer le retour");
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
        } else {
            alertify.error("Op??ration annul??e");
        }
    }, function(ev) {
        ev.preventDefault();
        alertify.error("Op??ration annul??e");
    });

}

var getLastPrice = function(retour,produit){
    $.ajax({
        url: "../../../controller/RetourAchatController.php",
        type: 'POST',
        async: false,
        data: { op: "getLastPrice", produit: produit, retour:retour },
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
    table = $('#datatable-retour').DataTable({
        "processing":true,
        "serverSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/RetourAchatController.php",
            cache: false,
            data:{
                op : 'datatable'
            },
            type: 'POST'
        },
        "order": [],
        "aaSorting": [],
        "columns": [
            { "data": "etat" },
            { "data": "id" },
            { "data": "bon" },
            { "data": "date_creation" },
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
                    return '<button data-id="' + data.id + '" data-etat="' + data.etat + '" data-toggle="modal" data-animation="bounce" data-target=".retour-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> D??tails</button><button onclick="updateRetour(' + data.id + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button data="" onclick="deleteRetour(' + data.id + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
                }
            }

        ],/*
        "createdRow":function(row,_data,index){
            var data = {
              etat : _data[0],
              id : _data[1]
            };
            var cell = '<button data-id="' + data.id + '" data-etat="' + data.etat + '" data-toggle="modal" data-animation="bounce" data-target=".retour-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> D??tails</button><button onclick="updateRetour(' + data.id + ')" type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-pencil"></span></button><button data="" onclick="deleteRetour(' + data.id + ')" type="button" class="tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
        
            $(row).find('td:last').html(cell);
        },*/
        "initComplete": function(settings, json) {
            if(getUrlParameter('id'))
                table.columns(1).search("\\b"+getUrlParameter('id')+"\\b",true,false).draw();
          }
    });

    $('#datatable-retour tbody').on( 'click', 'tr', function () {
        __CURRENTRETOURREF__ = table.rows(table.row( this ).index());
        //console.log(__CURRENTRETOUR__);
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
            var t = $(this).attr("t") == 0 ? "En attente" : "En attente";
            var data = { fournisseur: fournisseur_select.val(), date_creation: date_input.val(),etat:t};

            if ($(this).attr("op") == "N") {
                data.op = "add";
            } else if ($(this).attr("op") == "M") {
                data.op = "update";
                data.id = $(this).attr("data-id");
            }

            $.ajax({
                url: "../../../controller/RetourAchatController.php",
                type: 'POST',
                async: false,
                data: data,
                success: function(result) {
                    m = data.op == "add" ? "ajout??" : "modifi??";
                    var lastIDInserted = 0;
                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec de " + m + " le retour");
                    else {
                        r = result.data;
                        alertify.success("Retour " + m + " avec succ??s");
                        var last= $.ajax({url: "../../../controller/RetourAchatController.php",async:false,type:"POST",data:{op:"lastID"}}).responseText;
                        last=JSON.parse(last);
                        lastIDInserted=last.data.Max;
                    }
                    table.ajax.reload();
                    setTimeout(function(){$("button[data-target='.retour-modal'][data-id='"+lastIDInserted+"']").click();
                    },1000);
                },
                error: function(xhr, status, error) {
                    m = data.op == "add" ? "d'ajouter" : "de modifier";
                    alertify.error("Echec " + m + " le retour");
                    console.log(xhr + " - " + status + " - " + error);
                }
            });
        }

    });

    $('.retour-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var _id = button.attr("data-id");
                $('#produitModalBtn').attr('data-id',_id);
        var etat = button.attr("data-etat");
        ajouter_btn.attr("data-retour", _id);
        var date = button.closest("tr").find("td:eq(2)").text();
        var nom = button.closest("tr").find("td:eq(3)").text();

        transfer_btn.attr("data-id",_id);
        transfer_btn.attr("vers",etat == "En attente" ? "Envoy??e":"En attente");
        //transfer_btn.find("span:eq(0)").text(type);

        $(".date_modal").html("<span class='badge badge-primary'>" + etat + " - "+ _id +"</span> " + date);
        $(".fournisseur_modal").text(" - " + nom);

        //getAllProducts(_id);

        fillRetourTable(_id);

        if(etat == "Envoy??e")
            transfer_btn.hide();

    });




    ajouter_btn.click(function() {
        var retour = $(this).attr("data-retour");
        if (produit_select.val() == null || produit_select.val() == "")
            alertify.alert("Vous devez chiosir un produit.");
        else if (quantite_input.val() == "0")
            alertify.alert("La quantit?? disponible de ce produit ??gale ?? la quantit?? max ?? commander.");
        else {
            $.ajax({
                url: "../../../controller/RetourAchatProduitController.php",
                type: 'POST',
                async: false,
                data: { op: "add", retour: retour, produit: produit_select.val(), prix: prix_input.val(), quantite: quantite_input.val() },
                success: function(result) {

                    if (typeof result == "string" && result.includes("error"))
                        alertify.error("Echec d'ajout?? le retour");
                    else
                        alertify.success("Ajout?? avec succ??s");
                    fillRetourTable(retour);
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
            console.log("clicked")
            if(__RETPROLENGTH__ != 0) {
                var retour = $(this).attr("data-id");
                $.ajax({
                    url: "../../../controller/RetourAchatController.php",
                    type: 'POST',
                    async: false,
                    data: {op: "updateEtat", id: retour, etat: $(this).attr("vers")},
                    success: function (result) {
                        console.log(result);
                        if (typeof result == "string" && result.includes("error"))
                            alertify.error("Echec de'envoyer le bon de retour");
                        else {
                            alertify.success("Envoy??e avec succ??s");
                            transfer_btn.attr("vers", "En attente").attr("data-id", retour);
                            fillRetourTable(retour);
                            transfer_btn.hide();
                            table.ajax.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr + " - " + status + " - " + error);
                        alertify.error("Echec de'envoyer le bon de retour");
                    }
                });
            }
        });
    })

    $(".btn-excel").click(function() {
        $("#retour-table").tableHTMLExport({ type: 'csv', filename: 'Retour - ' + $(".date_modal").text().replace("|", "") + $(".fournisseur_modal").text() + '.csv', ignoreColumns: '.buttons,.tabledit-toolbar-column' });
    });

    $(".btn-pdf").click(function() {
        //$("#retour-table").tableHTMLExport({ type: 'pdf', filename: 'Retour - ' + $(".date_modal").text().replace("|", "") + $(".fournisseur_modal").text() + '.pdf', ignoreColumns: '.buttons,.tabledit-toolbar-column' });
        generatePDF('Bon de retour')
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