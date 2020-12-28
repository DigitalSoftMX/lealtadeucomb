@extends('app')

@section('htmlheader_title')
   Asignación de Roles
@endsection

@section('main-content')
   <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
          <div class="col-lg-12">
             <div class="ibox float-e-margins">
             	<div class="ibox-content p-md">
             	    <div class="ibox-title">
                      <h5>Administración de usuarios<small>  Asignacion de Roles</small></h5>
                      <div class="ibox-tools">
                       </div>
                    </div>
                   
                   <div class="table-responsive">
                   	  <table id="table2" class="table table-bordered table-striped">
			                <thead>
			                    <tr>
			                        <th>Nombre Usuario</th>
			                        <th>Rol</th>
			                        <th class="text-center">Acción</th>
			                    </tr>
			                </thead>
			                <tbody>
			                  
			                      @foreach($user as $u)
			                        <tr>
			                           {!!  Form::open(array('url'=>'user_Role/add', 'method' => 'POST', 'files' => true))  !!}
			                            <td> {{ $u->username }} 
			                                 <input name="id" value="{{ $u->id }}" type="hidden" /></td>
			                            <td>
			                               <select name="rol" class="form-control">
			                                    @foreach($roles as $key => $r)
			                                     <?php $sel = ''; ?>
			                                      @foreach($u->roles as $rl)
			                                        @if($rl->name == $r )
			                                          <?php $sel = 'selected'; ?>
			                                       @endif
			                                      @endforeach  
			                                        <option value="{{ $key }}" {{$sel}}>{{ $r }}</option>

			                                    @endforeach 
			                                </select>
			                            </td>
			                            <th class="text-center">
			                                {!! Form::submit('Asignar', array('class'=>'btn btn-sm btn-info')) !!} 
			                            </th>
			                            {!! Form::close() !!}
			                        </tr>
			                      @endforeach  
			                   
			                </tbody>
			                <tfoot>
			                    <tr>
			                        <th>Nombre Usuario</th>
			                        <th>Rol</th>
			                        <th class="text-center">Acción</th>
			                    </tr>
			                </tfoot>
			            </table>
                   </div>
             	</div>
             </div>
          </div>
      </div>    
   </div>
@stop
@section('localscripts')
  <script src="{{  URL::asset('js/DataTables/jquery.dataTables.js') }}" type="text/javascript"></script>
  <script src="{{  URL::asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript">
  </script>
  <script type="text/javascript">
        $(document).ready(function() {
            $('#table2').dataTable({
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": true
            });
        });
  </script>
@stop