<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seguridad\PermissionRequest;

//use App\Models\Security\Permission;
use App\Models\Security\Role;
use App\Models\Catalogos\Permission;
use App\Models\Catalogos\Permission_Role;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use DB;

class RolePermissionController extends Controller
{
        protected $permisos;
    
    public function  __construct() {
		$permisos = Permission::all();

		$this->permisos = $permisos;
	}


	public function index()
	{
	   // return Response::json($this->getPermisos(Input::get('id')));
       $view_permission = Permission::orderBy('id', 'asc')->paginate(10);
       $readSoftdelete = Permission::onlyTrashed()->get();
      // dd($view_permission);   
       return \View::make('roles/index_permission')->with('view_permission', $view_permission)->with('readSoftdelete', $readSoftdelete);
	}


	private function permisos($id_rol){
        $permisos = array();

        $permisos['permisosAsignados'] = $this->getPermisosAsignados($id_rol);
        return $permisos;
    }    


    private function getPermisosAsignados($id_rol){
        $permisosDeRol = Permission::where('role_id', '=', $id_rol)->get();
        $asignados = array();
        foreach($permisosDeRol as $p){
		    foreach ($this->permisos as $key => $value){
                if($value->id == $p->permission_id){
                	$asignados[] = $value;
			 	}
          	}   
        }   
        return $asignados;
	}    


    public function asignar(Request $request){
      
        //dd(\Request::all());
        //PERFIL
        if(\Request::input('perfil-sho') != ""){
           if(\Request::input('perfil-sho') != ""){
              $names = ("adminM_".\Request::input('perfil-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
            if(\Request::input('perfil-mod') != ""){
              $names = ("adminM_".\Request::input('perfil-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);               
                }            
            }
            else{
              $names = ("adminM_perfil-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
              $names = ("adminM_perfil-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }
        //AREA
       if(\Request::input('area-sho') != ""){
         if(\Request::input('area-sho') != ""){
              $names = ("adminM_".\Request::input('area-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
            if(\Request::input('area-ins') != ""){
              $names = ("adminM_".\Request::input('area-ins')); 
              $idp = Permission::where('name', '=', $names)->value('id');
               $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
               'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_area-ins"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
            if(\Request::input('area-mod') != ""){
              $names = ("adminM_".\Request::input('area-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_area-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
            if(\Request::input('area-eli') != ""){
              $names = ("adminM_".\Request::input('area-eli')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
                  $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_area-eli"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
           $names = ("adminM_area-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

 //PRIORIDAD
       if(\Request::input('priority-sho') != ""){
         if(\Request::input('priority-sho') != ""){
              $names = ("adminM_".\Request::input('priority-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
            if(\Request::input('priority-ins') != ""){
              $names = ("adminM_".\Request::input('priority-ins')); 
              $idp = Permission::where('name', '=', $names)->value('id');
               $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
               'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_priority-ins"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
          
            if(\Request::input('priority-mod') != ""){
              $names = ("adminM_".\Request::input('priority-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_priority-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
            if(\Request::input('priority-eli') != ""){
              $names = ("adminM_".\Request::input('priority-eli')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
                  $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_priority-eli"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
           $names = ("adminM_priority-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

 //USER AREA
       if(\Request::input('userarea-sho') != ""){
         if(\Request::input('userarea-sho') != ""){
              $names = ("adminM_".\Request::input('userarea-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
            if(\Request::input('userarea-ins') != ""){
              $names = ("adminM_".\Request::input('userarea-ins')); 
              $idp = Permission::where('name', '=', $names)->value('id');
               $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
               'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_userarea-ins"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
          
            if(\Request::input('userarea-mod') != ""){
              $names = ("adminM_".\Request::input('userarea-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_userarea-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
            if(\Request::input('userarea-eli') != ""){
              $names = ("adminM_".\Request::input('userarea-eli')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
                  $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_userarea-eli"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
           $names = ("adminM_userarea-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }


 //USER CLIENTE
       if(\Request::input('userclient-sho') != ""){
             if(\Request::input('userclient-sho') != ""){
              $names = ("adminM_".\Request::input('userclient-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
            if(\Request::input('userclient-ins') != ""){
              $names = ("adminM_".\Request::input('userclient-ins')); 
              $idp = Permission::where('name', '=', $names)->value('id');
               $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
               'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_userclient-ins"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
          
            if(\Request::input('userclient-mod') != ""){
              $names = ("adminM_".\Request::input('userclient-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_userclient-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
            if(\Request::input('userclient-eli') != ""){
              $names = ("adminM_".\Request::input('userclient-eli')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
                  $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_userclient-eli"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
           $names = ("adminM_userclient-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

 //TICKET
       if(\Request::input('ticket-sho') != ""){
             if(\Request::input('ticket-sho') != ""){
              $names = ("adminM_".\Request::input('ticket-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          if(\Request::input('ticket-mod') != ""){
              $names = ("adminM_".\Request::input('ticket-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
           else{
              $names = ("adminM_ticket-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
           $names = ("adminM_ticket-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

 //SEGUIMIENTO
       if(\Request::input('seguimiento-sho') != ""){
             if(\Request::input('seguimiento-sho') != ""){
              $names = ("adminM_".\Request::input('seguimiento-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }if(\Request::input('seguimiento-mod') != ""){
              $names = ("adminM_".\Request::input('seguimiento-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_seguimiento-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
            if(\Request::input('seguimiento-ver') != ""){
              $names = ("adminM_".\Request::input('seguimiento-ver')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
                  $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_seguimiento-ver"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
          if(\Request::input('seguimiento-cerrado') != ""){
              $names = ("adminM_".\Request::input('seguimiento-cerrado')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
                  $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_seguimiento-cerrado"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }       
        }
        else{
           $names = ("adminM_seguimiento-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

//HISTORIAL
       if(\Request::input('historial-sho') != ""){
            if(\Request::input('historial-sho') != ""){
              $names = ("adminM_".\Request::input('historial-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }      
        }
        else{
           $names = ("adminM_historial-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

//REPORTE ADMIN
       if(\Request::input('reportadmin-sho') != ""){
            if(\Request::input('reportadmin-sho') != ""){
              $names = ("adminM_".\Request::input('reportadmin-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }      
        }
        else{
           $names = ("adminM_reportadmin-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }

//REPORTE USUARIO
       if(\Request::input('report-sho') != ""){
            if(\Request::input('report-sho') != ""){
              $names = ("adminM_".\Request::input('report-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }      
        }
        else{
           $names = ("adminM_report-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }



 //FACTURACION
       if(\Request::input('facturation-sho') != ""){
             if(\Request::input('facturation-sho') != ""){
              $names = ("adminM_".\Request::input('facturation-sho')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
            if(\Request::input('facturation-ins') != ""){
              $names = ("adminM_".\Request::input('facturation-ins')); 
              $idp = Permission::where('name', '=', $names)->value('id');
               $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
               'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_facturation-ins"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }
          
            if(\Request::input('facturation-mod') != ""){
              $names = ("adminM_".\Request::input('facturation-mod')); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $idvalid = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->value('role_id');
               if($idvalid == ""){
               $datos = Permission_Role::create([
                'permission_id' => $idp,
                'role_id' => \Request::input('role_id'),
                ]);                           
            }
          }
          else{
              $names = ("adminM_facturation-mod"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
            }      
        }
        else{
           $names = ("adminM_facturation-sho"); 
              $idp = Permission::where('name', '=', $names)->value('id');
              $data = Permission_Role::where('permission_id', '=', $idp)->where('role_id', '=', \Request::input('role_id'))->delete();
        }


       // Session::flash('message', 'Nuevo permiso asignado');
       // Session::flash('class', 'success');

       // Session::flash('message', 'Nuevo permiso asignado');
       // Session::flash('class', 'success');


       return Redirect::back();
	}    


    public function desasignar(Request $request, $id){

        $rolPermisos =  DB::table("permission_role")->where("permission_id.role_id",$id)
            ->delete();

        
        Session::flash('message', 'Permiso eliminado del rol');
        Session::flash('class', 'success');

        return Redirect::back();
	}

    public function store(Request $request)
    {
     //dd("fdsafadfs");
          $search_permission = Permission::where('name', '=', \Request::input('name'))->first();

          if (count($search_permission) == 0)
          {
             $permission = new Permission();

              $permission->name = \Request::input('name');
              $permission->display_name = \Request::input('display_name');
              $permission->description = \Request::input('description');
              //dd($permission);
              if($permission->save()){
                    return redirect('rolepermission')->with('message', 'Agrego un nuevo permiso.');
            }
          }else{  
                    return redirect('rolepermission/create')->with('message', 'No se permiten duplicados.'); 
       }

    }

    public function create()
    {
        return \View::make('roles.create_permission');
    }

    public function destroy($id)
    {
       
        $delete_permission = Permission::find($id)->delete();
        return Redirect::to('rolepermission')->with('message', '¡Registro eliminado!');

    }
    public function restore($id)
    {     
          Permission::withTrashed()->find($id)->restore();
          return redirect()->back();
    }

    public function update(Request $request, $id)
    {
      
       $update_permission = Permission::findOrFail($id);
       
       $update_permission->name = $permissionRequest->input('name');
       $update_permission->display_name = $permissionRequest->input('display_name');
       $update_permission->description = $permissionRequest->input('description');

        DB::table("permission_role")->where("permission_id.role_id",$id)
            ->delete();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }
      $update_permission->save();

      return Redirect::to('rolepermission')->with('message', 'Se actualizo el registro.');
    }


}