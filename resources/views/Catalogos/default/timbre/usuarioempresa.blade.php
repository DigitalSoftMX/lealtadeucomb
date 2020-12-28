@extends('layouts.app', ['activePage' => 'form_wizard', 'menuParent' => 'forms', 'titlePage' => __('Wizard Forms')])

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">
 
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="col-md-8 col-12 mr-auto ml-auto">
      <!--      Wizard container        -->
      <div class="wizard-container">
        <div class="card card-wizard" data-color="rose" id="wizardProfile">
            <form action="{{route('registerempres')}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
             <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
            <div class="card-header text-center">
              <h3 class="card-title">
                Representante
              </h3>
            </div>
            <div class="wizard-navigation">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                    Perfil
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#account" data-toggle="tab" role="tab">
                    Empresa
                  </a>
                </li>
              </ul>
            </div>
            
            <div class="card-body">
              <div class="tab-content">
             
                <div class="tab-pane active" id="about">
                  <div class="row justify-content-center">
                     
                    <div class="col-sm-12">
                        
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Nombre</label>
                          <input type="text" class="form-control" id="exampleInput1" name="name" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput2" class="bmd-label-floating">Apellido Paterno</label>
                          <input type="text" class="form-control" id="exampleInput2" name="app_name" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput3" class="bmd-label-floating">Apellido Materno</label>
                          <input type="text" class="form-control" id="exampleInput3" name="apm_name" required>
                        </div>
                        <div class="form-group col-sm-6">
                         <div class="dropdown bootstrap-select col-sm-12 pl-0 pr-0">
                           <select class="selectpicker col-sm-12 pl-0 pr-0" name="sex" data-style="select-with-transition" title="" data-size="100" tabindex="-98">
                                <option value="H">Hombre</option>
                                <option value="M">Mujer</option>
                           </select>
                         </div>
                        </div>
                      </div>
                      
                        <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput4" class="bmd-label-floating">Contrase&ntilde;a</label>
                          <input type="password" class="form-control" id="exampleInput4" name="password" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput1" class="bmd-label-floating">Correo electr&oacute;nico</label>
                          <input type="email" class="form-control" id="exampleemalil" name="email" required>
                        </div>
                      </div>
                      
                       <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput5" class="bmd-label-floating">Tel&oacute;fono</label>
                          <input type="text" class="form-control" id="exampleInput5" name="telefono" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <div class="togglebutton">
                           <label>
                            <input type="checkbox" checked="" name="activo">
                            <span class="toggle"></span>
                            Activo
                           </label>
                          </div>
                        </div>
                       </div>
                      
                      
                   </div>
                  </div>
                </div>
                
                <div class="tab-pane" id="account">
                  <div class="row justify-content-center">
                    <div class="col-sm-4">
                      <div class="picture-container">
                        <div class="picture">
                          <img src="../../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
                          <input type="file" id="wizard-picture" name="imglogo">
                        </div>
                        <h6 class="description">Cargar Logo de la Empresa</h6>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-6">
                          <label for="exampleInput6" class="bmd-label-floating">Nombre de la empresa</label>
                          <input type="text" class="form-control" id="exampleInput6" name="nombre" required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="exampleInput7" class="bmd-label-floating">Tel&eacute;fono de la empresa</label>
                          <input type="text" class="form-control" id="exampleInput7" name="telefonoempresa" required>
                        </div>
                      </div>
                      
                      <div class="input-group form-control-lg">
                        <div class="form-group col-sm-12">
                          <label for="exampleInput8" class="bmd-label-floating">Direcci&oacute;n</label>
                          <input type="text" class="form-control" id="exampleInput8" name="direccion" required>
                        </div>
                      </div>
                      
            
                   </div>
                  </div>
                </div> 
        
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
@endpush