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
                        <div class="card-icon">
                          <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title">Facturas</h4>
                        {{-- <h4 class="card-title">{{$catalog->getName()}}</h4> --}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('factura',$factura->id)}}" autocomplete="off" class="form-horizontal" method="post">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-6">
                                    <h3>Datos de la factura</h3>
                                    <h4>Serie: {{$factura->serie}}</h4>
                                    <input name="serie" type="hidden" value="{{$factura->serie}}"/>
                                    <h4>Fecha: {{$factura->fecha}}</h4>
                                    <input name="fecha" type="hidden" value="{{$factura->fecha}}"/>
                                    <h4>Sello: {{$factura->sello}}</h4>
                                    <input name="sello" type="hidden" value="{{$factura->sello}}"/>
                                    <h4>Forma de pago: {{$factura->formapago}}</h4>
                                    <input name="formapago" type="hidden" value="{{$factura->formapago}}"/>
                                    <h4>Numero de certificado: {{$factura->nocertificado}}</h4>
                                    <input name="nocertificado" type="hidden" value="{{$factura->nocertificado}}"/>
                                    <h4>Certificado: {{$factura->certificado}}</h4>
                                    <input name="certificado" type="hidden" value="{{$factura->certificado}}"/>
                                    <h4>Subtotal: {{$factura->subtotal}}</h4>
                                    <input name="subtotal" type="hidden" value="{{$factura->subtotal}}"/>
                                    <h4>Descuento: {{$factura->descuento}}</h4>
                                    <input name="descuento" type="hidden" value="{{$factura->descuento}}"/>
                                    <h4>Moneda: {{$factura->moneda}}</h4>
                                    <input name="moneda" type="hidden" value="{{$factura->moneda}}"/>
                                    <h4>Tipo de cambio: {{$factura->tipocambio}}</h4>
                                    <input name="tipocambio" type="hidden" value="{{$factura->tipocambio}}"/>
                                    <h4>Total: {{$factura->total}}</h4>
                                    <input name="total" type="hidden" value="{{$factura->total}}"/>
                                    <h4>Tipo de combrobante: {{$factura->tipocombrobante}}</h4>
                                    <input name="tipocomprobante" type="hidden" value="{{$factura->tipocombrobante}}"/>
                                    <h4>Metodo de pago: {{$factura->metodopago}}</h4>
                                    <input name="metodopago" type="hidden" value="{{$factura->metodopago}}"/>
                                    <h4>Lugar de expedicion: {{$factura->lugarexpedicion}}</h4>
                                    <input name="lugarexpedicion" type="hidden" value="{{$factura->lugarexpedicion}}"/>
                                    <h4>Emisor: {{$factura->id_emisor}}</h4>
                                    <input name="emisor" type="hidden" value="{{$factura->id_emisor}}"/>
                                    <h4>Receptor: {{$factura->id_receptor}}</h4>
                                    <input name="receptor" type="hidden" value="{{$factura->id_receptor}}"/>
                                    <h4>Uso cfdi: {{$factura->usocfdi}}</h4>
                                    <input name="usocfdi" type="hidden" value="{{$factura->usocfdi}}"/>
                                    <h4>Clave pro serv: {{$factura->Claveproserv}}</h4>
                                    <input name="claveproserv" type="hidden" value="{{$factura->Claveproserv}}"/>
                                    <h4>Numero interno: {{$factura->nointerno}}</h4>
                                    <input name="nointerno" type="hidden" value="{{$factura->nointerno}}"/>
                                    <h4>Cantidad: {{$factura->cantidad}}</h4>
                                    <input name="cantidad" type="hidden" value="{{$factura->cantidad}}"/>
                                    <h4>Clave unidad: {{$factura->claveunidad}}</h4>
                                    <input name="claveunidad" type="hidden" value="{{$factura->claveunidad}}"/>
                                    <h4>Descripcion: {{$factura->descripcion}}</h4>
                                    <input name="descripcion" type="hidden" value="{{$factura->descripcion}}"/>
                                    <h4>Importe: {{$factura->importe}}</h4>
                                    <input name="importe" type="hidden" value="{{$factura->importe}}"/>
                                    <h4>Descuento D: {{$factura->descuentoD}}</h4>
                                    <input name="descuentod" type="hidden" value="{{$factura->descuentoD}}"/>
                                    <h4>Estacion: {{$factura->id_estacion}}</h4>
                                    <input name="estacion" type="hidden" value="{{$factura->id_estacion}}"/>
                                    <h4>Bomba: {{$factura->id_bomba}}</h4>
                                    <input name="bomba" type="hidden" value="{{$factura->id_bomba}}"/>
                                    <h4>Archivo xml: {{$factura->archivoxml}}</h4>
                                    <input name="archivoxml" type="hidden" value="{{$factura->archivoxml}}"/>
                                    <h4>Archivo pdf: {{$factura->archivopdf}}</h4>
                                    <input name="archivopdf" type="hidden" value="{{$factura->archivopdf}}"/>
                                    <h4>Estatus: {{$factura->estatus}}</h4>
                                    <input name="estatus" type="hidden" value="{{$factura->estatus}}"/>

                                </div>
                                <div class="col-6">
                                    
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
