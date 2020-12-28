@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

 <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">

@section('content')
  <div class="content">
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-body">
          <div class='notifications top-right'></div>
            @permission("$ins")
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{$catalog->getUrlPrefix()}}/add" class="btn btn-sm btn-rose">{{ __('Agregar') }}</a>
                  </div>
                </div>
            @endpermission
                        
                <div class="table-responsive">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-rose" style="display:none">
                    <thead class="text-primary">
                      <tr>
                        @foreach ($catalog->field_list as $field)
                        <th>{{$field}}</th>
                        @endforeach
                      </tr>
                    </thead>
                        <tbody>
                        @foreach ($catalog->field_list as $field)
                        <tr>
                            @foreach ($catalog->field_list as $field)
                            <th>{{$field}}</th>
                            @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                    </table>


                 </div>
              
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@include("Catalogos.default.filtros.estadocuenta")


@push('js')
  <script>

   fields = {!! json_encode( array_keys($catalog->field_list) ) !!};
    url_add = '{{$catalog->getUrlPrefix()}}/add/';
    url_delete = '{{$catalog->getUrlPrefix()}}/destroy/';
    url_edit = '{{$catalog->getUrlPrefix()}}/edit/';
    url_ver = '{{$catalog->getUrlPrefix()}}/ver/';
    url_fac = '{{$catalog->getUrlPrefix()}}/fac/';
    columns = [];
    $.each(fields,function(index,value){columns.push({'data':value});});
      

      $('#datatables').fadeIn(1100);
        $('#datatables').DataTable( {
            "processing": true,
            "responsive": true,
            "dom": 'Bfrtip',
            "ajax": "{{$catalog->getUrlPrefix()}}jlist",
            "fnRowCallback": customFnRowCallback,
            "columns": columns,
            "lengthMenu": [
             [10, 25, 50, -1],
             [10, 25, 50, "All"]
            ],
            "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se mostraron resultados",
                "sInfo": "Pagina _PAGE_ de _PAGES_",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sSearch":         "Buscar:",
                "sLoadingRecords": "Cargando...",
                "sProcessing":     "Procesando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Ultimo",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            "columnDefs": [{
                "targets": -1,
                "render": function(data, type, row){ 
                    if('{{$show}}' == ""){  
                      if('{{$catalog->getUrlPrefix()}}' == "countvouchers"){  
                         return data
                        }
                        else{
                        @permission("$mod")
                            return '<a href="'+url_edit+data+'"><span class="material-icons">edit</span></a>'       
                        @endpermission
                        @permission("$eli")
                            + '<a href="#" onClick="warnBeforeRedirect('+data+');"><span class="material-icons">delete</span></a>'    
                        @endpermission
                        @permission("$ver")
                            + '<a href="'+url_ver+data+'"><span class="material-icons">remove_red_eye</span></a>'    
                        @endpermission
                        @permission("$fac")
                            + '<a href="'+url_fac+data+'"><span class="material-icons">notifications_active</span></a>'    
                        @endpermission
                        }
                    }else{            
                        return data
                    }    
                }
            }],
            "buttons": [
                {
                "extend": 'excel',
                "text": 'Excel <span class="material-icons">cloud_download</span>'
            }],
        });  
        function customFnRowCallback( nRow, aData, iDisplayIndex, iDisplayIndexFull )
        { 
            if('{{$catalog->getUrlPrefix()}}' == "userempresas"){  
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                return nRow;
            }
            
            if('{{$catalog->getUrlPrefix()}}' == "userclient"){  
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                return nRow;
            }
            
            if('{{$catalog->getUrlPrefix()}}' == "empresas"){
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                if(aData['imglogo'] != null){
                    $('td:eq(3)', nRow).html( '<img style="width:145px;height:118px;" src="../storage/app/logos/' + aData['imglogo'] + '" />' );
                }
                return nRow;
            }
            
             if('{{$catalog->getUrlPrefix()}}' == "pagos"){
                 $('td:eq(0)', nRow).html( '$' + aData['pago'] );
                if(aData['autorizado'] == 1){
                    $('td:eq(3)', nRow).html('<span class="badge badge-default" style="background-color:#00bcd4">Generado</span>');
                } 
                else if(aData['autorizado'] == 2){
                    $('td:eq(3)', nRow).html('<span class="badge badge-default" style="background-color:#20cc20">Autorizado</span>');
                }
                else if(aData['autorizado'] == 3){
                    $('td:eq(3)', nRow).html('<span class="badge badge-default" style="background-color:#FF0900">No Autorizado</span>');
                }
                if(aData['archivo'] != null){
                    $('td:eq(2)', nRow).html('<a href="download/'+aData['archivo']+'"><span class="label label-primary">Descargar</span></a>');
                }
                return nRow;
            }
            
             if('{{$catalog->getUrlPrefix()}}' == "catprecios"){
                    $('td:eq(1)', nRow).html( '$' + aData['costo'] );
                    $('td:eq(2)', nRow).html( '' + aData['costo_timbre'] );
                    $('td:eq(3)', nRow).html( '$' + aData['costo_admin'] );
                    $('td:eq(4)', nRow).html( '' + aData['costo_timbre_admin'] );
                    $('td:eq(5)', nRow).html( '$' + aData['ganancia'] );
                return nRow;
            }
        }
        
  </script>

<script>
  
    function FFunction(){

  var values = $("#membresia").val();
  var values1 = $("#min").val();
  var values2 = $("#max").val();
  var url = '{{$catalog->getUrlPrefix()}}';
  var name = $("#nombre").val();
  var app_name = $("#app_name").val();
  var apm_name = $("#apm_name").val();
  var email = $("#email").val();
  var folio = $("#folio").val();
  var parametros = { "membresia" : values,
                     "min" : values1,
                     "max" : values2,
                     "url" : url,
                     "app_name" : app_name,
                     "apm_name" : apm_name,
                     "email" : email,
                     "folio" : folio,
                     "nombre" : name};

    fields = {!! json_encode( array_keys($catalog->field_list) ) !!};
    url_add = '{{$catalog->getUrlPrefix()}}/add/';
    url_delete = '{{$catalog->getUrlPrefix()}}/destroy/';
    url_edit = '{{$catalog->getUrlPrefix()}}/edit/';
    url_ver = '{{$catalog->getUrlPrefix()}}/ver/';
    url_fac = '{{$catalog->getUrlPrefix()}}/fac/';
    columns = [];
    $.each(fields,function(index,value){columns.push({'data':value});});
      

      $('#datatables').fadeIn(1100);
        $('#datatables').DataTable( {
            "processing": true,
            "responsive": true,
            "fnRowCallback": customFnRowCallback,
            "dom": 'Bfrtip',
            "destroy": true, 
            "ajax": {
               "url": '{{$catalog->getUrlPrefix()}}jfilter',
               "type": 'POST',
               "data": parametros,
             },
            "deferRender": true,
            "columns": columns,
            "lengthMenu": [
             [10, 25, 50, -1],
             [10, 25, 50, "All"]
            ],
            "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se mostraron resultados",
                "sInfo": "Pagina _PAGE_ de _PAGES_",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sSearch":         "Buscar:",
                "sLoadingRecords": "Cargando...",
                "sProcessing":     "Procesando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Ultimo",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            "columnDefs": [{
                "targets": -1,
                "render": function(data, type, row){ 
                    if('{{$show}}' == ""){
                        
                          $("#membresia").val('');
                          $("#min").val('');
                          $("#max").val('');
                          $("#nombre").val('');
                          $("#app_name").val('');
                          $("#apm_name").val('');
                          $("#email").val('');
                          $("#folio").val('');
                          $('#myModal').modal('hide');
                          
                      if('{{$catalog->getUrlPrefix()}}' == "pagos"){  
                        @permission("$mod")
                        return '<a href="'+url_edit+data+'"><span class="material-icons">cloud_upload</span></a>'       
                        @endpermission
                        @permission("$eli")
                            + '<a href="#" onClick="warnBeforeRedirect('+data+');" ><span class="material-icons">delete</span></a>'    
                        @endpermission
                        }
                        else{
                        @permission("$mod")
                            return '<a href="'+url_edit+data+'"><span class="material-icons">edit</span></a>'       
                        @endpermission
                        @permission("$eli")
                            + '<a href="#" onClick="warnBeforeRedirect('+data+');" ><span class="material-icons">delete</span></a>'    
                        @endpermission
                        @permission("$ver")
                            + '<a href="'+url_ver+data+'"><span class="material-icons">remove_red_eye</span></a>'    
                        @endpermission
                        @permission("$fac")
                            + '<a href="'+url_fac+data+'"><span class="material-icons">notifications_active</span></a>'    
                        @endpermission
                        }
                    }else{            
                        return data
                    }    
                }
            }],
            "buttons": [
                {
                "extend": 'excel',
                "text": 'Excel <span class="material-icons">cloud_download</span>'
            }],
        });  
        function customFnRowCallback( nRow, aData, iDisplayIndex, iDisplayIndexFull )
        { 
            if('{{$catalog->getUrlPrefix()}}' == "userempresas"){  
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                return nRow;
            }
            
            if('{{$catalog->getUrlPrefix()}}' == "userclient"){  
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                return nRow;
            }
            
            if('{{$catalog->getUrlPrefix()}}' == "empresas"){
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                if(aData['imglogo'] != null){
                    $('td:eq(3)', nRow).html( '<img style="width:145px;height:118px;" src="../storage/app/logos/' + aData['imglogo'] + '" />' );
                }
                return nRow;
            }
            
             if('{{$catalog->getUrlPrefix()}}' == "pagos"){
                 $('td:eq(0)', nRow).html( '$' + aData['pago'] );
                if(aData['autorizado'] == 1){
                    $('td:eq(3)', nRow).html('<span class="badge badge-default" style="background-color:#00bcd4">Generado</span>');
                } 
                else if(aData['autorizado'] == 2){
                    $('td:eq(3)', nRow).html('<span class="badge badge-default" style="background-color:#20cc20">Autorizado</span>');
                }
                else if(aData['autorizado'] == 3){
                    $('td:eq(3)', nRow).html('<span class="badge badge-default" style="background-color:#FF0900">No Autorizado</span>');
                }
                if(aData['archivo'] != null){
                    $('td:eq(2)', nRow).html('<a href="download/'+aData['archivo']+'"><span class="label label-primary">Descargar</span></a>');
                }
                return nRow;
            }
            
             if('{{$catalog->getUrlPrefix()}}' == "catprecios"){
                    $('td:eq(1)', nRow).html( '$' + aData['costo'] );
                    $('td:eq(2)', nRow).html( '' + aData['costo_timbre'] );
                    $('td:eq(3)', nRow).html( '$' + aData['costo_admin'] );
                    $('td:eq(4)', nRow).html( '' + aData['costo_timbre_admin'] );
                    $('td:eq(5)', nRow).html( '$' + aData['ganancia'] );
                return nRow;
            }
            
            if('{{$catalog->getUrlPrefix()}}' == "doblepuntos"){  
                if(aData['active'] == 1 ){ 
                    $('td:eq(0)', nRow).html( '<span class="badge badge-default" style="background-color:#20cc20">Activo</span>'); }
                else{ $('td:eq(0)', nRow).html( '<span class="badge badge-default" style="background-color:#FF0900">Inactivo</span>'); }
                return nRow;
                }  
        }
}
  </script>
    <script>
  function warnBeforeRedirect(data) {

      var url_delete = '{{$catalog->getUrlPrefix()}}/destroy/';
      var linkURL = url_delete+data;
      //console.log(linkURL)

            Swal({
                title: 'Estas seguro?',
                text: "De eliminarlo!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cerrar',
            }).then((result) => {
                if (result.value) {
                    window.location.href = linkURL;
                }
            })

        }
  </script>



@endpush