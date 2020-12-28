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
                        <p class="card-title font-weight-bold">Litros</p>
                        <p class="card-text" style="font-size: 25px; font-weight: bold;">{{$litros}}</p>
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
                    'rgba(255, 99, 132, 0.1)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.1)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.1)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgb(26,123,52, 0.1)',
                    'rgb(44,43,44, 0.2)'
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
                    'rgba(75, 192, 192, 0.2)',
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
                    'rgba(255, 99, 132, 0.1)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.1)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.1)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgb(26,123,52, 0.1)',
                    'rgb(44,43,44, 0.2)'
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
                    'rgba(255, 159, 64, 0.2)',
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