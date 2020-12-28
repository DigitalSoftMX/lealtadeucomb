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
                       
                        <h4 class="card-title">+ Agregar Premios</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('premioadd')}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                 <div class="input-group form-control-lg">
                                    <div class="form-group col-sm-6">
                                      <label for="exampleInput1" class="bmd-label-floating">Nombre</label>
                                      <input type="text" class="form-control" id="exampleInput1" name="name" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                      <label for="exampleInput2" class="bmd-label-floating">Puntos</label>
                                      <input type="text" class="form-control" id="exampleInput2" name="puntos" required>
                                    </div>
                                  </div>
                            </div>
                            <div class="row">
                                 <div class="input-group form-control-lg">
                                    <div class="form-group col-sm-6">
                                      <label for="exampleInput1" class="bmd-label-floating">Valor</label>
                                      <input type="text" class="form-control" id="exampleInput1" name="valor" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                      <input type="text" class="form-control" id="id_status" name="id_status" required>
                                    </div>
                                  </div>
                            </div>
                            
                           <div class="row">
                               <div class="form-group col-sm-6">
                                 <div class="dropdown bootstrap-select col-sm-12 pl-0 pr-0">
                                   <select class="selectpicker col-sm-12 pl-0 pr-0" name="activo" data-style="select-with-transition" title="" data-size="100" tabindex="-98">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                   </select>
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
                                      <span class="fileinput-new">Imagen del premio</span>
                                      <span class="fileinput-exists">Cambiar</span>
                                      <input type="file" name="fileimg" required>
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Borrar</a>
                                  </div>
                                </div>
                              </div>
                      
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                  <button type="button" class="btn btn-primary ml-5" onclick="window.location='{{ url($catalog->getUrlPrefix()) }}'">Regresar</button>
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
<script src="{{ asset('plugins/newselectlealtad.js') }}"></script>

@endpush

