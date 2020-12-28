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
                        <h4 class="card-title">Timbres</h4>
                        {{-- <h4 class="card-title">{{$catalog->getName()}}</h4> --}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('negocio',$estacion[0]->id)}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-6">
                                    <h4>Datos de la estacion</h4>
                                <label for="">Nombre de la estacion</label>
                                <input class="form-control" name="nEstacion" placeholder="0" type="text" value="{{$estacion[0]->nombre}}" required />
                                <label for="">Numero de la estacion</label>
                                <input class="form-control" name="nNumero" placeholder="0" type="text" value="{{$estacion[0]->numero}}" required/>
                                <label for="">Direccion de la estacion</label>
                                <input class="form-control" name="nDireccion" placeholder="0" type="text" value="{{$estacion[0]->direccion}}" required/>
                                <label for="">Telefono de la estacion</label>
                                <input class="form-control" name="nTelefono" placeholder="0" type="text" value="{{$estacion[0]->telefono}}" required/>

                                <h4>Datos de la factura emisor</h4>
                                <label for="">Nombre</label>
                                <input class="form-control" name="emNombre" placeholder="0" type="text" required/>
                                <label for="">RFC</label>
                                <input class="form-control" name="emRFC" placeholder="0" type="text" required/>
                                <label for="">Regimen fiscal</label>
                                <input class="form-control" name="emRegimenF" placeholder="0" type="text" required/>
                                <label for="">Direccion fiscal</label>
                                <input class="form-control" name="emDireccion" placeholder="0" type="text" required/>
                                <label for="">Codigo Postal</label>
                                <input class="form-control" name="nCp" placeholder="0" type="text" required/>
                                <label for="">Correo</label>
                                <input class="form-control" name="emEmail" placeholder="0" type="text" required/>
                                <label for="">Archivo .key</label>
                                <input type="file" class="form-control" name="fileKey" required>
                                <label for="">Archivo .cer</label>
                                <input type="file" class="form-control" name="fileCer" required>
                                
                                <label for="">Archivo Constancia de Situacion</label>
                                <input type="file" class="form-control" name="consituacion" required>
                                <label for="">Avreviacion del Producto Diesel</label>
                                <input class="form-control" name="avredescripcion1" placeholder="0" type="text" required/>
                                <label for="">Descripcion del Producto Diesel</label>
                                <input class="form-control" name="descripcion1" placeholder="0" type="text" required/>
                                <label for="">Avreviacion del Producto Premium</label>
                                <input class="form-control" name="avredescripcion2" placeholder="0" type="text" required/>
                                <label for="">Descripcion del Producto Premium</label>
                                <input class="form-control" name="descripcion2" placeholder="0" type="text" required/>
                                <label for="">Avreviacion del Producto Magna</label>
                                <input class="form-control" name="avredescripcion3" placeholder="0" type="text" required/>
                                <label for="">Descripcion del Producto Magna</label>
                                <input class="form-control" name="descripcion3" placeholder="0" type="text" required/>
                                </div>
                                <div class="col-6">
                                    <h4>Seleccione el precio</h4>
                                    @foreach ($precios as $precio)
                                     <label class="radio-inline">
                                        <input type="radio" name="timbres" value="{{$precio->id}}" required >${{$precio->costo}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Timbres:{{$precio->num_ticket}} </label>
                                        </br>
                                    @endforeach
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
