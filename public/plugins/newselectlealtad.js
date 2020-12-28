$(document).ready(function () {

    var sex = $("#sex").val();
              $("#password").val('').change();
//Sexo
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectsex",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name});
            }

            $("#sex")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#sex").val([sex]).change();            
         }
    });     
    
    
        var edad = $("#edad").val();

//Edad
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectedad",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name});
            }

            $("#edad")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#edad").val([edad]).change();            
         }
    });
    
      var active = $("#active").val();

//Active
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectactive",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name_active});
            }

            $("#active")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione el estado'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#active").val([active]).change();            
         }
    });
    
    
    var type = $("#id_type").val();

//Tipo
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selecttype",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name_type});
            }

            $("#id_type")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione el estado'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_type").val([type]).change();            
         }
    }); 
    
     
     
       var comes = $("#id_comes").val();

//Proviene
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectcomes",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].db_name});
            }

            $("#id_comes")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione de donde proviene'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_comes").val([comes]).change();            
         }
    }); 

       var status = $("#id_status").val();

//Estatus
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectstatus",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name_status});
            }

            $("#id_status")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione el estatus'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_status").val([status]).change();            
         }
    }); 

     var days_deliver = $("#days_deliver").val();

//Dias a Entregar
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectdays_deliver",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].days_deliver});
            }

            $("#days_deliver")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#days_deliver").val([days_deliver]).change();            
         }
    }); 

  var station = $("#id_station").val();

//Estacion
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectstation",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].estacion});
            }

            $("#id_station")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione la estación'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_station").val([station]).change();            
         }
    }); 

 var faturationUsers = $("#id_users").val();

//Usuarios de facturacion
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectsusersfaturation",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].username});
            }

            $("#id_users")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_users").val([faturationUsers]).change();            
         }
    }); 
    
 
 var Users = $("#id_user").val();

//Usuarios de facturacion
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectsuser",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].username});
            }

            $("#id_user")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_user").val([Users]).change();            
         }
    }); 
    
 
 /*var state = $("#id_state").val();
 
   //Estados
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "http://localhost/gemma/public/selectstate",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name_state});
            }

            $("#id_state")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_state").val([state]).change();            
         }
    });
   */ 

var memberships = $("#qr_memberships").val();

   //Membresias
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectmemberships",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].qr_membership, text: data.data[i].qr_membership});
            }

            $("#qr_memberships")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#qr_memberships").val([memberships]).change();            
         }
    });
    
    
var graphics = $("#id_graphics").val();
    //Graficas
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectsgraphics",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name});
            }

            $("#id_graphics")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_graphics").val([graphics]).change();            
         }
    });
 
 });





