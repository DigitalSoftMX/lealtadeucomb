<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Role_User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class PerfilController extends Controller
{

 
    public function perfil(Request $request){
    
     $username = $request->username;
     
     $perfilall = User::select('id', 'name', 'first_surname as first_name','second_surname as second_name', 'email', 'sex', 'username')->where('username', '=', $username)->first();
     $existe = User::where('username', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
    }



    public function perfilIOS(Request $request){
    
     $username = $request->username;
      $perfilall = User::select('id', 'name', 'first_surname as first_name', 'second_surname as second_name', 'phone', 'email', 'sex')
          ->where('username', '=', $username)->first();
     $existe = User::where('username', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall)); 
     }
     else{
        $book = array(
                        "name" => "error"
                      );
        
        $respuesta = json_encode(array('resultado' => $book));  
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
     public function perfilupdate(Request $request){
    
     $username = $request->email;
     $password = Hash::make($request->password);
     //dd($password);
     //$beneficios = User::where('username', '=', $username)->first();
     $existe = User::where('email', '=', $username)->value("id");
    // dd($existe);
    
    if($request->password != ""){
     if($existe != null){
   
      if($request->app_name != null){
      $t = User::find($existe);
      $t->name = $request->name;
      $t->password = $password;
      $t->first_surname = $request->app_name;
      $t->second_surname = $request->apm_name;
      $t->email = $request->email;
      $t->sex = $request->sex;
      //$t->phone = $request->telefono;
      $t->save();
      }
      else{
      $t = User::find($existe);
      $t->name = $request->name;
      $t->password = $password;
      $t->first_surname = $request->first_name;
      $t->second_surname = $request->second_name;
      $t->email = $request->email;
      $t->sex = $request->sex;
      //$t->phone = $request->telefono;
      $t->save();
          
      }
        $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }
     
    }
    
    if($existe != null){
   
      if($request->app_name != null){
      $t = User::find($existe);
      $t->name = $request->name;
      $t->first_surname = $request->app_name;
      $t->second_surname = $request->apm_name;
      $t->email = $request->email;
      $t->sex = $request->sex;
      //$t->phone = $request->telefono;
      $t->save();
      }
      else{
      $t = User::find($existe);
      $t->name = $request->name;
      $t->first_surname = $request->first_name;
      $t->second_surname = $request->second_name;
      $t->email = $request->email;
      $t->sex = $request->sex;
      //$t->phone = $request->telefono;
      $t->save();
          
      }
        $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
}