@extends('app')
<!-- dCubica 2016
    RM-Control de Acceso  -->
@section('main-content')
   <div class="wrapper wrapper-content animated fadeInRight">

{!! Form::open(array('url'=>'rolepermission/edit', 'method' => 'POST')) !!}
                      
                            <div class="form-group">
                             <div class="input-group">
                                <span class="input-group-addon form-button button-add-perm"><span class="glyphicon glyphicon-plus-sign add-input"></span></span>
                                {!!Form::select('permission_id', $permissions_value, null, array('class' => 'form-control permission-select'))!!}
                             </div>
                             <span class="text-danger">{{$errors->first('permissions')}}</span>
                             {!!Form::hidden('role_id', $role->id)!!}
                             {{-- add permission operation --}}
                             {!!Form::hidden('operation', 1)!!}
                           </div>
                           <div class="form-group">
                             @if(count($asignados) < 0)
                             <span class="text-danger"><h5>No existen permisos.</h5></span>
                             @endif
                           </div>
                    
                        {!!Form::close()!!}
                            @foreach($asignados as $permission)
                            {!! Form::open(array('url'=>'rolepermission/delete', 'method' => 'POST')) !!}
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon form-button button-del-perm" name="{{$permission->name}}"><span class="glyphicon glyphicon-minus-sign add-input"></span></span>
                                        {!!Form::text('permission_desc', $permission->display_name, ['class' => 'form-control', 'readonly' => 'readonly'])!!}
                                        {!!Form::hidden('permission_id', $permission->id)!!}
                                        {!!Form::hidden('role_id', $role->id)!!}
                                        {{-- add permission operation --}}
                                        {!!Form::hidden('operation', 0)!!}
                                    </div>
                                </div>
                                {!!Form::close()!!}
                            @endforeach
  

   </div>
@stop
@section('localscripts')
<script>
    $(".button-add-perm").click( function(){
        <?php if($role->exists): ?>
        $('.form-add-perm').submit();
        <?php endif; ?>
    });
    $(".button-del-perm").click( function(){
        name = $(this).attr('name');
        $('form[name='+name+']').submit();
    });
</script>
@stop