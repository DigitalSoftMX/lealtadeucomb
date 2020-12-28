$(document).ready(function () {

 var respuesta = true;
 $.ajax({
    async: false,
    type: "GET",
    dataType: "json",
    url: "../../public/notification/",                      
    success: function(res) {
        respuesta = res;
        //alert(res);
        $("#notificacion").text(res);
     }
 });


});