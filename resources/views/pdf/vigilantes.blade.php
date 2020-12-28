
<link href="{{ asset('material') }}/css/pdf.css" rel="stylesheet" />
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reporte de Vigilante</title>
</head>
<body>
<header class="clearfix">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    
</header>

<main>
    



<div class="container">
  <div class="row">
    <div class="col-md-10 ml-auto mr-auto">
      <div class="card card-signup">
        <h2 class="card-title text-center"></h2>
        <div class="card-body">
          <div class="row">
            
            <div class="col-md-12 mr-auto">
             

            <div class="row">
                <div class="col-md-9">
                    <div class="ibox">
                        <div class="ibox-content">


                    <div class="ibox">
            
                    @forelse($products as $row)
            
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <tbody>
                                    <tr>
                                        <td width="90">
                                            <div class="cart-product-imitation">
                                              <img class="img" src='../storage/app/public/{{ $row->img }}.jpg' width="250px">
                                            </div>
                                        </td>
                                        <td class="desc">
                                            <h5>
                                              {{ $row->usuario }}  
                                            </h5>
                                            <dl class="small m-b-none">
                                                <dt>{{ $row->estacion }}</dt>
                                                <dt>{{ $row->hor_inicio }}</dt>
                                                <dt>{{ $row->hor_final }}</dt>
                                            </dl>
                                        </td>
                                        <td class="desc">
                                            <h5>
                                              Ubicacion  
                                            </h5>
                                            <dl class="small m-b-none">
                                                <dd>{{ $row->longitud  }}</dd>
                                                <dd>{{ $row->latitud  }}</dd>
                                          </dl>
                                        </td>
                                        <td class="desc">
                                            <h5>
                                              Fecha y hora de registro   
                                            </h5>
                                            <dl class="small m-b-none">
                                                <dt>{{ $row->created_at }}</dt>
                                            </dl>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

         @empty
         </br>
          </br>
          </br>
          <div class="card-header text-center col-md-8">
          <h4>No se encontraron Resultados</h4>
          </div>
         @endforelse
    
    


                        </div>             
                   </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>








            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





</main>
</body>
</html>
