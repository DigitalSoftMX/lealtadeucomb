@extends('app')
<!-- DigitalSoft 2018
    oest System Gemma  -->
    
@section('htmlheader_title')
   Roles
@endsection

@section('main-content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
              <div class="ibox float-e-margins">
                  <div class="ibox-content p-md">
                      <div class="ibox-title">
                         <h5>Lista de Roles <small></small></h5>
                         <div class="ibox-tools">
                         </div>
                      </div>
                      @if($roles->count())
                      <div class="table-responsive ">
                          <table id="mainTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Clave</th>
                                        <th class="text-right">Aregar</th>
                                    </tr>
                                </thead>
                                @if(isset($roles))
                                <tbody>
                                    @foreach($roles as $rol)
                                    <tr>
                                        <td>{{ $rol->name }}</td>
                                        <td>{{ $rol->display_name }}</td>
                                        <td class="text-right" >
                                            <a href="roles/{{ $rol->id }}/edit" >
                                            <div class="tooltip-demo">
                                           <button class="btn btn-outline btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=""> <i class="fa fa-arrows-h"></i></button>
                                           </div>
                                           </a>
                                        </td>
                                        <!--<td class="text-right" >
                                            <a href="roles/{{ $rol->id }}/delete" >
                                            <div class="tooltip-demo">
                                           <button class="btn btn-outline btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title=""> <i class="fa fa-arrows-h"></i></button>
                                           </div>
                                           </a>
                                        </td>
                                        -->
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                               
                          </table>
                      </div>

                     @else
                          <h3 class="text-center alert alert-info">Registro Vacio !</h3>
                     @endif
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
                                      


                                     {!! Form::open(['url' => ['restore_rol', $value->id], 'method' => 'PUT']) !!}       
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

 <!-- Modal  -->
<!--ModalEditar-->
@foreach($roles as $edit_role)
<div class="modal fade" id="ModalEditar{{$edit_role->id}}" data-id="{{$edit_role->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalEditar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalEditar">Editar Almacén</h4>
      </div>
      <div class="modal-body">
      {!! Form::open(['url' => ['roles', $edit_role->id], 'method' => 'PUT']) !!}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Nombre</label>
                            <input value="{{ $edit_role->name }}" type="text" class="form-control" name="name" >
                        </div>
                        <div class="form-group">
                            <label>Clave</label>
                            <input value="{{ $edit_role->display_name }}" type="text" class="form-control" name="display_name" >
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="description" class="form-control">{{ $edit_role->description }}</textarea>
                        </div>
                        </div>
                      </div>
                    <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ url('roles') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
           {!! Form::close()!!}     
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- Fin de Seccion de Formularios Tipo Modal-->
 <!--   -->

        </div>
 
       
@stop 

@section('localscripts')
    <script type="text/javascript">
            $(document).on('ready', function(){
               rol_id = null;
               $('#select-permisos').multiSelect({
                   selectableHeader: "<div class='custom-header'>Permisos no asignados</div>",
                   selectionHeader: "<div class='custom-header'>Permisos asignados</div>",
                   afterSelect:function(value){
                        $.ajax({
                            url : '{{ URL::to("/permisos/asignar") }}',
                            type : 'GET',
                            dataType: 'json',
                            data : {permission_id: value[0], role_id: rol_id}
                        }).done(function(data){
                            console.log(data);
                        });
                   },
                   afterDeselect:function(value){
                        $.ajax({
                            url : '{{ URL::to("/permisos/desasignar") }}',
                            type : 'GET',
                            dataType: 'json',
                            data : {permission_id: value[0], role_id: rol_id}
                        }).done(function(data){
                            console.log(data);
                        });
                   }
               });
                
                
                $('.get-permisos').on('click', function(){
                    rol_id = $(this).attr('rol_id');
                    $.ajax({
                        url : '{{ URL::to("/permisos") }}',
                        type : 'GET',
                        dataType: 'json',
                        data : {id: rol_id}
                    }).done(function(data){
                        $.each(data.permisosAsignados ,function(index, value){
                            $('#select-permisos option[value="'+value.id+'"]').attr('selected', true);
                        });
                        $('#select-permisos').multiSelect('refresh');
                    });
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


@stop