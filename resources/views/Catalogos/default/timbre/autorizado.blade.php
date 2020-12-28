@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">
 
@section('content')
<div class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <h2 class="card-title">Timbres Solicitados</h2>
                        {{-- <h4 class="card-title">{{$catalog->getName()}}</h4> --}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('pago',$estacion[0]->id)}}" autocomplete="off" class="form-horizontal" method="post">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-6">
                                    <h3>Datos del pago</h3>
                                    <h4>Pago: ${{$estacion[0]->pago}}</h4>
                                    <input name="pago" type="hidden" value="{{$estacion[0]->pago}}"/>
                                    <h4>Timbres: {{$estacion[0]->num_timbres}}</h4>
                                    <input name="timbres" type="hidden" value="{{$estacion[0]->num_timbres}}"/>
                                    <h4>Estacion: {{$estacion[0]->estacion}}</h4>
                                    <input name="estacion" type="hidden" value="{{$estacion[0]->id_estacion}}"/>
                                    <h4>Empresa {{$estacion[0]->empresa}}</h4>
                                    <input name="nTelefono" type="hidden" value="{{$estacion[0]->id_empresa}}"/>

                                    <h3>Datos del Emisor</h3>
                                    <h4>Nombre: {{$facturaEmisor[0]->nombre}}</h4>
                                    <input name="emNombre" type="hidden" value="{{$facturaEmisor[0]->nombre}}"/>
                                    <h4 for="">RFC: {{$facturaEmisor[0]->rfc}}</h4>
                                    <input name="emRFC" type="hidden" value="{{$facturaEmisor[0]->rfc}}"/>
                                    <h4 for="">Regimen fiscal: {{$facturaEmisor[0]->regimenfiscal}}</h4>
                                    <input name="emRegimenF" type="hidden" value="{{$facturaEmisor[0]->regimenfiscal}}"/>
                                    <h4>Direccion fiscal: {{$facturaEmisor[0]->direccionfiscal}}</h4>
                                    <input name="emDireccion" type="hidden" value="{{$facturaEmisor[0]->direccionfiscal}}"/>
                                    <h4 for="">Correo: {{$facturaEmisor[0]->emailfiscal}}</h4>
                                    <input name="emEmail" type="hidden" value="{{$facturaEmisor[0]->emailfiscal}}"/>
                            
                                </div>
                                <div class="col-6">
                                    <h4>Seleccione la autorizacion</h4>
                                    <input type="radio" name="auto" value="2">
                                    <label for="costo">Autorizado</label><br>
                                    <input type="radio" name="auto" value="3">
                                    <label for="costo">No autorizado</label> 
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
