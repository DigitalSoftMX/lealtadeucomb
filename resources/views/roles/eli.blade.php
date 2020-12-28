@extends('app')
<style>
    .cursor_icon
    {
        cursor: hand !important;
    }
</style>

<!-- Gemma 2018
    oest-Control de Acceso  -->
@section('htmlheader_title')
   Asignación de Permisos
@endsection

@section('main-content')

  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        @if(Session::has('message'))
            <div id="ver_mensajes" class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
         @endif
    	{{-- <form method="post" action="{{ url('roles/update',$role->id) }}"> --}}
    	    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    	    <div class="col-md-12">
              
                    <div class="jumbotron">

                                <h2 class="text-o m-r-xs" >
                                    Administración de usuarios <small>&nbsp;&nbsp;(Asignación de Permisos a Roles)</small>
                                </h2>
                        <ul class="list-unstyled m-t-md">
                            <li>
                                <span class="fa fa-cogs"></span>
                                <label>Nombre del Rol: </label>&nbsp;&nbsp; {{ $role->name }}
                               
                            </li>
                            <li>
                                <span class="fa fa-delicious m-r-xs"></span>
                                <label>Clave: </label>&nbsp;&nbsp;{{ $role->display_name }}
                               
                            </li>
                            <li>
                                <span class="fa fa-file-text-o m-r-xs"></span>
                                <label>Descripcion: </label>&nbsp;&nbsp;{{ $role->description }}
                                
                            </li>
                        </ul>
                    </div>
                    <div class="row">        
                      <div class="col-md-10">
                         <a href="">
                                <a type="submit" href="{{ url('roles') }}" class=" pull-right btn btn-warning btn-flat"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
                          </a>
                       </div>
                         <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-flat form-button button-add-perm cursor_icon"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Guardar</button>
                     </div>
                </div><br> 
    	    </div><br>
    	{{-- </form> --}}
   <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-title">
                            <h5>Catálogos</h5>
                       
                                
                        
                            <div class="ibox-tools">
                                <label><input type="checkbox" name="checkTodos" id="checkTodos" class="i-checks pull-right" />Marcar/Desmarcar Todos</label><br>
                            </div>
                        </div>
                      
                      
                        <div class="ibox-content">
        
                       {!! Form::open(array('url'=>'rolepermission/eli', 'method' => 'POST', 'class' =>'form-add-perm', 'name' => 'f1')) !!}
                       {!!Form::hidden('role_id', $role->id)!!}
                       {!!Form::hidden('operation', 1)!!}
                        
                        @foreach($asignados as $permission)

                             {{ $permission->name }}
                        {!!Form::hidden('permissions_value', $permission->name, ['class' => 'form-control', 'id' => 'permissions_value', 'readonly' => 'readonly'])!!}
                        @if (!in_array("adminM_area-mod", $permissions_value))
                               {{ "dsafaf" }}
                         @endif
                       
                        @endforeach

                        <div class="form-group">
                        <div class="row">
                        <div class="col-md-12">
                        <div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Perfil.</small>
                        <input type="checkbox" name="perfil-sho" value="perfil-sho" id="checkPerfil" class="pull-right"/></div> 
                        <div class="panel-body">
                        <div class="i-checks"><label> <input type="checkbox" name="perfil-mod" @if (!in_array("adminM_perfil-mod", $permissions_value))
                        checked="true" 
                        @endif
                        value="perfil-mod" id="permissions_value" class="checkPerfil"> <i></i>Alta </label>
                        </div>
                        </div>
                        </div>
                        </div>


                        <div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Area</small>
                        <input type="checkbox" name="area-sho" value="area-sho" class="pull-right"/></div>
                        <div class="panel-body">
                        <div class="i-checks"><label> <input type="checkbox" name="area-ins"
                        value="area-ins" id="permissions_value"  class="checkPerfil"> <i></i>Alta </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="area-mod" @if (!in_array("adminM_area-mod", $permissions_value))
                        checked="true" 
                        @endif 
                        id="permissions_value" value="area-mod"  class="checkAlmacen"> <i></i>Modificacón </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="area-eli" 
                        id="permissions_value" value="area-eli"  class="checkAlmacen"> <i></i>Eliminar </label>
                        </div>
                        </div>
                        </div>
                        </div>



                        <div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Prioridad.</small>
                        <input type="checkbox" name="priority-sho" value="priority-sho" class="pull-right"/></div>
                        <div class="panel-body">
                        <div class="i-checks"><label> <input type="checkbox" name="priority-ins"
                        value="priority-ins" id="permissions_value"  class="checkPerfil"> <i></i>Alta </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="priority-mod" 
                        id="permissions_value" value="priority-mod"  class="checkAlmacen"> <i></i>Modificacón </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="priority-eli" 
                        id="permissions_value" value="priority-eli"  class="checkAlmacen"> <i></i>Eliminar </label>
                        </div>
                        </div>
                        </div>
                        </div>



<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Usuario de Area.</small>
                        <input type="checkbox" name="userarea-sho" value="userarea-sho" class="pull-right"/></div>
                        <div class="panel-body">
                        <div class="i-checks"><label> <input type="checkbox" name="userarea-ins"
                        value="userarea-ins" id="permissions_value"  class="checkPerfil"> <i></i>Alta </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="userarea-mod" 
                        id="permissions_value" value="userarea-mod"  class="checkAlmacen"> <i></i>Modificacón </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="userarea-eli" 
                        id="permissions_value" value="userarea-eli"  class="checkAlmacen"> <i></i>Eliminar </label>
                        </div>
                        </div>
                        </div>
                        </div>


<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Clientes.</small>
                        <input type="checkbox" name="userclient-sho" value="userclient-sho" class="pull-right"/></div>
                        <div class="panel-body">
                        <div class="i-checks"><label> <input type="checkbox" name="userclient-ins"
                        value="userclient-ins" id="permissions_value"  class="checkPerfil"> <i></i>Alta </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="userclient-mod" 
                        id="permissions_value" value="userclient-mod"  class="checkAlmacen"> <i></i>Modificacón </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="userclient-eli" 
                        id="permissions_value" value="userclient-eli"  class="checkAlmacen"> <i></i>Eliminar </label>
                        </div>
                        </div>
                        </div>
                        </div>

                

<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Canalizacion.</small>
                        <input type="checkbox" name="ticket-sho" value="ticket-sho" class="pull-right"/></div>
                        <div class="i-checks"><label> <input type="checkbox" name="ticket-mod" 
                        id="permissions_value" value="ticket-mod"  class="checkAlmacen"> <i></i>Modificacón </label>
                        </div>
                        </div>
                        </div>
                        

                       

<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Seguimiento.</small>
                        <input type="checkbox" name="seguimiento-sho" value="seguimiento-sho" class="pull-right"/></div>
                        <div class="panel-body">
                        <div class="i-checks"><label> <input type="checkbox" name="seguimiento-mod" 
                        id="permissions_value" value="seguimiento-mod"  class="checkAlmacen"> <i></i>Modificacón </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="seguimiento-cerrado" 
                        id="permissions_value" value="seguimiento-cerrado"  class="checkAlmacen"> <i></i>Cerrado </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="seguimiento-archivo" 
                        id="permissions_value" value="seguimiento-archivo"  class="checkAlmacen"> <i></i>Archivo </label>
                        </div>
                        <div class="i-checks"><label> <input type="checkbox" name="seguimiento-ver" 
                        id="permissions_value" value="seguimiento-ver"  class="checkAlmacen"> <i></i>Ver </label>
                        </div>
                        </div>
                        </div>
                        </div>

                        
<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Historial.</small>
                        <input type="checkbox" name="historial-sho" value="historial-sho" class="pull-right"/></div>
                        </div>
                        </div>


<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Reporte Administrador.</small>
                        <input type="checkbox" name="reportadmin-sho" value="reportadmin-sho" class="pull-right"/></div>
                        </div>
                        </div>


<div class="col-md-3">
                        <div class="panel panel-primary">
                        <div class="panel-heading"><small>Catálogo de Reporte Usuario.</small>
                        <input type="checkbox" name="report-sho" value="report-sho" class="pull-right"/></div>
                        </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                            
                            </div>
                            </div>
                      {!!Form::close()!!}
                        </div>
                    </div>
                </div>           
        </div>
  </div>
@stop


@section('localscripts')

<script>
    $(document).ready(function() {
      // var permission = $('.checkAlmacen').val();
        $(".button-add-perm").click( function(){
            $('.form-add-perm').submit();
                $('#nuevo').val(1);
        });
 
        $(".button-del-perm").click( function(){
             name = $(this).data('name');
             $('form[name="'+name+'"]').submit();
        });
    });   
</script>

<script>
// Creamos un array vacio
var ElementosClick = new Array();
// Capturamos el click y lo pasamos a una funcion
document.onclick = captura_click;
  
function captura_click(e) {
  
  var HaHechoClick;
  if (e == null) {
   
    HaHechoClick = event.srcElement;
  } else {
   
    HaHechoClick = e.target;
  }
 
  ElementosClick.push(HaHechoClick);
 
 // alert("click");
   $("#ver_mensajes").hide();
  //console.log("Contenido sobre lo que ha hecho click: ");  
}  
</script>
{{-- <script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
         checkboxClass: 'icheckbox_square-green',
         radioClass: 'iradio_square-green',
       });
    });
  </script> --}}

{{--MarcarTodos / DesmarcarTodos--}}  

<script>
$('document').ready(function(){
   $("#checkTodos").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
        var id = $(this).attr("id");
  });
});
</script>
{{----}}


<script>
$('document').ready(function(){
   $("#checkAlmacen").change(function () {
      $(".checkAlmacen").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkDepartamento").change(function () {
      $(".checkDepartamento").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTP").change(function () {
      $(".checkTP").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#UM").change(function () {
      $(".UM").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkPP").change(function () {
      $(".checkPP").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkFP").change(function () {
      $(".checkFP").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkSFP").change(function () {
      $(".checkSFP").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkP").change(function () {
      $(".checkP").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkCP").change(function () {
      $(".checkCP").prop('checked', $(this).prop("checked"));
    
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTPR").change(function () {
      $(".checkTPR").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkProveedor").change(function () {
      $(".checkProveedor").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkArea").change(function () {
      $(".checkArea").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkSubArea").change(function () {
      $(".checkSubArea").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkFamArt").change(function () {
      $(".checkFamArt").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkSubFamArt").change(function () {
      $(".checkSubFamArt").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkCArt").change(function () {
      $(".checkCArt").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkArt").change(function () {
      $(".checkArt").prop('checked', $(this).prop("checked"));
    
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkU").change(function () {
      $(".checkU").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkG").change(function () {
      $(".checkG").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkM").change(function () {
      $(".checkM").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkB").change(function () {
      $(".checkB").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkFormaP").change(function () {
      $(".checkFormaP").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTcr").change(function () {
      $(".checkTcr").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkUc").change(function () {
      $(".checkUc").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkMesero").change(function () {
      $(".checkMesero").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTMesa").change(function () {
      $(".checkTMesa").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkMesa").change(function () {
      $(".checkMesa").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTCliente").change(function () {
      $(".checkTCliente").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkCliente").change(function () {
      $(".checkCliente").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkCiudad").change(function () {
      $(".checkCiudad").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkColonia").change(function () {
      $(".checkColonia").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkEstado").change(function () {
      $(".checkEstado").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkPostal").change(function () {
      $(".checkPostal").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkPais").change(function () {
      $(".checkPais").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkImpuesto").change(function () {
      $(".checkImpuesto").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTImpuesto").change(function () {
      $(".checkTImpuesto").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTCambio").change(function () {
      $(".checkTCambio").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTMI").change(function () {
      $(".checkTMI").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTMPC").change(function () {
      $(".checkTMPC").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkBanquete").change(function () {
      $(".checkBanquete").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTEvento").change(function () {
      $(".checkTEvento").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTPersona").change(function () {
      $(".checkTPersona").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkSalon").change(function () {
      $(".checkSalon").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkCEvento").change(function () {
      $(".checkCEvento").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkTPoliza").change(function () {
      $(".checkTPoliza").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkCCG").change(function () {
      $(".checkCCG").prop('checked', $(this).prop("checked"));
    
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkPuesto").change(function () {
      $(".checkPuesto").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRol").change(function () {
      $(".checkRol").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkFolio").change(function () {
      $(".checkFolio").prop('checked', $(this).prop("checked"));
      alert('entro');
      console.log('Entro');
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkEmpresa").change(function () {
      $(".checkEmpresa").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRPAlmacen").change(function () {
      $(".checkRPAlmacen").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRSAArticulo").change(function () {
      $(".checkRSAArticulo").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRFArticulo").change(function () {
      $(".checkRFArticulo").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRSFArticulo").change(function () {
      $(".checkRSFArticulo").prop('checked', $(this).prop("checked"));
      
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRAPVenta").change(function () {
      $(".checkRAPVenta").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkAFProducto").change(function () {
      $(".checkAFProducto").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRDFProducto").change(function () {
      $(".checkRDFProducto").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRMElaboracion").change(function () {
      $(".checkRMElaboracion").prop('checked', $(this).prop("checked"));
    
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRReceta").change(function () {
      $(".checkRReceta").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
<script>
$('document').ready(function(){
   $("#checkRUArticulo").change(function () {
      $(".checkRUArticulo").prop('checked', $(this).prop("checked"));
     
  });
});
</script>
@stop