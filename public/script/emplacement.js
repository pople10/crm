$(document).ready(function () {

    //Buttons examples
    var table = $('#datatable-emplacements').DataTable({
        'serverSide':true,
        'processing':true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/EmplacementController.php",
            cache: false,
            data:{op:"datatable"},
            type:'POST'
        },
        /*'createdRow':function(row,_data,index){
            var data = _data[2];
            var cell = '<button type="button" class="update tabledit-edit-button btn btn-sm btn-info" value="' + data + '" style="float: none; margin: 5px;"> <span class="ti-pencil"></span></button><button type="button" value="' + data + '" class="delete tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
            $(row).find('td:last').html(cell);
        }*/
        "columns": [
            {"data": "id"},
            {"data": "nom"},
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
            url: "../../../controller/EmplacementController.php",
            data: {id: id, nom: $("#nom_input").val(), op: op},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                table.ajax.reload();
                op = 'add';
                id = 0;
                alertify.success("Op??ration r??ussie");
            },
            error: function (data) {
                alertify.error("Op??ration annul??e");
            }
        });
    });

    $(document).on('click', '.delete', function () {
        var id = $(this).val();
        alertify.confirm("Voulez vous vraiment supprimer cet emplacement?", function (asc) {
            if (asc) {
                $.ajax({
                    url: "../../../controller/EmplacementController.php",
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
                        alertify.error("Op??ration annul??e");
                    }
                });
                alertify.success("Emplacement supprim??");
            } else {
                alertify.error("Emplacement annul??e");
            }
        }, function (ev) {
            ev.preventDefault();
            alertify.error("Op??ration annul??e");
        });
    });


    $(document).on('click', '.update', function () {
        id = $(this).val();
        $(".section2").show();
        $(".section1").hide();
        $.ajax({
            url: "../../../controller/EmplacementController.php",
            type: 'POST',
            async: true,
            dataType: 'json',
            data: {
                id: id,
                op: "update"
            },
            success: function (data, textStatus, jqXHR) {
                $("#nom_input").val(data.nom);
                op = 'newUpdate';
            },
            error: function (data) {
                console.log(JSON.stringify(data));
            }
        });

    });
});



