@extends('layouts.app', ['activePage' => 'form_wizard', 'menuParent' => 'forms', 'titlePage' => __('Wizard Forms')])

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">
 
@section('content')
<div class="content">
    
    
    @section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <form action="{{route('registerclientedit',$user[0]->id)}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
           <div class="card-header text-left">
              <h5 class="card-title" style="color:#1A7B34">
                <i class="material-icons" style="color:#1A7B34">record_voice_over</i>&nbsp;&nbsp;Informaci&oacute;n Personal
              </h5>
           </div>
                @foreach ($user as $usuario)
                
                    <div class="input-group form-control-lg">
                        <div class="form-group col-sm-8">
                          <label for="exampleInput1" class="bmd-label-floating">Nombre</label>
                          <input type="text" class="form-control" id="exampleInput1" name="name" value="{{$usuario->name}}" required>
                        </div>
                        <div class="form-group col-sm-8">
                          <label for="exampleInput2" class="bmd-label-floating">Apellido Paterno</label>
                          <input type="text" class="form-control" id="exampleInput2" name="app_name" value="{{$usuario->first_surname}}" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-8">
                          <label for="exampleInput3" class="bmd-label-floating">Apellido Materno</label>
                          <input type="text" class="form-control" id="exampleInput3" name="apm_name" value="{{$usuario->second_surname}}" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-4">
                         <div class="dropdown bootstrap-select col-sm-12 pl-0 pr-0">
                           <select class="selectpicker col-sm-12 pl-0 pr-0" name="sex" data-style="select-with-transition" title="" data-size="100" tabindex="-98">
                                 @if($usuario->sex == "H")
                                <option value="H">Hombre</option>
                                <option value="M">Mujer</option>
                                @else
                                <option value="M">Mujer</option>
                                <option value="H">Hombre</option>
                                @endif
                           </select>
                         </div>
                        </div>
                        <div class="form-group col-sm-4">
                         <div class="dropdown bootstrap-select col-sm-12 pl-0 pr-0">
                           <select class="selectpicker col-sm-12 pl-0 pr-0" name="activo" data-style="select-with-transition" title="" data-size="100" tabindex="-98">
                                 @if($usuario->active == "1")
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                                @else
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                                @endif
                           </select>
                         </div>
                        </div>
                      </div>
                      
                        <div class="input-group form-control-lg">
                        <div class="form-group col-sm-8">
                          <label for="exampleInput4" class="bmd-label-floating">Contrase&ntilde;a</label>
                          <input type="password" class="form-control" id="exampleInput4" name="password">
                        </div>
                        <div class="form-group col-sm-8">
                          <label for="exampleInput1" class="bmd-label-floating">Correo electr&oacute;nico</label>
                          <input type="email" class="form-control" id="exampleemalil" name="email" value="{{$usuario->email}}" required>
                        </div>
                      </div>
                      
                       <div class="input-group form-control-lg">
                        <div class="form-group col-sm-8">
                          <label for="exampleInput5" class="bmd-label-floating">Tel&eacute;fono</label>
                          <input type="text" class="form-control" id="exampleInput5" name="telefono" value="{{$usuario->phone}}" required>
                        </div>
                       </div>
                 @endforeach
               
            
             <!--  <div class="card-header text-left">
              <h5 class="card-title" style="color:#1A7B34">
                <i class="material-icons" style="color:#1A7B34">assignment</i>&nbsp;&nbsp; Datos de Facturacion
              </h5>
            </div>  
            -->
               @foreach ($empr as $empresa)
             
             <div class="input-group form-control-lg">
                        <div class="form-group col-sm-8">
                          <label for="exampleInput6" class="bmd-label-floating">Nombre Fiscal</label>
                          <input type="text" class="form-control" id="exampleInput6" name="nombre" value="{{$empresa->nombre}}" required>
                        </div>
                        <div class="form-group col-sm-8">
                          <label for="exampleInput7" class="bmd-label-floating">RFC Fiscal</label>
                          <input type="text" class="form-control" id="exampleInput7" name="rfc" value="{{$empresa->rfc}}" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                            <div class="form-group col-sm-8">
                          <label for="exampleInput1" class="bmd-label-floating">Correo electr&oacute;nico Fiscal</label>
                          <input type="email" class="form-control" id="exampleemalil" name="emailfiscal" value="{{$empresa->emailfiscal}}" required>
                        </div>
                       <div class="form-group col-sm-8">
                         <div class="dropdown bootstrap-select col-sm-12 pl-0 pr-0">
                           <select class="selectpicker col-sm-12 pl-0 pr-0" name="usocfdi" data-style="select-with-transition" title="" data-size="100" tabindex="-98">
                                  @if($empresa->usocfdi == "G01")
                                <option value="G01">G01 Adquisicion de mercancias</option>
                                <option value="G03">G03 Gastos en general</option>
                                @elseif($empresa->usocfdi == "G02")
                                <option value="G02">G02 Devoluciones, descuentos o bonificaciones</option>
                                <option value="G01">G01 Adquisicion de mercancias</option>
                                <option value="G02">G02 Devoluciones, descuentos o bonificaciones</option>
                                <option value="G03">G03 Gastos en general</option>
                                @else
                                <option value="G03">G03 Gastos en general</option>
                                <option value="G01">G01 Adquisicion de mercancias</option>
                                <option value="G03">G03 Gastos en general</option>
                                @endif
                           </select>
                         </div>
                        </div>
                      </div>
                @endforeach
             
           
          </div>
             <div class="card-footer">
              <div class="ml-auto">
                <button type="button" class="btn btn-primary pull-left ml-5" onclick="window.location='{{ url($catalog->getUrlPrefix()) }}'">Cancelar</button>
                <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="Guardar">
              </div>
              <div class="clearfix"></div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-profile">
          <div>
              </br>
              <img src="https://eucomb.lealtaddigitalsoft.mx/public/img/usuarioimg/{{ $membresia[0]->number_usuario}}.jpg" width="40%" />
          </div>
          <div class="card-body">
            <h4 class="card-title" style="color:#1A7B34">Membres&iacute;a</h4>
            <p class="card-description" style="color:#1A7B34">
             {{ $membresia[0]->number_usuario}}
            </p>
            <h4 class="card-title" style="color:#1A7B34">Puntos acumulados</h4>
            <p class="card-description" style="color:#1A7B34">
             {{ $membresia[0]->totals}}
            </p>
            <h4 class="card-title" style="color:#1A7B34">Total de visitas</h4>
            <p class="card-description" style="color:#1A7B34">
               {{ $membresia[0]->visits}}
            </p>
            <h4 class="card-title" style="color:#1A7B34">Total de Canjes</h4>
            <p class="card-description" style="color:#1A7B34">
               {{ $membresia[0]->total}}
            </p>
            <h4 class="card-title" style="color:#1A7B34">Total en el Historial</h4>
            <p class="card-description" style="color:#1A7B34">
               {{ $membresia[0]->totalhistory}}
            </p>
            <h4 class="card-title" style="color:#1A7B34">Fecha</h4>
            <p class="card-description" style="color:#1A7B34">
               {{ $membresia[0]->todate}}
            </p>
          </div>
              <!-- <h4 class="card-title" style="color:#1A7B34">Estado de Cuenta</h4>-->
           <div class="card-footer">
              <div class="card-body">
                     <a class="btn btn-primary btn-round" href="https://eucomb.lealtaddigitalsoft.mx/userclient/ver/{{$user[0]->id}}">Estado de Cuenta</a>
               <!-- <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#myModal">
                    Vale
                  <div class="ripple-container"></div>
                </button>-->
              </div>
              <!--<div class="ml-auto">
                <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#myModal">
                    Premios
                  <div class="ripple-container"></div>
                </button>
              </div>
              <div class="clearfix"></div>-->
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>
</div>
@endsection

@include("Catalogos.default.filtros.canjes")

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
<script src="{{ asset('plugins/newselectlealtad.js') }}"></script>

@endpush

