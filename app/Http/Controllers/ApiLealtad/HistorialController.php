<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Lealtad\Memberships;
use App\Models\Lealtad\Station;
use App\Models\Lealtad\Movement;
use App\Models\Lealtad\Voucher;
use App\Models\Lealtad\Awards;
use App\Models\Lealtad\Exchange;
use App\Models\Lealtad\History;
use App\Models\Lealtad\Dispatcher;
use App\Models\Lealtad\Role_User;
use App\Models\Lealtad\Faturation;
use App\Models\Lealtad\Cat_Server;
use App\Models\Lealtad\Change_Memberships;
use App\Models\Lealtad\DoublePoints;
use App\Models\Lealtad\Count_Voucher;
use App\Models\Lealtad\Cat_Qr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class HistorialController extends Controller
{

 
    public function historial(Request $request){
    
     $username = $request->username;
     $perfilall = History::
                join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->where('history.number_usuario', '=', $username)  
                ->get();
            
    $existe = History::where('qr_memberships', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    public function historialIOS(Request $request){
    
     $username = $request->username;
     $perfilall = History::
                join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->where('history.qr_memberships', '=', $username)  
                ->get();
            
    $existe = History::where('qr_memberships', '=', $username)->value("id");
     
     if($existe != ""){
        //$respuesta = json_encode(array('resultado' => $perfilall));      
        $respuesta = json_encode($perfilall);      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
}