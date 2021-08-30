$(document).ready(function(){
    $.ajax({
        url: "../../../controller/ClientController.php",
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: {
            op: "BlackListByLimitDate"
        },
        success: function (data, textStatus, jqXHR) {
            
        },
        error: function (xhr,status,error) {
            alertify.alert("Probleme dans le blacage par date limit");
        }
    });
});