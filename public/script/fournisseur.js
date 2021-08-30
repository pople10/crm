var table = $('#datatable-fournisseurs').DataTable({
    "scrollX": true,
	"processing": true,
	'serverSide':true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
    },
    "ajax": {
        url: "../../../controller/FournisseurController.php",
        cache: false,
        data: {
            op : 'datatable'
        },
        type : 'POST'    },
    /*'createdRow' : function(row,_data,indew){
        data = _data[0];
        var cell = '<button type="button" class="update tabledit-edit-button btn btn-sm btn-info" value="' + data + '" style="float: none; margin: 5px;"> <span class="ti-pencil"></span></button><button type="button" value="' + data + '" class="delete tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
    
        $(row).find('td:last').html(cell);
    }*/
    "columns": [
        {"data": "id"},
        {"data": "nom"},
        {"data": "email"},
        {"data": "telephone"},
        {"data": "fax"},
        {
            "data": "id",
            "render": function (data) {
                return '<button type="button" class="update tabledit-edit-button btn btn-sm btn-info" value="' + data + '" style="float: none; margin: 5px;"> <span class="ti-pencil"></span></button><button type="button" value="' + data + '" class="delete tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
            }
        }
    ]
});

new $.fn.dataTable.Buttons(table, {
    buttons: [
        'copy', 'excel', 'pdf'
    ]
});

table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));

var op = 'add';
var id = 0;

$("#enregistrer_btn").click(function () {
    $.ajax({
        url: "../../../controller/FournisseurController.php",
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: {
            op: op,
            id: id,
            nom: $("#nom_input").val(),
            noms: $("#noms_input").val(),
            type: $("input[name=customRadio]:checked").val(),
            prenom: $("#prenom_input").val(),
            civilite: $("#civilite_select").val(),
            adresse: $("#adresse2_input").val() != "" ? ("#adresse1_input").val() + " & " + $("#adresse2_input").val() : $("#adresse1_input").val(),
            cp: $("#cp_input").val(),
            ville: $("#ville_input").val(),
            pays: $("#pays_select").val(),
            ice: $("#codeice_input").val(),
            codeIf: $("#codeif_input").val(),
            telephone: $("#telephone_input").val(),
            gsm: $("#gsm_input").val(),
            fax: $("#fax_input").val(),
            email: $("#email_input").val(),
            web: $("#siteweb_input").val(),
            reglement: $("#conditions_select").val(),
            note: $("#note_textarea").val(),
            text1: $("#text1_input").val(),
            text2: $("#text2_input").val(),
            text3: $("#text3_input").val(),
            dateCreation: $("#datecreation_input").val(),
            categorie: $("#categorie_select").val(),
            suivi: $("#suivipar_select").val(),
            recouvreur: $("#recouvreur_input").val(),
            activite: $('option:selected', $("#activite_select")).attr('data-text'),
            region: $('option:selected', $("#region_select")).attr('data-text'),
            origine: $("#origine_select").val(),
            devise: $("#devise_select").val(),
            compteTiers: $("#comptetiers_input").val(),
            compteComptable: $("#comptecomptable_input").val(),
            charge: $('input[name=clientdouteux_check]').is(':checked') ? '1' : '0'
        },
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            table.ajax.reload();
            op = 'add';
            id = 0;
            alertify.success("Opération réussie");
        },
        error: function (data) {
            alert(JSON.stringify(data));
            alertify.error("Opération annulée");
        }
    });
});

$(document).on('click', '.delete', function () {
    var id = $(this).val();
    alertify.confirm("Voulez vous vraiment supprimer ce fournisseur?", function (asc) {
        if (asc) {
            $.ajax({
                url: "../../../controller/FournisseurController.php",
                type: 'POST',
                async: true,
                data: {
                    id: id,
                    op: "delete"
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    table.ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alertify.error("Opération annulée");
                }
            });
            alertify.success("Fournisseur supprimé");
        } else {
            alertify.error("Opération annulée");
        }
    }, function (ev) {
        ev.preventDefault();
        alertify.error("Opération annulée");
    });
});


$(document).on('click', '.update', function () {
    id = $(this).val();
    $(".section2").show();
    $(".section1").hide();
    $.ajax({
        url: "../../../controller/FournisseurController.php",
        type: 'POST',
        async: true,
        dataType: 'json',
        data: {
            id: id,
            op: "update"
        },
        success: function (data, textStatus, jqXHR) {
            console.log(data.type);
            if (data.type == "Particulier") {
                $('input:radio[name="customRadio"]').filter('[value="Particulier"]').prop('checked', true);
                $("#societe_section").hide();
                $("#personne_section").show();
                $("#nom_input").val(data.nom);
                $("#prenom_input").val(data.prenom);
                $("#civilite_select").val(data.civilite);
            } else {
                $('input:radio[name="customRadio"]').filter('[value="Société"]').prop('checked', true);
                $("#personne_section").hide();
                $("#societe_section").show();
                $("#noms_input").val(data.nom);
            }
            if (data.adresse !== null) {
                $adresse = data.adresse.split('&');
                $("#adresse1_input").val($adresse[0]);
                $("#adresse2_input").val($adresse[1]);
            }
            $("#conditions_select").val(data.reglement);
            $("#categorie_select").val(data.categorie);
            $("#codeice_input").val(data.ice);
            $("#codeif_input").val(data.codeIf);
            $("#telephone_input").val(data.telephone);
            $("#gsm_input").val(data.gsm);
            $("#fax_input").val(data.fax);
            $("#email_input").val(data.email);
            $("#siteweb_input").val(data.web);
            $("#note_textarea").val(data.note);
            $("#pays_select").val(data.pays);
            $("#suivipar_select").val(data.suivi);
            $("#text1_input").val(data.text1);
            $("#text2_input").val(data.text2);
            $("#text3_input").val(data.text3);
            $("#plafond_input").val(data.plafond);
            $("#plafondimpayé_input").val(data.plafondEmpye);
            $("#cp_input").val(data.cp);
            $("#ville_input").val(data.ville);
            $("#datecreation_input").val(data.dateCreation);
            $("#comptetiers_input").val(data.compteTiers);
            $("#comptecomptable_input").val(data.compteComptable);
            $("#recouvreur_input").val(data.recouvreur);
            $('#region_select option[data-text="' + data.region + '"]').attr('selected', 'selected');
            $('#activite_select option[data-text="' + data.activite + '"]').attr('selected', 'selected');
            $("#origine_select").val(data.origine);

            if (data.douteux == '1') {
                $('input[name=clientdouteux_check]').prop('checked', true);
            } else {
                $('input[name=clientdouteux_check]').prop('checked', false);
            }
            op = 'newUpdate';
        },
        error: function (data) {
            console.log(JSON.stringify(data));
        }
    });

});