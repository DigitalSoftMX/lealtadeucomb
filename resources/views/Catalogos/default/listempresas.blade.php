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
                            return '<a href="'+url_ver+data+'"><span class="material-icons">remove_red_eye</span></a>'    
                        
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
                    $('td:eq(5)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(5)', nRow).html( 'Inactivo' );
                }
                return nRow;
            }
            
            if('{{$catalog->getUrlPrefix()}}' == "empresas"){
                if(aData['activo'] == 1){
                    $('td:eq(6)', nRow).html( 'Activo' );
                }else{
                    $('td:eq(6)', nRow).html( 'Inactivo' );
                }
                /*if(aData['imglogo'] != null){
                    $('td:eq(3)', nRow).html( '<img style="width:145px;height:118px;" src="../storage/app/logos/' + aData['imglogo'] + '" />' );
                }*/
                return nRow;
            }
            
             if('{{$catalog->getUrlPrefix()}}' == "pagos"){
                 $('td:eq(0)', nRow).html( '$' + aData['pago'] );
                if(aData['autorizado'] == 1){
                    $('td:eq(3)', nRow).html( 'Generado' );
                } 
                else if(aData['autorizado'] == 2){
                    $('td:eq(3)', nRow).html( 'Autorizado' );
                }
                else if(aData['autorizado'] == 3){
                    $('td:eq(3)', nRow).html( 'No Autorizado' );
                }
                if(aData['archivo'] != null){
                    $('td:eq(2)', nRow).html('<a href="download/'+aData['archivo']+'"><span class="label label-primary">Descargar</span></a>');
                }
                return nRow;
            }
            
             if('{{$catalog->getUrlPrefix()}}' == "catprecios"){
                    $('td:eq(1)', nRow).html( '$' + aData['costo'] );
                return nRow;
            }
        }
        
  </script>



@endpush
