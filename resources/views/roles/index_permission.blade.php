@extends('app')

@section('htmlheader_title') {{-- Titulo de pestaña de Navegador --}}
    Lista de Permisos
@endsection  {{-- Titulo de pestaña de Navegador --}}

@section('main-content')
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="ibox float-e-margins">
            <div class="ibox-content p-md">
               <div class="ibox-title">  <!--Inicio de Titulo y boton de Crear  --> 
                   <h4> <i class="glyphicon glyphicon-align-justify"></i> Permisos<small></small></h4>
                     <div class="ibox-tools">
                        <a href="<?=URL::to('rolepermission/create');?>">
                              <button class="btn btn-success btn-flat"> <i class="fa fa-plus"></i>&nbsp; Nuevo Permiso</button>
                            </a>
                    </div>
               </div><!--Fin de Titulo y boton de Crear  --> 

           <!-- Inicia Cuerpo  de la Vista -->

                @if($view_permission->count())
                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th >Nombre</th>
                                <th >Clave</th>
                                <th >Descripcion</th>
                                <th class="text-right">Acciones</th>
                                <th ></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($view_permission as $permission)
                                <tr>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->display_name}}</td>
                                    <td>{{$permission->description}}</td>
                                     
                                    <td class="text-right">
                                         <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalEditar{{$permission->id}}" data-id="{{$permission->id}}" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                                    </td>
                                    <td>
                                      {!! Form::open(['url' => ['rolepermission', $permission->id], 'method' => 'DELETE' , 'id'=> "myform"]) !!}                  
                                          <input type="hidden" name="_method" value="DELETE">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <button type="submit" class="btn btn-danger btn-xs" id="btnDelete" data-submit-confirm-text="{{{ trans('¿Desea eliminar el registro?') }}}" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
                                      {!! Form::close()!!}  
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>  
                  </div>            
                @else
                    <h3 class="text-center alert alert-info">Registro Vacio !</h3>
                @endif
           <!-- Fin Cuerpo de la Vista -->
            </div>

            <!-- Inicia Cuerpo de Registros Borrados -->  
            <div class="col-md-12 clearfix"></div>
              @if(count($readSoftdelete) > 0)
              <hr/>
              <div class="col-md-12 clearfix"></div>
              <div class="col-md-4"></div>
              <div class="col-md-4"></div>
              <div class="col-md-4">
                   <br/>
                   <button type="button" class="btn btn-danger btn-flat pull-right" id="view_delete"><i class="fa fa-minus-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Ver Registros Borrados</button>
              </div>
              <div class="col-md-12 ibox-content p-md" id="viewdeletetable" style="display:none">         
                  <table class = "table table-striped table-bordered" >
                      <thead>
                        <tr>
                            <th >Nombre</th>
                            <th >Clave</th>
                            <th >Descripcion</th>
                            <th class="text-right">Acciones</th>
                            <th ></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($readSoftdelete as $value)
                          <tr>
                              
                              <td>{{$value->name}}</td>
                              <td>{{$value->display_name}}</td>
                              <td>{{$value->description}}</td>                        
                              <td><button class="btn btn-info btn-xs" type="button"><i class="fa fa-times"></i></button></td>
                              
                              <td>
                               {!! Form::open(['url' => ['restore_permission', $value->id], 'method' => 'PUT']) !!}       
                                    <button type="submit" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-trash"></i> Reactivar</button>
                                {!! Form::close()!!}   
                                
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>    
              </div>
              @endif
              <!-- Fin Cuerpo de Registros Borrados -->
        </div>
    </div>
        
 </div>
 <!-- Inicio de Seccion de Formularios Tipo Modal-->
 <!--ModalEditar-->
@foreach($view_permission as $edit_permissions)
<div class="modal fade" id="ModalEditar{{$edit_permissions->id}}" data-id="{{$edit_permissions->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalEditar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalEditar">Editar Almacén</h4>
      </div>
      <div class="modal-body">
      {!! Form::open(['url' => ['rolepermission', $edit_permissions->id], 'method' => 'PUT']) !!}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Nombre</label>
                            <input value="{{ $edit_permissions->name }}" type="text" class="form-control" name="name" >
                        </div>
                        <div class="form-group">
                            <label>Clave</label>
                            <input value="{{ $edit_permissions->display_name }}" type="text" class="form-control" name="display_name" >
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="description" class="form-control">{{ $edit_permissions->description }}</textarea>
                        </div>
                        </div>
                      </div>
                    <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ url('roles/index_permission') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
           {!! Form::close()!!}     
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- Fin de Seccion de Formularios Tipo Modal-->
@endsection
@section('localscripts') <!-- Inicio de Seccion de Scrips -->
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
         checkboxClass: 'icheckbox_square-green',
         radioClass: 'iradio_square-green',
       });
    });
  </script>

<script type="text/javascript">
    function view_deletes_register(isShow){
        if(isShow)
        {
          document.getElementById('register_delete').style.display = 'block'
        }
    }
</script>

<script type="text/javascript">
$(function () {
    $("[data-submit-confirm-text]").click(function(e){
        var $el = $(this);
        e.preventDefault();
        var confirmText = $el.attr('data-submit-confirm-text');
        bootbox.confirm(confirmText, function(result) {
            if (result) {
                $el.closest('form').submit();
            }
        });
    });

    $("#view_delete").click(function () {
       $("#viewdeletetable").toggle('2000');  
    });
});
</script>

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