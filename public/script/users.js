var table = $('#datatable-users').DataTable({
    "scrollX": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
    },
    "ajax": {
        url: "../../../controller/UserController.php",
        cache: false,
        dataSrc: 'data'
    },
    "columns": [
        {"data": "id"},
        {
            data:null,
            "render": function (data) {
                return data.nom + ' '+ data.prenom;
            }
        },
        {"data": "email"},
        {"data": "telephone"},
        {
            "data": "id",
            "render": function (data) {
                var t = "";
                $.ajax({
                    url: "../../../controller/RoleController.php",
                    cache: false,
                    async:false,
                    type:'POST',
                    data:{op:"findByUserHave",id:data},
                    success: function(result) {
                        if (result.length > 0) {
                            result.forEach(e => {
                                t += '<span class="badge badge-primary" style="margin-right: 2px">'+Capitalize(e.nom)+'</span>';
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr + " - " + status + " - " + error);
                    }
                });

                return t;
            }
        },
        {
            "data": "id",
            "render": function (data) {
                return '<button type="button" class="gerer-role tabledit-edit-button btn btn-sm btn-info" data-toggle="modal" data-animation="bounce" data-target=".roles-modal"  data-id="' + data + '" style="float: none; margin: 5px;"> <span class="ti-settings"></span> Gérer les roles</button><button type="button" class="update tabledit-edit-button btn btn-sm btn-info" value="' + data + '" style="float: none; margin: 5px;"> <span class="ti-pencil"></span></button><button type="button" value="' + data + '" class="delete tabledit-delete-button btn btn-sm btn-info" style="float: none; margin: 5px;"><span class="ti-trash"></span></button>';
            }
        }
    ],
    "columnDefs": [
        { className: "role-section", "targets": [ 4 ] }
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
$("#enregistrer_btn").attr("OP","add");
var id = 0;

$("#enregistrer_btn").click(function () {
    var r = false;var opp =$("#enregistrer_btn").attr("OP");
    if(opp == "add")
    {   
        if($("#email_input").val() == "" || $("#newpassword_input").val() == "" || $("#nom_input").val() == "" || $("#prenom_input").val() == "" ||  $("#telephone_input").val() == "")
            alertify.alert("Vous devez remplir tous les champs");
        else
            r = true;

    } else if (opp =="newUpdate"){
        if($("#email_input").val() == "" || $("#nom_input").val() == "" || $("#prenom_input").val() == "" ||  $("#telephone_input").val() == "")
            alertify.alert("Vous devez remplir les champs : Nom, prenom, email, telephone");
        else if ($("#newpassword_input").val() == "" && $("#oldpassword_input").val() != "")
            alertify.alert("Vous devez remplir le champ nouveau mot de passe");
        else if ($("#newpassword_input").val() != "" && $("#oldpassword_input").val() == "")
            alertify.alert("Vous devez remplir le champ ancien mot de passe");
        else if ($("#newpassword_input").val() != "" && $("#oldpassword_input").val() != ""){
            $.ajax({
                url: "../../../controller/UserController.php",
                type: 'POST',
                cache: false,
                async: false,
                dataType: 'json',
                data: {
                    op: "checkPassword",
                    id: id,
                    password : $("#oldpassword_input").val()
                },
                success: function (data, textStatus, jqXHR) {
                    if(!data)
                        alertify.alert("Mot de passe ancien invalide");
                    else
                        r = true;
                    console.log(data);
                },
                error: function (data) {
                    alert(JSON.stringify(data));
                    alertify.alert("Mot de passe ancien invalide");
                }
            });
        }else
            r = true;
    }

    if(r){
        $.ajax({
            url: "../../../controller/UserController.php",
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: {
                op: opp,
                id: id,
                nom: $("#nom_input").val(),
                prenom: $("#prenom_input").val(),
                email: $("#email_input").val(),
                telephone: $("#telephone_input").val(),
                password : $("#newpassword_input").val()
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                table.ajax.reload();
                opp = 'add';
                $("#enregistrer_btn").attr("OP","add");
                id = 0;
                $("input").val("");
                $(".section2").hide();
                $(".section1").show();
                alertify.success("Opération réussie");
            },
            error: function (data) {
                //alert(JSON.stringify(data));
                alertify.error("Opération annulée");
                if (/Duplicate entry.*for key 'email'/.test(JSON.stringify(data)))
                    alertify.error("Email deja existant.");
            }
        });
    }
});

$(document).on('click', '.delete', function () {
    var id = $(this).val();
    alertify.confirm("Voulez vous vraiment supprimer ce utilisateur?", function (asc) {
        if (asc) {
            $.ajax({
                url: "../../../controller/UserController.php",
                type: 'POST',
                async: true,
                data: {
                    id: id,
                    op: "delete"
                },
                success: function (data, textStatus, jqXHR) {
                    //console.log(data);
                    table.ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alertify.error("Opération annulée");
                }
            });
            alertify.success("Utilisateur supprimé");
        } else {
            alertify.error("Opération annulée");
        }
    }, function (ev) {
        ev.preventDefault();
        alertify.error("Opération annulée");
    });
});


$(document).on('click', '#nouveau_btn', function () {
    op="add";
    $("#nom_input").val("");
    $("#prenom_input").val("");
    $("#email_input").val("");
    $("#telephone_input").val("");
    $("#enregistrer_btn").attr("OP","add");
});

$(document).on('click', '.update', function () {
    id = $(this).val();
    $(".section2").show();
    $(".section1").hide();
    $.ajax({
        url: "../../../controller/UserController.php",
        type: 'POST',
        async: true,
        dataType: 'json',
        data: {
            id: id,
            op: "update"
        },
        success: function (data, textStatus, jqXHR) {
            var d = data;
            $("#nom_input").val(d.nom);
            $("#prenom_input").val(d.prenom);
            $("#email_input").val(d.email);
            $("#telephone_input").val(d.telephone);
            $(".oldpassword").show();
            $("#oldpassword_input").val("");
            $("#newpassword_input").val("");
            op = 'newUpdate';
            $("#enregistrer_btn").attr("OP",op);
            id = d.id;
        },
        error: function (data) {
            console.log(JSON.stringify(data));
        }
    });

});

var fillSelect = function(id) {
    $("#ajouter-role").hide();
    var d = {id:id,op:"findByUserHavent"};
    $.ajax({
        url: "../../../controller/RoleController.php",
        type: 'POST',
        async: false,
        data: d,
        success: function(result) {
            var t = "";
            //console.log(result.data);
            for (var i = 0; i < result.length; i++) {
                var value = result[i].id;
                var text = result[i].nom;

                t += "<option value='" + value + "'>" + text + "</option>";
            }
            $("#role_select").empty();
            $("#role_select").append(t);

            if($("#role_select option:selected").length != 0)
                $("#ajouter-role").show();
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

var fillRolesTable = function(id) {
    $("#currentroles-table").find("tbody").empty();
    $.ajax({
        url: "../../../controller/RoleController.php",
        cache: false,
        type:'POST',
        data:{op:"findByUserHave",id:id},
        success: function(result) {

            if (result.length > 0) {
                var t = "";
                result.forEach(e => {
                    t += "<tr><td>" + Capitalize(e.nom) + "</td><td><button class=\"btn-sm btn-danger supprimer-role\" data-id='"+e.id+"' style=\"height: fit-content;float: right;margin-right: 12%;\">Supprimer</button></td></tr>";
                });

                $("#currentroles-table").find("tbody").empty().append(t);
            }

            $(".supprimer-role").click(function () {
                var user = $("#ajouter-role").attr("data-id");
                var role = $(this).attr("data-id");
                $.ajax({
                    url: "../../../controller/UserRoleController.php",
                    cache: false,
                    type:'POST',
                    data:{op:"delete",user:user,role:role},
                    success: function(result) {
                        fillSelect(user);
                        fillRolesTable(user);
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr + " - " + status + " - " + error);
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
}
$(document).ready(function(){
$('.roles-modal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.attr("data-id");
    fillSelect(id);
    fillRolesTable(id);
    $("#ajouter-role").attr("data-id",id);
});

$("#ajouter-role").click(function () {
    var user = $("#ajouter-role").attr("data-id");
    $.ajax({
        url: "../../../controller/UserRoleController.php",
        cache: false,
        type:'POST',
        data:{op:"add",user:user,role:$("#role_select").val()},
        success: function(result) {
            fillSelect(user);
            fillRolesTable(user);
            table.ajax.reload();
        },
        error: function(xhr, status, error) {
            console.log(xhr + " - " + status + " - " + error);
        }
    });
});
});