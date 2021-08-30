$(document).ready(function () {
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
        $.ajax({
            url: "controller/CheckLoginController.php",
            async : true,
            success: function (data, textStatus, jqXHR) {
                if(data == "true")
                     {
                        if(findGetParameter('redirect') != null && findGetParameter('redirect')!="")
                            window.location.href = findGetParameter('redirect');
                        else
                            window.location.href = '../public/index.php';
                         return false;
                     }
            },
            error: function (data) {
            
            }
        });
});