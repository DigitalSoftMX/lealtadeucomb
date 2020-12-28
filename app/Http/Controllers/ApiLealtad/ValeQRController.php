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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class ValeQRController extends Controller
{

 
    public function valeqr(Request $request){
    
     $numero = $request->username;
     $id_imagen = Exchange::where('identificador', '=', $numero)->value('image');
     $id_use = Exchange::where('identificador', '=', $numero)->value('id');

                
                if($id_imagen == null){
                $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($numero, 'QRCODE'). ' ';
                list(, $Base64Img) = explode(';', $Base64Img);
                list(, $Base64Img) = explode(',', $Base64Img);
                $Base64Img = base64_decode($Base64Img);
                
                file_put_contents("img/valeqrimg/$numero.jpg", $Base64Img); 
                    $t = Exchange::find($id_use);
                    $t->image = $numero;
                    $t->save();
                }
                
        $respuesta = json_encode(array('resultado' => $numero));      
  
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    public function valeqrIOS(Request $request){
    
     $numero = $request->username;
     $id_imagen = Exchange::where('identificador', '=', $numero)->value('image');
     $id_use = Exchange::where('identificador', '=', $numero)->value('id');

                
                if($id_imagen == null){
                $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($numero, 'QRCODE'). ' ';
                list(, $Base64Img) = explode(';', $Base64Img);
                list(, $Base64Img) = explode(',', $Base64Img);
                $Base64Img = base64_decode($Base64Img);
                file_put_contents("img/valeqrimg/$numero.jpg", $Base64Img); 
                
                
                    $t = Exchange::find($id_use);
                    $t->image = $numero;
                    $t->save();
                    
                }
        //$respuesta = json_encode($numero);      
  $respuesta = json_encode(array('resultado' => $numero));      
  
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    public function apisincronizarqr(Request $request){
    
     $numero = $request->qr;
     $dispatcher = $request->dispatcher;
     
     $state = Exchange::where('identificador', '=', $numero)->value('estado');
     $id_use = Exchange::where('identificador', '=', $numero)->value('id');
     
     //dd($numero);
     if($state == 1){
         date_default_timezone_set("America/Mexico_City");
         $fecha = date('Y-m-d h:i') ; // Fecha 
                              
          $t = Exchange::find($id_use);
          $t->estado = 3;
          $t->generado = $dispatcher;
          $t->estado_tres = $fecha;
          $t->save();
     
         
     $state = Exchange::where('identificador', '=', $numero)->value('estado');
         if($state == 3){
            $result = "correcto";
            $respuesta = json_encode(array('resultado' => $result));
         }
         else{
            $result = "error";
            $respuesta = json_encode(array('resultado' => $result));      
         }
     }
     else{
        $result = "error";
        $respuesta = json_encode(array('resultado' => $result));      
     }
    
           return response($respuesta);
 
    }
    
}