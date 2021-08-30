var fournisseur_select = $("#fournisseur_select");
var types_select = $("#types_select");
var datedu_input = $("#datedu_input");
var dateau_input = $("#dateau_input");
var ids = [];
var paimentsDATA = [];
var data_table = "";
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
 || ""
var fillPaimentsTable = function(id,tableName) {
    var thead = "<th>Date</th><th>Type</th><th>Numéro de chèque</th><th>Montant</th>";
    $("#paiment-table").find("tbody").empty();
    $("#paiment-table").find("thead").empty().append(thead);
    $(".exportsection").hide();
    paimentsDATA = [];
    $.ajax({
        url: "../../../controller/Paiment"+tableName+"AchatController.php",
        cache: false,
        type:'POST',
        data:{op:"findAllBy"+tableName,id:id},
        success: function(result) {

            if (result.data.length > 0) {
                paimentsDATA = result.data;
                var t = "";
                $(".exportsection").show();
                result.data.forEach(e => {
                    var type = "<td>" + e.type + "</td>";
                    var montant = "<td>" + e.montant + "</td>";
                    t += "<tr><td>" + e.date + "</td>" + type + "<td>" + e.numero_cheque + "</td>" + montant + "</tr>";
                });

                $("#paiment-table").find("thead").empty().append(thead);
                $("#paiment-table").find("tbody").empty().append(t);
            }
            // console.log(paimentsDATA);
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
            t += '<option value="">Tous</option>';
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

    var data= JSON.parse(JSON.stringify(table.ajax.json().data));
    data = $.grep(data, function(v,i){
        return v.total_ttc != null;
    });
    console.log(data);
    var columns = [
        {title: "", dataKey: "_id"},
        {title: "Etat", dataKey: "type"},
        {title: "Date", dataKey: "date"},
        {title: "Fournisseur", dataKey: "nom"},
        {title: "Montant TTC", dataKey: "total_ttc"},
        {title: "Reste à payer", dataKey: "reste"}
    ];

    if(fournisseur_select.val() != "" && types_select.val() != "")
    {
        columns = [
            {title: "N°", dataKey: "id"},
            {title: "Date", dataKey: "date"},
            {title: "Montant TTC", dataKey: "total_ttc"},
            {title: "Reste à payer", dataKey: "reste"}
        ];

        /*$(data).each(function (i,v) {
            col = data[i]._id;
            data[i]._id = col.split(" ")[3];
        })*/
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
        h += 20;

        if(fournisseur_select.val() != "" && types_select.val() != "")
        {
            doc.setFontSize(11);
            doc.setFontStyle('bold');
            doc.text("Les "+$("#types_select option:selected").text().toLowerCase()+" de fournisseur "+fournisseur_select.text()+" sont : ",40,h,'left');
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
    doc.text(doc.internal.pageSize.width-144,finalY+34, totalHT.toFixed(2) + " DH");
    finalY += 22;
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-220, finalY+20, 74, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-215,finalY+34, 'Reste à payer');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, totalTTC.toFixed(2) + " DH");

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
var generatePDF2 = function (filename,d){
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

    var data=paimentsDATA;
    var columns = [
            {title: "Date", dataKey: "date"},
            {title: "Type", dataKey: "type"},
            {title: "Numéro de chèque", dataKey: "numero_cheque"},
            {title: "Montant", dataKey: "montant"}
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
        h += 20;

            doc.setFontSize(11);
            doc.setFontStyle('bold');
            var tname = d.tablename.toLowerCase() == "avoir" ? "d'avoir" : "de facture";
            doc.text("Les paiments "+tname+" n° "+d.id+" de fournisseur "+d.fournisseur+" sont : ",40,h,'left');


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
    var totalHT = parseFloat(d.total);
    var totalTTC = parseFloat(d.reste);
    var tva = 0;
    /*doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-220, finalY+20, 74, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-215,finalY+34, 'Total TTC');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, totalHT + " DH");
    finalY += 22;*/
    doc.setFontSize(10);
    doc.setFontStyle('bold');
    doc.setFillColor(173,173,173);
    doc.rect(doc.internal.pageSize.width-220, finalY+20, 74, 21, 'F');
    doc.setTextColor(255, 255, 255);
    doc.text(doc.internal.pageSize.width-215,finalY+34, 'Reste à payer');
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle('normal');
    doc.text(doc.internal.pageSize.width-144,finalY+34, totalTTC.toFixed(2) + " DH");

    doc.setProperties({
        title: filename,
        subject: '',
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


var add_err = function(element, msg) {
    var e = '<ul class="parsley-errors-list filled" id="' + element.prop("id") + '-error"><li class="">' + msg + '</li></ul>';
    element.addClass("parsley-error");
    element.parent().append(e);

}
var delete_err = function(element) {
    element.removeClass("parsley-error");
    element.parent().find(".parsley-errors-list").remove();
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
            url: "../../../controller/ReglementsController.php",
            cache: false,
            type:'POST',
            data:{
                op:'datatable',
                dateD: function() { return changeDate(datedu_input.val())},
                dateF:function() { return changeDate(dateau_input.val())},
                f:function() { return fournisseur_select.val()},
                tableName:function() { return $("#types_select option:selected").attr("data-table")},
                type:function() { return types_select.val()}
            }
        },
        "order": [[ 3, "desc" ]],
        "aaSorting": [],
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]/*,
        'createdRow':function(row,_data,index){
            var data = {id:_data[0],tablename:_data[7],nom:_data[4],total_ttc:_data[5],reste:_data[6],total_ht:_data[8],type:_data[2]};
            
            
            $("#maincheck").show();
            var first = '<input type="checkbox" class="" data-id="'+data.id+'" data-table="'+data.tablename+'" data-type="'+data.type+'" data-m="'+data.reste+'" name="checkbox" data-parsley-multiple="groups">';
            
            if(data.total_ht == null || data.total_ttc == null|| data.reste == 0 || data.reste == null)
                    {
                        first = '';
                    }
            
            var last = '<button data-id="' + data.id + '" data-table="'+data.tablename+'" data-fournisseur="'+data.nom+'" data-total="'+data.total_ttc+'"  data-reste="'+data.reste+'" data-toggle="modal" data-animation="bounce" data-target=".paiment-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Détails</button>';
        
            $(row).find('td:first').html(first);
            $(row).find('td:last').html(last);
            $(row).find('td:eq(5)').text(parseFloat(data.total_ttc).toFixed(1));
            $(row).find('td:eq(6)').text(parseFloat(data.reste).toFixed(1));
        }*/,
        "columns": [
            {
                "data": null,
                "render": function(data) {
                    if(data.total_ht == null || data.total_ttc == null|| data.reste == 0 || data.reste == null)
                    {
                        return '';
                    }
                    $("#maincheck").show();
                    return '<input type="checkbox" class="" data-id="'+data.id+'" data-table="'+data.tablename+'" data-type="'+data.type+'" data-m="'+data.reste+'" name="checkbox" data-parsley-multiple="groups">';
                }
            },
            { "data": "_id" },
            { "data": "type" },
            { "data": "date" },
            { "data": "nom" },
            { 
                "data": "total_ttc",
                "render": function(data){
                    return !isNaN(parseFloat(data)) ? parseFloat(data).toFixed(2) : data;
                }
            },
            { 
                "data": "reste",
                "render": function(data){
                    return !isNaN(parseFloat(data)) ? parseFloat(data).toFixed(2) : data;
                }
            },
            {
                "data": null,
                "render": function(data) {
                    return '<button data-id="' + data.id + '" data-table="'+data.tablename+'" data-fournisseur="'+data.nom+'" data-total="'+data.total_ttc+'"  data-reste="'+data.reste+'" data-toggle="modal" data-animation="bounce" data-target=".paiment-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Détails</button>';
                }
            }
        ],
        "initComplete": function( settings, json ) {
            $(".btn-pdf1").show();
            var filtered_data = $.grep(table.ajax.json().data, function(v,i){
                return v.total_ttc != null;
            });
            // if(filtered_data.length == 0){
            //     console.log(true);
            //     $(".btn-pdf1").hide();
            // }

            if( fournisseur_select.val() == "" || types_select.val() == ""){
                $('#maincheck').hide();
                $("#maincheck").prop('disabled',true);
            }

            $("#datatable-releves tbody input[type='checkbox']").change(function () {
                data_table = $(this).attr("data-table");

                if(table.$("input[name='checkbox']:checked").length == 0){
                    data_table = "";
                    table.$("input[name='checkbox']").attr("disabled",false).attr("checked",false).show();
                }
                else{
                    table.$("input[data-table!='"+data_table+"']").each(function(i,v) {
                        $(v).attr("disabled",true).attr("checked",false).hide();
                    });
                }
            });
        },
        "drawCallback": function( settings ) {
            $('#maincheck').show();
            $("#maincheck").prop('disabled',false);
            $("#reglee_btn").prop("hidden",true);
            $("#maincheck").attr("checked",false);
            ids = [];
            table.$("input[name='checkbox']").change(function(){
                $("#reglee_btn").prop("hidden",true);
                ids = [];
                table.$("input[name='checkbox']:checked").each(function(i,v) {
                    $("#reglee_btn").prop("hidden",!v.checked);
                    ids.push({id:$(this).attr("data-id"),montant:parseFloat($(this).attr("data-m"))});
                });
            });

            $("#maincheck").change(function(){
                $("#reglee_btn").prop("hidden",true);
                ids = [];
                table.$("input[name='checkbox']").prop("checked",$(this).prop("checked"));
                table.$("input[name='checkbox']:checked").each(function(v,i) {
                    $("#reglee_btn").prop("hidden",!i.checked);
                    ids.push({id:$(this).attr("data-id"),montant:parseFloat($(this).attr("data-m"))});
                });
            });
            if( fournisseur_select.val() == "" || types_select.val() == "" || table.$("input[name='checkbox']").length==0){
                $('#maincheck').hide();
                $("#maincheck").prop('disabled',true);
            }
            
            $("#datatable-releves tbody input[type='checkbox']").change(function () {
                data_table = $(this).attr("data-table");

                if(table.$("input[name='checkbox']:checked").length == 0){
                    data_table = "";
                    table.$("input[name='checkbox']").attr("disabled",false).attr("checked",false).show();
                }
                else{
                    table.$("input[data-table!='"+data_table+"']").each(function(i,v) {
                        $(v).attr("disabled",true).attr("checked",false).hide();
                    });
                }
            });
            
        }
    });
    $('.paiment-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.attr("data-id");
        var fournisseur = button.attr("data-fournisseur");
        var total = button.attr("data-total");
        var reste = button.attr("data-reste");
        var t = button.attr("data-table");
        var tname = t.charAt(0).toUpperCase() + t.substring(1);

        $(".tablename").text(t.toUpperCase() + " : ");
        $(".citems").text(id);

        /*if (typeof tablePaiment !== 'undefined')
        {
            tablePaiment.destroy();
            var thead = "<th>Date</th><th>Type</th><th>Numéro de chèque</th><th>Montant</th>";
            $("#paiment-table").find("tbody").empty();
            $("#paiment-table").find("thead").empty().append(thead);
        }*/
        fillPaimentsTable(id,tname);
        /*tablePaiment = $('#paiment-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
            "ajax": {
                url: "../../../controller/Paiment"+tname+"AchatController.php",
                cache: false,
                dataSrc: 'data',
                type:'POST',
                data:{op:"findAllBy"+tname,id:id}
            },
            "columns": [
                { "data": "date" },
                { "data": "type" },
                { "data": "numero_cheque" },
                { "data": "montant" }
            ]
        });*/

        $(".btn-pdf2").attr("data-table",t);
        $(".btn-pdf2").attr("data-fournisseur",fournisseur);
        $(".btn-pdf2").attr("data-total",total);
        $(".btn-pdf2").attr("data-reste",reste);
        $(".btn-pdf2").attr("data-id",id);

    });

    $('.reglee-modal').on('show.bs.modal', function(event) {
        $(".ncheque").hide();
        $("#typer_select").val("espèces");
        $("#typer_select").change(function () {
            $(".ncheque").hide();

            if($(this).val() == "chèque")
                $(".ncheque").show();
            else
                $("#numcheque_input").val("");
        });
        var somme = 0;
        var _ids = [];
        ids.forEach((v, i) => {
            somme +=v.montant;
            _ids.push(v.id);
        })
        $("#montant_input").val(somme);
        _ids.sort();
        if (typeof $("#types_select option:selected").attr("data-table") === "undefined")
            $(".tablename").text(data_table.toUpperCase()+"S : ");
        else
            $(".tablename").text($("#types_select option:selected").attr("data-table").toUpperCase() + "S : ");
        $(".citems").text(_ids.join(", "));

        $("#montant_input").prop("max",somme);

        delete_err($("#montant_input"));
        delete_err($("#typer_select"));
        delete_err($("#numcheque_input"));
        delete_err($(".montantinput"));
        delete_err($(".typeselect"));
    });
    $("#transfer_btn").focus(function () {
        $("#transfer_btn").one('click',function () {
            delete_err($("#montant_input"));
            delete_err($("#typer_select"));
            delete_err($("#numcheque_input"));
            delete_err($(".montantinput"));
            delete_err($(".typeselect"));
            if(parseFloat($("#montant_input").val()) <=0 || parseFloat($("#montant_input").val()) >parseFloat($("#montant_input").prop("max")))
            {
                add_err($("#montant_input"),"");
                add_err($(".montantinput"),"Vous devez inserer un montant valide. Max : "+ $("#montant_input").prop("max"));
            }
            else if ($("#typer_select").val() != "espèces" && $("#typer_select").val() != "chèque")
            {
                add_err($("#typer_select"),"");
                add_err($(".typeselect"),"Vous devez choisir le type");
            }
            else  if ($("#typer_select").val() == "chèque" && $("#numcheque_input").val() == "")
            {
                add_err($("#numcheque_input"),"");
                add_err($(".typeselect"),"Vous devez saisir le numéro de chèque");
            }
            else{
                var t = $("#types_select option:selected").attr("data-table");
                if (typeof t === "undefined")
                    t = data_table;
                var tname = t.charAt(0).toUpperCase() + t.substring(1);
                var montant = parseFloat($("#montant_input").val());
                var s = [];

                ids.forEach((v,i)=>{
                    if(montant>0)
                    {
                        if(montant - v.montant > 0)
                        {
                            s.push({id:v.id,montant:v.montant});
                        }else
                            s.push({id:v.id,montant:montant});
                        montant = montant - v.montant;
                        // console.log(montant);
                    }
                })

                // console.log(ids);
                // console.log('\n..........................................\n');
                // console.log(s);

                if(s.length>0){
                    var numcheque = $("#typer_select").val() == "chèque"  ? $("#numcheque_input").val() : "";
                    $.ajax({
                        url: "../../../controller/Paiment"+tname+"AchatController.php",
                        type: 'POST',
                        async: false,
                        data: {op:"multipleAdd",items : s,type : $("#typer_select").val(),numero_cheque : numcheque},
                        success: function(result) {
                            if (typeof result == "string" && result.includes("error"))
                                alertify.error("Echec d'ajouter le règlemenet");
                            else {
                                r = result.data;
                                alertify.success("Règlemenet ajouté avec succès");
                            }
                            table.ajax.reload();
                            $('.reglee-modal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            alertify.error("Echec d'ajouter le règlemenet");
                            console.log(xhr + " - " + status + " - " + error);
                        }
                    });
                }

            }
        });
    })

    fournisseur_select.change(function () {
        table.ajax.reload();
    });

    $(".btn-pdf1").click(function() {
        var iframe = document.getElementById('pdfHolder');
        iframe.src = "";
        generatePDF('Reglements');
    });
    $(".btn-pdf2").click(function() {
        var iframe = document.getElementById('pdfHolder');
        iframe.src = "";
        var d = {id:$(this).attr("data-id"),tablename: $(this).attr("data-table"),fournisseur:$(this).attr("data-fournisseur"),total:$(this).attr("data-total"),reste:$(this).attr("data-reste")};
        generatePDF2('Paiment',d);
    });
    $(".input-daterange input").datepicker()
        .on("change", function(e) {
            table.ajax.reload();

        });

    $("#typer_select").change(function () {
        if($(this).val() == "espèces")
        {
            delete_err($("#numcheque_input"));
            delete_err($(".typeselect"));
        }
    });
    types_select.change(function () {
        table.ajax.reload();
    });

    //$("#types_select").selectize()
});