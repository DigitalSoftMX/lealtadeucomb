 $(document).ready(function () {

     var contrasena = $("#password").val('');

     var sex = $("#sex").val();

     //Sexo
     $.ajax({
         type: "GET",
         dataType: "json",
         url: "../../selectsex",
         success: function (data) {
             var item = [];
             for (var i = 0, max = data.data.length; i < max; i++) {
                 item.push({
                     id: data.data[i].id,
                     text: data.data[i].name
                 });
             }

             $("#sex")
                 .html('')
                 .select2({
                     placeholder: {
                         id: '-1',
                         text: 'Sexo'
                     },
                     allowClear: true,
                     'data': item
                 })
             $("#sex").val([sex]).change();
         }
     });


  var active = $("#activo").val();

//Active
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectactivo",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].name});
            }

            $("#activo")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Estado'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#activo").val([active]).change();            
         }
    });
    
    
     //Empresas

     var empresas = $("#id_empresa").val();

     $.ajax({
         type: "GET",
         dataType: "json",
         url: "../../selectempresa",
         success: function (data) {
             var item = [];
             for (var i = 0, max = data.data.length; i < max; i++) {
                 item.push({
                     id: data.data[i].id,
                     text: data.data[i].nombre
                 });
             }

             $("#id_empresa")
                 .html('')
                 .select2({
                     placeholder: {
                         id: '-1',
                         text: 'Empresas '
                     },
                     allowClear: true,
                     'data': item
                 })
             $("#id_empresa").val([empresas]).change();
         }
     });

//Estaciones

     var estaciones = $("#id_estacion").val();

     $.ajax({
         type: "GET",
         dataType: "json",
         url: "../../selectestacion",
         success: function (data) {
             var item = [];
             for (var i = 0, max = data.data.length; i < max; i++) {
                 item.push({
                     id: data.data[i].id,
                     text: data.data[i].name
                 });
             }

             $("#id_estacion")
                 .html('')
                 .select2({
                     placeholder: {
                         id: '-1',
                         text: 'Estacion '
                     },
                     allowClear: true,
                     'data': item
                 })
             $("#id_estacion").val([estaciones]).change();
         }
     });
     
 //Bomba

     var bomba = $("#id_bomba").val();

     $.ajax({
         type: "GET",
         dataType: "json",
         url: "../../selectbomba",
         success: function (data) {
             var item = [];
             for (var i = 0, max = data.data.length; i < max; i++) {
                 item.push({
                     id: data.data[i].id,
                     text: data.data[i].nombre
                 });
             }

             $("#id_bomba")
                 .html('')
                 .select2({
                     placeholder: {
                         id: '-1',
                         text: 'Bomba '
                     },
                     allowClear: true,
                     'data': item
                 })
             $("#id_bomba").val([bomba]).change();
         }
     });


     var Users = $("#id_user").val();

   //Usuarios
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectuser",
         success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].nombre});
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
    
    
       var precios = $("#id_precio").val();

   //Usuarios
    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "../../selectprecios",
         success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].nombre});
            }

            $("#id_precio")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Seleccione el precio'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
                        $("#id_precio").val([precios]).change();            
         }
    }); 
    
    
 });
