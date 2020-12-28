<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seguridad\RoleRequest;

use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\User;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Ticket;
use App\Models\Catalogos\Cat_Area;
use App\Models\Catalogos\Cat_Priority;
use App\Models\Catalogos\Cat_Status;
use App\Models\Catalogos\Message;
use App\Models\Catalogos\Area_User;
use App\Models\Catalogos\Permission_Role;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function __construct()
    {
        $permisos = Permission::all();
		$this->permisos = $permisos;
    }

     public function index()
	{
		
		$data = array('roles' => Role::orderBy('id')->get(),'readSoftdelete' => Role::onlyTrashed()->get());
		
		return \View::make('roles.role',$data);

	}

	public function userRole()
	{
		//$roles = Role::lists('name', 'id');
        $roles = Role::pluck('name', 'id');
		$user = User::all();
                
        //dd($roles);

		
		return \View::make('roles.roleUser')
							->with('roles', $roles)
							->with('user', $user);
	}

	public function add(Request $request)
	{
       //$user = User::find($request->input('id'));    
      // $user->roles()->attach($request->input('rol'));
		//dd($request->rol);
         $update = Role_User::where('user_id', '=', $request->id)
                            ->update(['role_id' => $request->rol]);
                                          
      
       return redirect()->back();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('roles.create');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RoleRequest $roleRequest)
	{
		// /*$role = new Role();
  //      /* $role->name = Input::get('name');
  //       $role->nomenclature = Input::get('nomenclature');
  //       $role->save();*/

  //       $role->name = Input::get('name');
  //       $role->display_name = Input::get('nomenclature');
  //       $role->description = Input::get('description');
  //       $role->save();
        
  //       return Redirect::to('roles');*/

        $search_role = Role::where('name', '=', \Request::input('name'))->first();

          if (count($search_role) == 0)
          {
             $role = new Role();

              $role->name = \Request::input('name');
              $role->display_name = \Request::input('display_name');
              $role->description = \Request::input('description');

              if($role->save()){
                    return redirect('roles')->with('message', 'Agrego un nuevo permiso.');
            }
          }else{  
                    return redirect('roles/create')->with('message', 'No se permiten duplicados.'); 
       }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Redirect::back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{   
	   	$permisos = \DB::table('permissions')->get();
		$permisosDeRol = \DB::table('permission_role')->where('role_id', '=', $id)->get();
        $asignados = array();
        $asi = $idselect = array();
        $permissions_value = array();
        
        if(empty($permisosDeRol)) { // permisos de los roles -- si esta vacio -- quien tiene derecho al permiso X
        	$permissions_value = \DB::table('permissions')->lists('name', 'id');
        }
        else
        {
	        foreach($permisosDeRol as $p){
			  foreach ($permisos as $value){
	            if($value->id == $p->permission_id){
	                $asignados[] = $value;
	                $asi[] = $value->id;
				}
				else{
					$idselect[] = $value->id;
				}			 
	          }   
	      	}         
	        
	      	$isel = array_unique($idselect, SORT_NUMERIC);  
	      	$isel = explode(',' , implode(',' , array_diff($isel, $asi)));
	         
	       	foreach ($permisos as $value)
	      	{
	      	  for($i=0; $i < sizeof($isel); $i++)
	      	    {
	      	   	    if($value->id == $isel[$i])
	      	   	    {
	                	$permissions_value[$value->id] = $value->display_name;
					}		
	      	    }
	      	} 
        }
        
        foreach ($asignados as $value) {
        	 for ($i=0; $i < sizeof($asignados); $i++) { 
        	   if ($asignados !=1){
        		//dd($asignados);
        	}
          }
        }
       
        $data = array('role' => Role::find($id),
       	              'permissions_value' => $permissions_value, 
        	          'asignados' => $asignados);
       // dd($permissions_value);

        //$rol = Role_User::where('user_id', '=', $id)->value('role_id');
            
/*               $proces = Permission_Role::select('permission_role.permission_id','permission_role.role_id', 'permissions.name')
                         ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                         ->where('permission_role.role_id', '=', $id)
                         ->get();
*/

        return \View::make('roles.edit', $data);

	}

     public function delete()
	{   
          dd("ddidi");
	   	$permisos = \DB::table('permissions')->get();
		$permisosDeRol = \DB::table('permission_role')->where('role_id', '=', $id)->get();
        $asignados = array();
        $asi = $idselect = array();
        $permissions_value = array();
        
        if(empty($permisosDeRol)) { // permisos de los roles -- si esta vacio -- quien tiene derecho al permiso X
        	$permissions_value = \DB::table('permissions')->lists('name', 'id');
        }
        else
        {
	        foreach($permisosDeRol as $p){
			  foreach ($permisos as $value){
	            if($value->id == $p->permission_id){
	                $asignados[] = $value;
	                $asi[] = $value->id;
				}
				else{
					$idselect[] = $value->id;
				}			 
	          }   
	      	}         
	        
	      	$isel = array_unique($idselect, SORT_NUMERIC);  
	      	$isel = explode(',' , implode(',' , array_diff($isel, $asi)));
	         
	       	foreach ($permisos as $value)
	      	{
	      	  for($i=0; $i < sizeof($isel); $i++)
	      	    {
	      	   	    if($value->id == $isel[$i])
	      	   	    {
	                	$permissions_value[$value->id] = $value->display_name;
					}		
	      	    }
	      	} 
        }
        
        foreach ($asignados as $value) {
        	 for ($i=0; $i < sizeof($asignados); $i++) { 
        	   if ($asignados !=1){
        		//dd($asignados);
        	}
          }
        }
       
        $data = array('role' => Role::find($id),
       	              'permissions_value' => $permissions_value, 
        	          'asignados' => $asignados);
		   return \View::make('roles.edit', $data);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RoleRequest $roleRequest, $id)
	{
		/*$role = Role::find($id);
        $role->name = Input::get('name');
        $role->display_name = Input::get('nomenclature');
        $role->description = Input::get('description');
        $role->save();
        return Redirect::to('roles');*/
        
	    
         $update_role = Role::findOrFail($id);
       
	     $update_role->name = $roleRequest->input('name');
	     $update_role->display_name = $roleRequest->input('display_name');
	     $update_role->description = $roleRequest->input('description');
	     //dd($update_role);

	      $update_role->save();

          return Redirect::to('roles')->with('message', 'Se actualizo el registro.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
        $delete_role = Role::find($id)->delete();
        return Redirect::to('roles')->with('message', '¡Registro eliminado!');
	}

	public function restore($id)
    {     
          Role::withTrashed()->find($id)->restore();
          return redirect()->back();
    }

	
}
