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
                        <h5 class="card-title">Facturas registradas</h5>
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
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/empresas" >
                    <i class="material-icons">business</i> Empresa
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                          <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/empresas/ver/{{$idempresa}}" >
                          <i class="material-icons">place</i> {{$empresa }}
                          </a>
                   </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                   <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/catestaciones/ver/{{$idsestacion}}">
                     <i class="material-icons">local_gas_station</i> {{ $estacion }}
                   </a>
                 </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist" style="background:#71BF4F">
                  <li class="nav-item">
                   <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                   <i class="material-icons">assignment</i> {{ $nombomba }}
                   </a>
                 </li>
                </ul>
              </div>
            </div>
        </div>    
            
    </br>
    
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
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
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart" width="100%" height=70px></canvas>
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
    url_add = 'https://lealtadeucomb.lealtaddigitalsoft.mx/facturas/add/';
    url_delete = 'https://lealtadeucomb.lealtaddigitalsoft.mx/facturas/destroy/';
    url_edit = 'https://lealtadeucomb.lealtaddigitalsoft.mx/facturas/edit/';
    url_ver = 'https://lealtadeucomb.lealtaddigitalsoft.mx/facturas/ver/';
    columns = [];
    $.each(fields,function(index,value){columns.push({'data':value});});
      

      $('#datatables').fadeIn(1100);
        $('#datatables').DataTable( {
            "processing": true,
            "responsive": true,
            "dom": 'Bfrtip',
            "ajax": 'https://lealtadeucomb.lealtaddigitalsoft.mx/facturasjlistt/{{$ids}}',
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
                        return data
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
                label: 'Facturas por bombas',
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
@endpush
