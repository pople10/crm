$(document).ready(function () {
    var redirect = "";
    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        }
        return result;
    }

    if(findGetParameter('redirect') != null && findGetParameter('redirect')!="")
        redirect = "?redirect="+findGetParameter('redirect');
    function login()
    {   $("#login_btn").attr("disabled","true").css("opacity",0.5).html('<div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div>');
        $.ajax({
            url: "controller/LoginController.php",
            data: {
                email: $("#email").val(),
                password: $("#password").val(),
                rememberMe: (document.getElementById("rememberMe").checked==true?"true":"false")
            },
            async: true,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                if (data == '../index.html')
                    alertify.error("Email ou mot de passe incorrect");
                setTimeout(function(){window.location.href = data+redirect;},2000);
            },
            error: function (data) {

            }
        });
    }
    
    $(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        login();  
    }
    });
    
    $("#login_btn").click(function () {
        login();
    });
    $.ajax({
            url: "controller/LoginController.php",
            success: function (data, textStatus, jqXHR) {
                if(data=="exist")
                    {
                        if(findGetParameter('redirect') != null && findGetParameter('redirect')!="")
                            window.location.href = findGetParameter('redirect');
                        else
                            window.location.href = '../public/index.php';
                    }
                else
                {
                    $("#preloader").css("display","none");
                    $("#status").css("display","none");
                }
            },
            error: function (data) {

            }
    });

});

