<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\FacturaReceptor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class DatosFacturacionController extends Controller
{

 
    public function datosfactura(Request $request){
    
     $username = $request->username;
     
     $existe = User::where('username', '=', $username)->value("id");
     $perfilall = FacturaReceptor::where('id_user', '=', $existe)->first();
     
     if($perfilall != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
    }



    public function datosfacturaIOS(Request $request){
    
     $username = $request->username;
     
     $existe = User::where('username', '=', $username)->value("id");
     $perfilall = FacturaReceptor::where('id_user', '=', $existe)->first();
     
     if($perfilall != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $book = array(
                        "nombre" => "error"
                      );
        
        $respuesta = json_encode(array('resultado' => $book));      
     }    
             
        return response($respuesta);
    }
    
     public function datosfacturaupdate(Request $request){
    
     $username = $request->username;

     //$beneficios = User::where('username', '=', $username)->first();
     $existe = User::where('username', '=', $username)->value("id");
     $perfilall = FacturaReceptor::where('id_user', '=', $existe)->value('id');
    //dd($request->all());
    
     if($perfilall != ""){
   
      if($request->usocfdi == "(null)"){
      $t = FacturaReceptor::find($perfilall);
      $t->nombre = $request->nombre;
      $t->rfc = $request->rfc;
      $t->emailfiscal = $request->emailfiscal;
      $t->id_user = $existe;
      }
      else{
      $t = FacturaReceptor::find($perfilall);
      $t->nombre = $request->nombre;
      $t->rfc = $request->rfc;
      $t->usocfdi = $request->usocfdi;
      $t->emailfiscal = $request->emailfiscal;
      $t->id_user = $existe;
      }
      /*$t->numero_ext = $request->numero_ext;
      $t->numero_int = $request->numero_int;
      $t->calle = $request->calle;
      $t->colonia = $request->colonia;
      $t->estado = $request->estado;
      $t->ciudad = $request->ciudad;
      $t->municipio = $request->municipio;*/
      $t->save();

       $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));      
     }
     else{
          
           FacturaReceptor::create([
           'nombre' => $request->nombre,
           'rfc' => $request->rfc,
           'usocfdi' => $request->usocfdi,
           'emailfiscal' => $request->emailfiscal,
           'id_user' => $existe,
           ]);
   
          $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
}