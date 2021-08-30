
var Capitalize = function(text){
    const lower = text.toString().toLowerCase();
    const upper = lower.charAt(0).toUpperCase() + lower.substring(1);
    return upper;
}
function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === parameterName) result = (tmp[1]);
        }
        return result;
    }
getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

$(document).ready(function() {
    document.title = document.title + " - " + $(".page-title:eq(0)").text();
})
$(".wrapper > .container-fluid").css("margin-top",parseFloat($(".navbar-custom").css('height'))/2);
$( window ).resize(function() {
    var height = parseFloat($(".navbar-custom").css('height'));
    $(".wrapper > .container-fluid").css("margin-top",height/2);
});

