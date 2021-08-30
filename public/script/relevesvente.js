var client_select = $("#client_select");
var types_select = $("#types_select");
var datedu_input = $("#datedu_input");
var dateau_input = $("#dateau_input");
var changeDate = function(date) {
    if (date == "")
        return "";
    var d = date.split("/");
    return d[2] + "-" + d[0] + "-" + d[1];
}

var sum = function (data){
    var s = 0;
    data.each(function(v,i){
        if(v != null && v != "")
            s += parseFloat(v);
    })
    return s;
}

var fillRelevesTable = function(id,tableName) {
    var remise = tableName.toLowerCase() == "facture" || tableName.toLowerCase() == "commande" ? "<th>Remise</th>" : "";
    var thead = "<tr><th>Produit</th><th>Prix</th>"+remise+"<th>Quantite</th><th>Total HT</th></tr>";
    $("#releves-table").find("tbody").empty();
    $("#releves-table").find("thead").empty().append(thead);
    $.ajax({
        url: "../../../controller/RelevesVenteProduitsController.php",
        type: 'POST',
        async: false,
        data: { tableName: tableName, id: id },
        success: function(result) {

            if (result.data.length > 0) {
                var t = "";

                result.data.forEach(e => {
                    var prix = "<td>" + e.prix + "</td>";
                    var remise = tableName.toLowerCase() == "facture" || tableName.toLowerCase() == "commande" ? "<td>"+e.remise+"</td>" : "";
                    var total_ht = "<td>" + (e.total_ht ? parseFloat(e.total_ht).toFixed(2) : "") + "</td>";
                    if(e.designation_vente)
                    t += "<tr><td data-avoir='" + e.avoir + "' data-produit='" + e.produit + "' >" + e.designation_vente + "</td>" + prix +remise+ "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                    else
                    t += "<tr><td data-avoir='" + e.avoir + "' data-produit='" + e.produit + "' >" + e.designation_achat + "</td>" + prix +remise+ "<td>" + e.quantite + "</td>" + total_ht + "</tr>";
                });

                $("#releves-table").find("thead").empty().append(thead);
                $("#releves-table").find("tbody").empty().append(t);


            }
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
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

var generatePDF = function (filename){
    var __RELEVES__ = table.ajax.json().entreprise;
    var nEntreprise = __RELEVES__.nom_fr || "";
    var nEAdresse = __RELEVES__.adresse || "";
    var nEVille = __RELEVES__.ville || "";
    var nETele = __RELEVES__.telephone || "";
    var nEFax = __RELEVES__.fax || "";
    var nECodeICE = __RELEVES__.code_ice || "";
    var image = "http://"+document.location.host+"/public/images/"+__RELEVES__.logo;
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

    var data=table.ajax.json().data;
    var columns = [
        {title: "", dataKey: "_id"},
        {title: "Etat", dataKey: "etat"},
        {title: "Date", dataKey: "date"},
        {title: "Client", dataKey: "nom"},
        {title: "Montant HT", dataKey: "total_ht"},
        {title: "Montant TTC", dataKey: "total_ttc"}
    ];

    if(client_select.val() != "" && types_select.val() != "")
    {
        columns = [
            {title: "N°", dataKey: "_id"},
            {title: "Date", dataKey: "date"},
            {title: "Montant HT", dataKey: "total_ht"},
            {title: "Montant TTC", dataKey: "total_ttc"}
        ];

        $(data).each(function (i,v) {
            col = data[i]._id;
            data[i]._id = col.split(" ")[3];
        })
    }
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
        h +=30;
        doc.setFontSize(13);
        doc.setFontStyle('bold');
        doc.text(nEntreprise.toUpperCase(),40,h);
        h += 14;
        doc.setFontSize(8);
        doc.setFontStyle('normal');
        var adresse = chunkString(nEAdresse.toUpperCase(),110);
        for (var i = 0 ; i< (adresse != null ? adresse.length :0 ) ; i++){
            doc.text(adresse[i],40,h,'left');
            h+=10;
        }
        for (var i = 2 ; i< (adresse != null ? adresse.length :0 ) ; i++){
            h-=10;
        }
        doc.text(nEVille.toUpperCase(),40,h,'left');
        h += 10;
        doc.text("CODE ICE : "+nECodeICE.toUpperCase(),40,h,'left');
        h += 10;
        doc.text("Tel : "+nETele.toUpperCase(),40,h,'left');
        h += 10;
        doc.text("Fax : "+nEFax.toUpperCase(),40,h,'left');
        h += 20;
        if(client_select.val() != "" && types_select.val() != "")
        {
            doc.setFontSize(11);
            doc.setFontStyle('bold');
            doc.text("Les "+$("#types_select option:selected").text().toLowerCase()+" de client "+client_select.text()+" sont : ",40,h,'left');
        }

    };

    var footer = function(data){
        let height = doc.internal.pageSize.getHeight();
        doc.line(30, height-30, doc.internal.pageSize.width-30,height-30);
        doc.setFontSize(8);
        doc.setFontStyle('bold');
        //centeredText(nEAdresse.toUpperCase(),height-40);
        doc.text(nEAdresse.toUpperCase(),(doc.internal.pageSize.width/2),height-20,'center');
        doc.text("Tel : "+nETele+" - "+"Fax : "+nEFax,(doc.internal.pageSize.width/2),height-10,'center');

        var str = doc.internal.getNumberOfPages()
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
            top: 220
        }
        //startY: doc.autoTableEndPosY() + 20
    };
    doc.autoTable(columns, data, options);

    let finalY = doc.lastAutoTable.finalY; // The y position on the page
    var totalHT = sum(table.column(4).data());
    var totalTTC = sum(table.column(5).data());
    var tva = 0;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-205, finalY+20, 56, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-200,finalY+34, 'Total HT');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, ( totalHT ? parseFloat(totalHT).toFixed(2) + " DH" : ""));
    finalY += 22;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-205, finalY+20, 56, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-200,finalY+34, 'Total TTC');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, ( totalTTC ? parseFloat(totalTTC).toFixed(2) + " DH" : ""));

    doc.setProperties({
        title: filename,
        subject: 'Avoir de réception',
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

$(document).ready(function(){
    fillSelect();
    table = $('#datatable-releves').DataTable({
        'serverSide': true,
        'processing':true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/RelevesClientsController.php",
            cache: false,
            type:'POST',
            data:{
                op:'datatable',
                dateD: function() { return changeDate(datedu_input.val())},
                dateF:function() { return changeDate(dateau_input.val())},
                f:function() { return client_select.val()},
                tableName:function() { return $("#types_select option:selected").attr("data-table")},
                et:function() { return types_select.val()}
            }
        },
        "order": [[ 2, "desc" ]],
        "aaSorting": [],
        "columns": [
            { "data": "_id" },
            { "data": "etat" },
            { "data": "date" },
            { "data": "nom" },
            {
                "data": "total_ht",
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
                    return '<button data-id="' + data.id + '" data-table="'+data.tablename+'" data-toggle="modal" data-animation="bounce" data-target=".releves-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Details</button>';
                }
            }
        ]
    });
    $('.releves-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var _id = button.attr("data-id");
        var tableName = button.attr("data-table");
        var type = button.closest("tr").find("td:eq(0)").text();
        var date = button.closest("tr").find("td:eq(2)").text();
        var nom = button.closest("tr").find("td:eq(3)").text();

        $(".date_modal").html("<span class='badge badge-primary'>" + type + "</span> " + date);
        $(".client_modal").text(" - " + nom);

        fillRelevesTable(_id,tableName);

    });
    client_select.change(function () {
        table.ajax.reload();
    });

    $(".btn-pdf").click(function() {
        //$("#avoir-table").tableHTMLExport({ type: 'pdf', filename: 'Avoir - ' + $(".date_modal").text().replace("|", "") + $(".client_modal").text() + '.pdf', ignoreColumns: '.buttons,.tabledit-toolbar-column' });
        generatePDF('Releves');
    });
    $(".input-daterange input").datepicker()
        .on("change", function(e) {
            table.ajax.reload();

        });

    types_select.change(function () {
        table.ajax.reload();
    });

    //$("#types_select").selectize()
});