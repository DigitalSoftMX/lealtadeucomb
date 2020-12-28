$(document).ready(function () {

//CALLE

    var calle = $("#calle").val();
    $( "#nuevacalle" ).prop( "disabled", true );

    $.ajax({                
        type: "GET",
        dataType: "json",
        url: "http://clusther.digitalsoftlealtad.com/public/selectcalle",               
        success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].calle});
            }

           $("#calle")
            .html('')
            .select2(
                    {
                        placeholder: {
                            id: '-1',
                            text: 'Dirección'
                        },
                        allowClear: true,
                        'data': item
                    }
            )
          
          //  $("#calle").val([calle]).change();            
   
            .on("select2:select", function (e) {
                var select_val = $(e.currentTarget).val();
                if (select_val > 1) {
                  $("#nuevacalle").attr('disabled', true);
                   obtenerlistaalmacen(select_val);
                 }
                 else{
                  $('#nuevacalle').attr('disabled', false);

                   $("#num_ext").val("").change();           
                   $("#num_int").val("").change();           
                   $("#cor_lat").val("").change();           
                   $("#cor_long").val("").change();           
                 
                    $( "#num_ext" ).prop("disabled", false );
                    $( "#num_int" ).prop("disabled", false );
                    $( "#cor_lat" ).prop("disabled", false );
                    $( "#cor_long" ).prop("disabled", false );
                 }

            });        
               
               
         }
    });


function obtenerlistaalmacen(ids) {

    var id = $("#calle").val();
     
    //if(content == null){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "http://clusther.digitalsoftlealtad.com/public/selectdireccion", 
        data: {id: id},              
         success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                item.push({id: data.data[i].id, text: data.data[i].num_ext});
            }

       $("#num_ext").val(data.data[0].num_ext).change();           
       $("#num_int").val(data.data[0].num_int).change();           
       $("#cor_lat").val(data.data[0].cor_lat).change();           
       $("#cor_long").val(data.data[0].cor_long).change();           
     
        $( "#num_ext" ).prop("disabled", true );
        $( "#num_int" ).prop("disabled", true );
        $( "#cor_lat" ).prop("disabled", true );
        $( "#cor_long" ).prop("disabled", true );
      
           //alert(data.data[0].num_ext);
        }
    });
}


 });


