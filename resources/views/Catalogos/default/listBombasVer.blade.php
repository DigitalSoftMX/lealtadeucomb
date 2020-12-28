@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

 <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">

@section('content')
<div class="content">
    <div class="container-fluid">
       <!-- <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bombas registradas</h5>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$totalEstaciones}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Timbres solicitados</h5>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Timbres usados</h5>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Precio por timbre</h5>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">₵ 0</p>
                    </div>
                </div>
            </div>
        </div>
        -->
        
        <div class="row">
          <div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://eucomb.lealtaddigitalsoft.mx/empresas" >
                    <i class="material-icons">business</i> {{$empresa }}
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://eucomb.lealtaddigitalsoft.mx/empresas/ver/{{$idsempresa}}" >
                      <i class="material-icons">place</i> Estaciones
                    </a>
                   </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist" style="background:#71BF4F" >
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                      <i class="material-icons">local_gas_station</i> Bombas
                      </a>
                   </li>
                </ul>
              </div>
            </div>
            <!--<div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                      <a rel="tooltip" href="#" class="nav-link" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" role="tablist" onclick="tipo({{$ids}})"> 
                      <i class="material-icons">payment</i> {{ __('Abonar') }}</a>
                  </li>
                </ul>
              </div>
            </div>-->
        </div>    
            
    </br>
        
        
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                              @permission("$ins")
          
                              <div class="col-6 text-left">
                                <h4>Bombas</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a href="https://eucomb.lealtaddigitalsoft.mx/catbombas/add" class="btn btn-sm btn-primary"> <i
                                    class="material-icons">add</i> {{ __('Agregar') }}</a>
                            </div>
                            
                              @endpermission
        
                        </div>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover datatable-rose" style="display:none">
                                <thead class="text-primary">
                                    <tr>
                                        @foreach ($catalog->field_list as $field)
                                            <th style="font-weight: bold;">{{$field}}</th>
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
            <!--<div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</div>
@endsection

@include("Catalogos.default.ver")

@push('js')
  <script>

   fields = {!! json_encode( array_keys($catalog->field_list) ) !!};
    url_add = 'https://eucomb.lealtaddigitalsoft.mx/catbombas/add/';
    url_delete = 'https://eucomb.lealtaddigitalsoft.mx/catbombas/destroy/';
    url_edit = 'https://eucomb.lealtaddigitalsoft.mx/catbombas/edit/';
    url_ver = 'https://eucomb.lealtaddigitalsoft.mx/facturas/ver/';
    columns = [];
    $.each(fields,function(index,value){columns.push({'data':value});});
      

      $('#datatables').fadeIn(1100);
        $('#datatables').DataTable( {
            "processing": true,
            "responsive": true,
            "dom": 'Bfrtip',
            "ajax": 'https://eucomb.lealtaddigitalsoft.mx/catbombasjlistt/{{$ids}}',
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
                        @permission("$mod")
                            return '<a href="'+url_edit+data+'" "><span class="material-icons">edit</span></a> '       
                        @endpermission
                        @permission("$eli")
                            + '<a href="#" onClick="warnBeforeRedirect('+data+');"><span class="material-icons">delete</span></a>'    
                        @endpermission
                        @permission("$ver")
                            + '<a href="'+url_ver+data+'" "><span class="material-icons">remove_red_eye</span></a>'    
                        @endpermission
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
                return nRow;
            }
        }
  </script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($nombreEstaciones),
            datasets: [{
                label: 'Canjes por bombas',
                data: @json($timbres),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                    }
                }],
            }
        }
    });
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
