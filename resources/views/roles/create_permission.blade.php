@extends('app')
<!-- dCubica 2016
    RM-Control de Acceso  -->

@section('htmlheader_title')
   Creacion de Permisos
@endsection

@section('main-content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-6">
           <div class="ibox-title">
              <h5>Creacion de Permisos <small>Nuevo</small> </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>

            <div class="ibox-content">
              <form method="post" action="{{ url('rolepermission/store')}}" class="form-horizontal">
                 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                 <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" class="form-control" required placeholder="Nombre del Permiso" name="name" />
                </div>
                <div class="form-group">
                  <label>Clave</label>
                  <input type="text" class="form-control" required placeholder="Clave del Permiso" name="display_name"/>
                </div>
                <div class="form-group">
                  <label>Descripccion</label>
                  <input type="text" class="form-control" required placeholder="Descripcion del Permiso" name="description"/>
                </div>

                <div class="row">
                  <div class="form-group">
                    <div class="col-md-offset-8 col-md-10">
                    <a href="<?=URL::to('rolepermission');?>">
                      <button type="button" class="btn btn-sm btn-default">Cancelar</button>
                    </a>
                      <button type="submit" class="btn  btn-sm btn-primary">Crear</button>
                    </div>
                   </div><!--/form-group--> 
                 </div>


              </form>
            </div>
       </div>


    </div>
@stop

@section('localscripts') <!-- Inicio de Seccion de Scrips -->
<!--Alert-->
@if(count($errors))
      <?php $mes = '';?>
      @foreach ($errors->all('<p>:message</p>') as $message)
          <?php $mes .= $message;?>
      @endforeach
       <script>
          $(document).ready(function() {
              setTimeout(function() {
                  toastr.options = {
                      closeButton: true,
                      progressBar: true,
                      showMethod: 'slideDown',
                      positionClass: "toast-top-full-width",
                      timeOut: 4500
                  };
                  toastr.error('', '{!! $mes !!}');

              }, 400);
          });
       </script>
@endif

  @if (Session::has('message'))
  <script>
      $(document).ready(function() {
          setTimeout(function() {
              toastr.options = {
                  closeButton: true,
                  progressBar: true,
                  showMethod: 'slideDown',
                  positionClass: "toast-top-center",
                  timeOut: 4000
              };
              toastr.success('', '{{ Session::get('message') }}');

          }, 400);
      });
    </script>
      
  @endif
@endsection <!-- Fin de Seccion de Scrips -->