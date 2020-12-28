@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

@section('content')
<div class="content">
    <div class="container-fluid">
        
                
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="card-body">
                      <h4 class="card-title" style="color:black">Lealtad</h4>
                    </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title font-weight-bold">Litros vendidos</p>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$litros}}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title font-weight-bold">Usuarios registrados</p>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$usuarios}}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title font-weight-bold">Estaciones registradas</p>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$totalEstaciones}}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title font-weight-bold">Vales entregados</p>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$premio}}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title font-weight-bold">Tickets entregados</p>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$tickets}}</p>
                    </div>
                </div>
            </div>

        
            <div class="col-lg-9 col-md-6 col-sm-12">
                
                <div class="card-header card-header-tabs card-header-primary" style="background:#f8f9fa">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link btn btn-primary" href="#profile" data-toggle="tab" style="background: #1A7B34">
                            Magna
                            <div class="ripple-container"></div>
                          <div class="ripple-container"></div></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn btn-primary active show" href="#messages" data-toggle="tab" style="background: #ED3336">
                            Premium
                            <div class="ripple-container"></div>
                          <div class="ripple-container"></div></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane" id="profile">
                       <div class="card">
                            <div class="card-body">
                                <canvas id="magna" width="100%" height=40%></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active show" id="messages">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="premium" width="100%" height=40%></canvas>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
             
            
            
            </div>
            
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
                     <div class="col-sm-12">
                        <div class="card" style="background:#f8f9fa">
                            <div class="card-body">
                                 <button class="btn btn-sm btn-rose" data-toggle="modal" data-target="#myModal">
                                  Estaciones
                                 <div class="ripple-container"></div>
                                 </button>
                            </div>
                        </div>
                     </div>
        </div>
        
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="card-body">
                      <h4 class="card-title" style="color:black">Litros</h4>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="litros" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="litrosestacion" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
       </div>
       <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="card-body">
                      <h4 class="card-title" style="color:black">Vales</h4>
                    </div>
            </div>
        </div>
       <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="vales" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="valesestacion" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
       </div>
       
    
  </div>
</div>

@include("Catalogos.default.filtros.graficas")

@endsection

@push('js')
<script>

    var ctx = document.getElementById('magna').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Ventas Totales',
                data: @json($timbresEstacionM),
                backgroundColor: [
                'rgb(26,123,52,0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
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
    var ctx = document.getElementById('premium').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Ventas Totales',
                data: @json($timbresEstacionP),
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)'
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
    var ctx = document.getElementById('litros').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($nombreEstacioness),
            datasets: [{
                label: 'Litros',
                data: @json($litrosEstacioness),
                backgroundColor: [
                    'rgb(0, 62, 28, 1)',
                    'rgb(0, 86, 43, 1)',
                    'rgb(0, 105, 55, 1)',
                    'rgb(0, 131, 62, 1)',
                    'rgb(0, 152, 69, 1)',
                    'rgb(0, 173, 60, 1)',
                    'rgb(0, 201, 81, 1)',
                    'rgb(0, 216, 87, 1)'
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

    var ctx = document.getElementById('litrosestacion').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Litros Totales',
                data: @json($timbresEstacionXM),
                backgroundColor: [
                    'rgb(0, 86, 43, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
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
    var ctx = document.getElementById('vales').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($valesnombreEstacioness),
            datasets: [{
                label: 'Vales',
                data: @json($valesEstacioness),
                backgroundColor: [
                    'rgb(0, 62, 28, 1)',
                    'rgb(0, 86, 43, 1)',
                    'rgb(0, 105, 55, 1)',
                    'rgb(0, 131, 62, 1)',
                    'rgb(0, 152, 69, 1)',
                    'rgb(0, 173, 60, 1)',
                    'rgb(0, 201, 81, 1)',
                    'rgb(0, 216, 87, 1)'
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

    var ctx = document.getElementById('valesestacion').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Vales Totales',
                data: @json($valesEstacionXM),
                backgroundColor: [
                    'rgb(0, 152, 69, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
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


<script src="{{ asset('select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/newselect.js') }}"></script>
@endpush
