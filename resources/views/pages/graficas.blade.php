@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

@section('content')
<div class="content">
    <div class="container-fluid">
        
                
        <div class="row">
                     <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                 <h4 class="card-title">Graficas</h4>
                                 <button class="btn btn-sm btn-rose" data-toggle="modal" data-target="#myModal">
                                  Estacion
                                 <div class="ripple-container"></div>
                                 </button>
                            </div>
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
            <!--<div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="timbres" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">-->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="producto" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="sexo" width="100%" height=70px></canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@include("Catalogos.default.filtros.graficas")

@push('js')
<script>
    var ctx = document.getElementById('timbres').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($nombreEstaciones),
            datasets: [{
                label: 'Timbres de Estaciones',
                data: @json($timbresEstacion),
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
    var ctx = document.getElementById('litros').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($nombreEstacioness),
            datasets: [{
                label: 'Litros',
                data: @json($litrosEstacioness),
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
    var ctx = document.getElementById('producto').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Regular', 'Premium', 'Diesel'],
            datasets: [{
                label: 'Productos',
                data: [{{$R}}, {{$P}}, {{$D}}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
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
var ctx = document.getElementById('sexo').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Hombre', 'Mujer'],
        datasets: [{
            label: 'Sexo',
            data: [{{$H}}, {{$M}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<script src="{{ asset('select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/newselect.js') }}"></script>
@endpush
