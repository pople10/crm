findAllRolePrivilege = function(){
    var d = [];
    $.ajax({
        url: "../../../controller/RolePrivilegeController.php",
        data: {op: "findAllRolePrivilege"},
        type: 'POST',
        async:false,
        success: function (data, textStatus, jqXHR) {
            d = data;
        },
        error: function (data) {

        }
    });
    return d;
}
$(document).ready(function () {

    //Buttons examples
    table = $('#datatable-privileges').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/RoleController.php",
            cache: false,
            dataSrc: 'data'
        },
        "columns": [
            {"data": "nom"},
            {
                "data": "id",
                "render": function (data) {
                    var t = '';
                    t+= "<div><input id='p1r"+data+"' p-id='1' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p1r"+data+"' class='ml-2 mr-2'>Contacts</label></div>";
                    t+= "<div><input id='p2r"+data+"' p-id='2' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p2r"+data+"' class='ml-2 mr-2'>Ventes</label></div>";
                    t+= "<div><input id='p3r"+data+"' p-id='3' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p3r"+data+"' class='ml-2 mr-2'>Achats</label></div>";
                    t+= "<div><input id='p4r"+data+"' p-id='4' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p4r"+data+"' class='ml-2 mr-2'>Produits & Services</label></div>";
                    t+= "<div><input id='p5r"+data+"' p-id='5' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p5r"+data+"' class='ml-2 mr-2'>Comptabilité</label></div>";
                    t+= "<div><input id='p6r"+data+"' p-id='6' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p6r"+data+"' class='ml-2 mr-2'>Analyse</label></div>";
                    t+= "<div><input id='p8r"+data+"' p-id='8' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p8r"+data+"' class='ml-2 mr-2'>Statistiques</label></div>";
                    t+= "<div><input id='p7r"+data+"' p-id='7' r-id='"+data+"' type='checkbox' name='check-"+data+"'><label for='p7r"+data+"' class='ml-2 mr-2'>Administration</label></div>";

                    return t;
                }
            }

        ],
        "columnDefs": [
            { className: "flex-section", "targets": [ 1 ] }
        ],
        "drawCallback" : function (settings) {
            var data = findAllRolePrivilege();
            data.forEach((v,i)=>{
                var t = "#p"+data[i].privilege+"r"+data[i].role;
                $(t).prop("checked",true);
            })

            $("input[type='checkbox']").click(function (e) {
                var isChecked = $(this).prop("checked");
                var p_id = $(this).attr("p-id");
                var r_id = $(this).attr("r-id");

                var d = {op: isChecked ? 'add':'delete',privilege:p_id,role:r_id};

                $.ajax({
                    url: "../../../controller/RolePrivilegeController.php",
                    data: d,
                    type: 'POST',
                    async:false,
                    success: function (data, textStatus, jqXHR) {
                        if(!data.data){
                            alertify.error("Echec de faire cette opération");
                            e.preventDefault();
                        }
                    },
                    error: function (data) {
                        alertify.error("Echec de faire cette opération");
                        e.preventDefault();
                    }
                });

            });



        }
    });

    /*new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });

    table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));*/

$(document).on('click', '.delete', function () {
        var id = $(this).val();
        alertify.confirm("Voulez vous vraiment supprimer ce role?", function (asc) {
            if (asc) {
                $.ajax({
                    url: "../../../controller/RoleController.php",
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
                alertify.success("Marque supprimé");
            } else {
                alertify.error("Marque annulée");
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
            url: "../../../controller/RoleController.php",
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



