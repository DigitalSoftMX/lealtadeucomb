@extends('layouts.app', ['activePage' => 'fullscreen_maps', 'menuParent' => 'maps', 'titlePage' => __('Full Screen Map')])

@section('content')
  <div id="map"> </div>
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('js')
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    demo.initGoogleMaps();
  });

 function vistas(filter){
  
 // alert(filter);
    $.ajax({
    data: {"clave" : filter},
    type: "GET",
    dataType: "json",
    url: "../public/selectcarmaps",
    success: function (data) {
            var item = [];
            for (var i = 0, max = data.data.length; i < max; i++) {
                var result = data.data[i].message;
                var count = data.data[i].count;
            }
            if(result == "error"){
                alert("Ya fue ingresado al carrito");  
            }
            else{
               $('#count').text(count); 
                alert("Se guardo con exito");
            }
          }
    }).fail( function( jqXHR, textStatus, errorThrown ) {

  if (jqXHR.status === 0) {

    alert('Not connect: Verify Network.');

  } else if (jqXHR.status == 404) {

    alert('Requested page not found [404]');

  } else if (jqXHR.status == 500) {

    alert('Internal Server Error [500].');

  } else if (textStatus === 'parsererror') {

    alert('Requested JSON parse failed.');

  } else if (textStatus === 'timeout') {

    alert('Time out error.');

  } else if (textStatus === 'abort') {

    alert('Ajax request aborted.');

  } else {

    //alert('Uncaught Error: ' + jqXHR.responseText);
      alert('Error necesita iniciar sesion');

  }
});
};


</script>
@endpush