$(document).ready(function () {
    load();
    function load() {
        $("#famille_select").empty()
                .append('<option selected="selected" value="">Choisir</option>');
        $.ajax({
            url: "../../../controller/FamilleController.php",
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                for (i = 0; i < data.length; i++) {
                    $("#famille_select").append('<option value ="' + data[i].id + '">' + data[i].nom + '</option>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    }

    //Buttons examples
    var table = $('#datatable-familles').DataTable({
        'serverSide':true,
        'processing':true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/FamilleController.php",
            cache: false,
            data:{op:'datatable'},
            type:'POST'
        }/*,
        'createdRow':function(row,_data,index){
            var data = _data[2];
            var cell = '<button type="button" class="update tabledit-edit-button btn btn-sm btn-info" value="' + data + '" style="float: none; margin: 5px;"> <span class="ti-pencil"></span></button><button type="button" value="' + data + '" class="delete tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
            $(row).find('td:last').html(cell);
        }*/,
        "columns": [
            {"data": "nom"},
            {"data": "name"},
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
            url: "../../../controller/FamilleController.php",
            data: {op: op, id: id, nom: $("#nom_input").val(), famille: $("#famille_select").val()},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                table.ajax.reload();
                load();
            },
            error: function (data) {
                console.log(JSON.stringify(data));
            }
        });
    });


    $(document).on('click', '.delete', function () {
        var id = $(this).val();
        alertify.confirm("Voulez vous vraiment supprimer cette famille?", function (asc) {
            if (asc) {
                $.ajax({
                    url: "../../../controller/FamilleController.php",
                    type: 'POST',
                    async: true,
                    data: {
                        id: id,
                        op: "delete"
                    },
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);
                        table.ajax.reload();
                        load();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alertify.error("Opération annulée");
                    }
                });
                alertify.success("Famille supprimé");
            } else {
                alertify.error("Famille annulée");
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
            url: "../../../controller/FamilleController.php",
            type: 'POST',
            async: true,
            dataType: 'json',
            data: {
                id: id,
                op: "update"
            },
            success: function (data, textStatus, jqXHR) {
                $("#nom_input").val(data.nom);
                if (data.famille != null)
                    $("#famille_select").val(data.famille);
                else
                    $("#famille_select").val("");
                op = 'newUpdate';
            },
            error: function (data) {
                console.log(JSON.stringify(data));
            }
        });

    });

});