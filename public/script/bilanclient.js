var client_select = $("#client_select");
var dateD_input = $('#datedu_input');
var dateF_input = $('#dateau_input');
var sold = 0;

var changeDate = function(date) {
    if (date == "")
        return "";
    var d = date.split("/");
    return d[2] + "-" + d[0] + "-" + d[1];
}

var fillSelect = function() {
    var d = {};
    $.ajax({
        url: "../../../controller/ClientController.php",
        type: 'POST',
        async: false,
        data: d,
        success: function(result) {
            var t = "<option value=''>Tous</option>";
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

    var data=$.grep(table.ajax.json().data, function(v,i){
        return v;
    });
    
    var columns = [
        {title: "Code", dataKey: "code"},
        {title: "Client", dataKey: "nom"},
        {title: "Débit", dataKey: "debit"},
        {title: "Crédit", dataKey: "credit"},
        {title: "Solde", dataKey: "solde"},
        {title: "Date dérniere opération", dataKey: "date"}
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
        
        /*
        if(client_select.val() != "" && types_select.val() != "")
        {
            doc.setFontSize(11);
            doc.setFontStyle('bold');
            doc.text("Les "+$("#types_select option:selected").text().toLowerCase()+" de client "+client_select.text()+" sont : ",40,h,'left');
        }
        */

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
    /*
    let finalY = doc.lastAutoTable.finalY; // The y position on the page
    var totalHT = sum(table.column(5).data());
    var totalTTC = sum(table.column(6).data());
    var tva = 0;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-220, finalY+20, 74, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-215,finalY+34, 'Total TTC');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, ( totalHT ? parseFloat(totalHT).toFixed(2) + " DH" : ""));
    finalY += 22;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-220, finalY+20, 74, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-215,finalY+34, 'Reste à payer');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, ( totalTTC ? parseFloat(totalTTC).toFixed(2) + " DH" : ""));
    */
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
    table = $('#datatable-comptes').DataTable({
        'serverSide': true,
        'processing':true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/ClientController.php",
            cache: false,
            dataSrc: 'data',
            type:'POST',
            data:{
                opp:'datatable',
                client:function() { return client_select.val()},
                op:"bilan"
            }
        },
        "order": [],
        "aaSorting": [],
        "columns": [
            { "data": "code" },
            { "data": "nom" },
            { "data": "debit" },
            { "data": "credit" },
            { "data": "solde" },
            { "data": "date" }
        ],
        "bSort" : false,
        "drawCallback": function( settings ) {
            
            table.columns(1).visible(isNaN(client_select.val()));
            
            var totalDebit = 0 , totalCredit = 0;
            settings.aoData.forEach((v,i) => totalDebit = totalDebit + parseFloat(v._aData.debit));
            settings.aoData.forEach((v,i) => totalCredit = totalCredit + parseFloat(v._aData.credit));
                       
            $("#totalDebit").text(totalDebit.toFixed(2));
            $("#totalCredit").text(totalCredit.toFixed(2));
            $("#sold").text((totalCredit - totalDebit).toFixed(2));
            $('#etatCompte').text((totalCredit - totalDebit) > 0 ? "Compte débiteur" : "Compte créditeur");
            $('#sold').addClass((totalCredit - totalDebit) > 0 ? "text-danger" : "text-success").removeClass((totalCredit - totalDebit) <= 0 ? "text-danger" : "text-success");
            sold = 0;
                
        },
        "createdRow": function( row, data, dataIndex ) {
            var debit = parseFloat($(row).find('td:eq(2)').text());
            var credit = parseFloat($(row).find('td:eq(3)').text());            
            $(row).find('td:eq(4)').addClass((credit - debit) > 0 ? "text-danger" : "text-success");

        }
    });
    client_select.change(function () {
        table.ajax.reload();

    });
    $(".btn-pdf1").click(function() {
        var iframe = document.getElementById('pdfHolder');
        iframe.src = "";
        generatePDF('Bilan Clients');
    });
    //$("#types_select").selectize()
});