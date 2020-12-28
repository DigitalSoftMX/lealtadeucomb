<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Memberships;
use App\Models\Catalogos\Station;
use App\Models\Catalogos\Movement;
use App\Models\Catalogos\Voucher;
use App\Models\Catalogos\Awards;
use App\Models\Catalogos\Exchange;
use App\Models\Catalogos\History;
use App\Models\Catalogos\Dispatcher;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Faturation;
use App\Models\Catalogos\Cat_Server;
use App\Models\Catalogos\Change_Memberships;
use App\Models\Catalogos\DoublePoints;
use App\Models\Catalogos\Count_Voucher;
use App\Models\Catalogos\Cat_Qr;
use App\Models\Catalogos\Facturacion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class FacturacionController extends Controller
{

 
    public function facturacion(Request $request){
    
     $username = $request->username;
     $perfilall = Facturacion::where('id_user', '=', $username)->first();
     $existe = Facturacion::where('id_user', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }

     public function facturacionupdate(Request $request){
    
     $username = $request->usuario;
     
     //$beneficios = User::where('username', '=', $username)->first();
     $existe = Facturacion::where('id_user', '=', $username)->value("id");
     
     //dd($existe);
     if($existe != null){
   
      $t = Facturacion::find($existe);
      //$t->nombre = $request->nombre;
      $t->rfc = $request->rfc;
      $t->numfac = $request->numfac;
     // $t->direccionFiscal = $request->direccion;
     // $t->emailFacturacion = $request->email;
      $t->id_user = $request->usuario;
      $t->save();

        $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));      
     }
     else{
         $datos = Facturacion::create([
                //'nombre' => $request->nombre,
                'rfc' => $request->rfc,
                'numfac' => $request->numfac,
                //'direccionFiscal' => $request->direccion,
                //'emailFacturacion' => $request->email,
                'id_user' =>$request->usuario ,
                ]);
                
        $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
}