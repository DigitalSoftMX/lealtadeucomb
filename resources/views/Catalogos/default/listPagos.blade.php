@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

 <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">

@section('content')
<div class="content">
    <div class="container-fluid">
         @if($catalog->getUrlPrefix() == "pagos")
        <div class="row">
          <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist" style="background:#71BF4F">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagos" >
                    <i class="material-icons">calendar_today</i> Generados
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagosautorizados">
                    <i class="material-icons">fact_check</i> Autorizar
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagoshistorial">
                    <i class="material-icons">toc</i> Historial
                    </a>
                  </li>
                </ul>
              </div>
            </div>
        </div>    
        @elseif($catalog->getUrlPrefix() == "pagosautorizados")
        <div class="row">
          <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagos" >
                    <i class="material-icons">calendar_today</i> Generados
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist" style="background:#71BF4F">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagosautorizados">
                    <i class="material-icons">fact_check</i> Autorizar
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagoshistorial">
                    <i class="material-icons">toc</i> Historial
                    </a>
                  </li>
                </ul>
              </div>
            </div>
        </div>    
         @else
        <div class="row">
          <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagos" >
                    <i class="material-icons">calendar_today</i> Generados
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist" >
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagosautorizados">
                    <i class="material-icons">fact_check</i> Autorizar
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist" style="background:#71BF4F">
                  <li class="nav-item">
                    <a class="nav-link" href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagoshistorial">
                    <i class="material-icons">toc</i> Historial
                    </a>
                  </li>
                </ul>
              </div>
            </div>
        </div>    
        @endif
    </br>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                              @permission("$ins")
          
                            <div class="col-6 text-left">
                                <h4>Estaciones</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a href="https://lealtadeucomb.lealtaddigitalsoft.mx/pagos/add" class="btn btn-sm btn-primary"> <i
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
    url_ver = 'pagos/ver/';
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
                      if('{{$catalog->getUrlPrefix()}}' == "pagos"){  
                        return '<a href="'+url_edit+data+'"><span class="material-icons">cloud_upload</span></a>'       
                            + '<a href="#" onClick="warnBeforeRedirect('+data+');" ><span class="material-icons">delete</span></a>'    
                        }
                        else if('{{$catalog->getUrlPrefix()}}' == "pagosautorizados"){  
                        return '<a href="'+url_ver+data+'"><span class="material-icons">edit</span></a>'       
                        }
                        else if('{{$catalog->getUrlPrefix()}}' == "pagoshistorial"){  
                            return data
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
           
             if('{{$catalog->getUrlPrefix()}}' == "pagos" || '{{$catalog->getUrlPrefix()}}' == "pagosautorizados" || '{{$catalog->getUrlPrefix()}}' == "pagoshistorial"){
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
                    $('td:eq(2)', nRow).html('<a href="download/'+aData['archivo']+'"><span class="badge badge-default" style="background-color:#1A7B34">Descargar</span></a>');
                }
                else{
                    $('td:eq(2)', nRow).html('<a href="download/'+aData['archivo']+'"><span class="badge badge-default" style="background-color:#1A7B34">Cargar</span></a>');
                }
                return nRow;
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

