@extends('layouts.app', ['activePage' => 'form_wizard', 'menuParent' => 'forms'])

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">
 
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="col-md-8 col-12 mr-auto ml-auto">
      <!--      Wizard container        -->
      <div class="wizard-container">
        <div class="card card-wizard" data-color="rose" id="wizardProfile">
            <form action="{{route('registerestaciones',$user[0]->id)}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
             <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
            <div class="card-header text-center">
             <!-- <h3 class="card-title">
                Estacion
              </h3>-->
            </div>
            <div class="wizard-navigation">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                    Estaci&oacute;n
                  </a>
                </li>
                <!--<li class="nav-item">
                  <a class="nav-link" href="#account" data-toggle="tab" role="tab">
                    Datos Fiscales
                  </a>
                </li>-->
                <!--<li class="nav-item">
                  <a class="nav-link" href="#pac" data-toggle="tab" role="tab">
                    Datos del Pac
                  </a>
                </li>-->
                <!--<li class="nav-item">
                  <a class="nav-link" href="#facturacion" data-toggle="tab" role="tab">
                    Datos Facturacion
                  </a>
                </li>-->
              </ul>
            </div>
            
            <div class="card-body">
              <div class="tab-content">
             
                <div class="tab-pane active" id="about">
                  <div class="row justify-content-center">
                     
                    <div class="col-sm-12">
                    @foreach ($user as $usuario)
                        
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Nombre</label>
                          <input type="text" class="form-control" id="exampleInput1" name="name" value="{{$usuario->name}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput2" class="bmd-label-floating">N&uacute;mero de Identificaci&oacute;n</label>
                          <input type="text" class="form-control" id="exampleInput2" name="numero" value="{{$usuario->number_station}}" required>
                        </div>
                      </div>
                      
                       <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput5" class="bmd-label-floating">Tel&eacute;fono</label>
                          <input type="text" class="form-control" id="exampleInput5" name="telefono" value="{{$usuario->telefono}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="id_user" class="bmd-label-floating">Empresa</label>
                          <input type="text" class="form-control" id="id_empresa" name="id_empresa" value="{{$usuario->id_empresa}}" required>
                        </div>
                       </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-12">
                          <label for="exampleInput8" class="bmd-label-floating">Direcci&oacute;n</label>
                          <input type="text" class="form-control" id="exampleInput8" name="direccion" value="{{$usuario->address}}" required>
                        </div>
                      </div>
                      
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                            <img src="https://eucomb.lealtaddigitalsoft.mx/public/storage/{{$usuario->name}}.jpg" alt="...">
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="line-height: 14px;width: 125px;"></div>
                          <div>
                            <span class="btn btn-rose btn-round btn-file">
                              <span class="fileinput-new">Imagen</span>
                              <span class="fileinput-exists">Cambiar</span>
                              <input type="file" name="fileimg">
                            </span>
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Borrar</a>
                          </div>
                        </div>
                      
                      
                   </div>
                    @endforeach
                 
                  </div>
                </div>
                
             <!--   <div class="tab-pane" id="account">
                  <div class="row justify-content-center">
                         @foreach ($empr as $datos)
                
                    <div class="col-sm-12">
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput6" class="bmd-label-floating">Nombre Fiscal</label>
                          <input type="text" class="form-control" id="exampleInput6" name="nombre" value="{{$datos->nombre}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput7" class="bmd-label-floating">RFC Fiscal</label>
                          <input type="text" class="form-control" id="exampleInput7" name="rfc" value="{{$datos->rfc}}" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput5" class="bmd-label-floating">Regimen Fiscal</label>
                          <input type="text" class="form-control" id="exampleInput5" name="regimenfiscal" value="{{$datos->regimenfiscal}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput8" class="bmd-label-floating">Direccion Fiscal</label>
                          <input type="text" class="form-control" id="exampleInput8" name="direccion" value="{{$datos->direccionfiscal}}" required>
                        </div>
                      </div>
                    
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Email Fiscal</label>
                          <input type="email" class="form-control" id="exampleemalil" name="emailfiscal"value="{{$datos->emailfiscal}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Codigo Postal</label>
                          <input type="text" class="form-control" id="exampleemalil" name="codigopostal" value="{{$datos->cp}}" required>
                        </div>
                      </div>
                      
                   </div>
                  
                   
                      <div class="col-md-4 col-sm-4">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                            <img src="https://material-dashboard-pro-laravel.creative-tim.com/material/img/image_placeholder.jpg" alt="...">
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="line-height: 14px;width: 125px;"></div>
                          <div>
                            <span class="btn btn-rose btn-round btn-file">
                              <span class="fileinput-new">.Key</span>
                              <span class="fileinput-exists">Cambiar</span>
                              <input type="file" name="fileKey">
                            </span>
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Borrar</a>
                            <a class="nav-link" href="{{ url('downloadkey/' . $user[0]->id) }}" >
                            <p>{{ __('Descargar .KEY') }}</p></a>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-4 col-sm-4">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                            <img src="https://material-dashboard-pro-laravel.creative-tim.com/material/img/image_placeholder.jpg" alt="...">
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="line-height: 14px;width: 125px;"></div>
                          <div>
                            <span class="btn btn-rose btn-round btn-file">
                              <span class="fileinput-new">.Cer</span>
                              <span class="fileinput-exists">Cambiar</span>
                              <input type="file" name="fileCer">
                            </span>
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Borrar</a>
                            <a class="nav-link" href="{{ url('downloadcer/' . $user[0]->id) }}" >
                            <p>{{ __('Descargar .CER') }}</p></a>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-4 col-sm-4">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                            <img src="https://material-dashboard-pro-laravel.creative-tim.com/material/img/image_placeholder.jpg" alt="...">
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="line-height: 14px;width: 125px;"></div>
                          <div>
                            <span class="btn btn-rose btn-file">
                              <span class="fileinput-new">Constancia</span>
                              <span class="fileinput-exists">Cambiar</span>
                              <input type="file" name="consituacion">
                            </span>
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                            <a class="nav-link" href="{{ url('downloadconsituacion/' . $user[0]->id) }}" >
                            <p>{{ __('Descargar Constancia de Situacion') }}</p></a>
                          </div>
                        </div>
                      </div>
             
                  </div>
                
                </div> -->
                
                <!--   <div class="tab-pane" id="pac">
                  <div class="row justify-content-center">
                     
                    <div class="col-sm-12">
                        
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="cuentaInput1" class="bmd-label-floating">Cuenta</label>
                          <input type="text" class="form-control" id="cuentaInput1" name="cuenta" value="{{$datos->cuenta}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="cuentaInput2" class="bmd-label-floating">Contraseña</label>
                          <input type="text" class="form-control" id="cuentaInput2" name="pass" value="{{$datos->pass}}" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="ceuntaInput3" class="bmd-label-floating">Usuario</label>
                          <input type="text" class="form-control" id="cuentaInput3" name="user" value="{{$datos->user}}" required>
                        </div>
                      </div>
                      
                   </div>
                  </div>
                </div>-->
                
                
               <!--   <div class="tab-pane" id="facturacion">
                  <div class="row justify-content-center">
                     
                    <div class="col-sm-12">
                        
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Abreviacion del producto Diesel</label>
                          <input type="text" class="form-control" id="exampleInput1" name="avredescripcion1" value="{{$datos->avredescripcion1}}" required>
                        </div>
                    <!--    <div class="form-group col-sm-6">
                          <label for="exampleInput2" class="bmd-label-floating">Descripcion del producto Diesel</label>
                          <input type="text" class="form-control" id="exampleInput2" name="descripcion1" value="{{$datos->descripcion1}}" required>
                        </div>-->
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Abreviacion del producto Regular</label>
                          <input type="text" class="form-control" id="exampleInput1" name="avredescripcion2" value="{{$datos->avredescripcion2}}" required>
                        </div>
                        <!--<div class="form-group col-sm-6">
                          <label for="exampleInput2" class="bmd-label-floating">Descripcion del producto Premium</label>
                          <input type="text" class="form-control" id="exampleInput2" name="descripcion2" value="{{$datos->descripcion2}}" required>
                        </div>-->
                      </div>
                
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Abreviacion del producto Supreme</label>
                          <input type="text" class="form-control" id="exampleInput1" name="avredescripcion3" value="{{$datos->avredescripcion3}}" required>
                        </div>
                        <!--<div class="form-group col-sm-6">
                          <label for="exampleInput2" class="bmd-label-floating">Descripcion del producto Magna</label>
                          <input type="text" class="form-control" id="exampleInput2" name="descripcion3" value="{{$datos->descripcion3}}" required>
                        </div>-->
                      </div>
                        @endforeach
               
                      
                   </div>
                  </div>
                </div>-->
              
        
              </div>
            </div>
            <div class="card-footer">
              <div class="mr-auto">
                <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Anterior">
              </div>
              <div class="ml-auto">
                <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Siguiente">
                <button type="button" class="btn btn-primary pull-left ml-5" onclick="window.location='{{ url($catalog->getUrlPrefix()) }}'">Cerrar</button>
                <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="Guardar" style="display: none;">
              </div>
              
              <div class="clearfix"></div>
            </div>
          </form>
        </div>
      </div>
      <!-- wizard container -->
    </div>
  </div>
</div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Initialise the wizard
      demo.initMaterialWizard();
      setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 600);
    });
  </script>
<script src="{{ asset('select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/newselect.js') }}"></script>

@endpush
