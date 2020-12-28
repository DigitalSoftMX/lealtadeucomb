@extends('layouts.app', ['activePage' => 'form_regular', 'menuParent' => 'forms', 'titlePage' => __('Regular Forms')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card-header text-center">
                <h3 class="card-title">
                    Reportes de Vigilantes PDF
                </h3>
            </div> 

            <!-- Inicio de elemento -->
            <div class="card ">
            <div class="card-body ">
              <div class="tab-content tab-space">
                <!-- primer metodo del panel-->
                <div class="tab-pane  active show" id="link1">
              
     <form class="form" method="POST" action="{{ url("reporte") }}"> 
                          @csrf              
                                 
    <div class="row">
      <div class="col-md-6">
        <div class="card ">
          <div class="card-header card-header-rose card-header-text">
            <div class="card-icon">
              <i class="material-icons">today</i>
            </div>
            <h4 class="card-title">Fecha de Inicio</h4>
          </div>
          <div class="card-body ">
            <div class="form-group bmd-form-group is-filled">
              <input type="text" name="fech_inicio" class="form-control datepicker" data-date-format="YYYY/MM/DD">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card ">
          <div class="card-header card-header-rose card-header-text">
            <div class="card-icon">
              <i class="material-icons">library_books</i>
            </div>
            <h4 class="card-title">Fecha Final</h4>
          </div>
          <div class="card-body ">
            <div class="form-group bmd-form-group is-filled">
              <input type="text" name="fech_final" class="form-control datepicker" data-date-format="YYYY/MM/DD">
            </div>
          </div>
        </div>
      </div>
      
                  <label class="col-sm-2 col-form-label">Vigilantes</label>
                  <div class="col-sm-8">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" type="text" name="id_vigilante" id="id_vigilante" required="true" aria-required="true">
                    </div>
                  </div>
    </div>
    
    
    
    
                </div>
               
            

                            <div class="row justify-content-center">
                                <button type="submit" class="btn btn-fill btn-rose">Guardar</button>
                            </div>
                               </form>
             
                        </div>
                    </div>
                </div>
                <!-- fin de cuarto elemento -->

            </div>
        </div>
    </div>
@endsection

@push('js')
  <script>
       $(document).ready(function() {
      // initialise Datetimepicker and Sliders
      md.initFormExtendedDatetimepickers();
    });
  </script>
    <script src="{{ asset('select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/newselect.js') }}"></script>

@endpush
