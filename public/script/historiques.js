$(document).ready(() => {
    table = $('#datatable-produits').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        "ajax": {
            url: "../../../controller/HistoriqueActionController.php",
            cache: false,
            dataSrc: 'data',
            data:{},
            type:"POST"
        },
        "columns": [
            { "data": "date" },
            { "data": "username" },
            { "data": "action" },
            {
                "data" : null,
                "render" : function (data) {
                    return '<button data-id="' + data.id + '" data-type="'+data.type+'" data-toggle="modal" data-animation="bounce" data-target=".action-modal" type="button" class="btn btn-sm btn-success" style="float: none; margin: 5px;"><span class="fas fa-archive"></span> Details</button>';
                }
            }
        ],
        "ordering": false
    });
    //console.log(table);
    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    });

    table.buttons().container()
        .appendTo($('.datatable-btns', table.table().container()));

    $('.action-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.attr("data-id");
        var data = $.grep(table.ajax.json().data, function(v,i){
            return v.id == id;
        })[0];
        console.log(data);
        var date = data.date;
        var nom = data.username;

        $(".date_modal").html("<span class='badge badge-primary'>" + date + "</span> " + data.action);
        $(".user_modal").text(" par " + nom);

        $('#table1 thead').hide();
        $('#table1 tbody').text('');
        if(data.type == "update"){
            $('#table1 thead').show();
            var old = JSON.parse(data.old);
            var nnew = JSON.parse(data.new);

            jQuery.each(old,function (i,v) {
                if(i.toString() != "id")
                    $("#table1 tbody").append("<tr><th width='100'>"+i+"</th><td>"+v+"</td><td>"+nnew[i.toString()]+"</td></tr>");
            })
        }else{
            var d = data.type == 'add' ? JSON.parse(data.new) : JSON.parse(data.old);
            jQuery.each(d,function (i,v) {
                if(i.toString() != "id")
                    $("#table1 tbody").append("<tr><th width='100'>"+i+"</th><td>"+v+"</td></tr>");
            })
        }

    });
})