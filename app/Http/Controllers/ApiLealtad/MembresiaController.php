<?php
 
namespace App\Http\Controllers\ApiLealtad;
 
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

class MembresiaController extends Controller
{

 
    public function membresia(Request $request){
    
     $username = $request->username;
     //$perfilall = Memberships::where('number_usuario', '=', $username)->first();
     
     $perfilall = Memberships::select("tarjeta.number_usuario","tarjeta.totals","tarjeta.visits", \DB::raw("CONCAT(users.name,' ',users.first_surname) as nombre"))
            ->join('users', 'tarjeta.number_usuario', '=', 'users.username')
            ->where('tarjeta.number_usuario', '=', $username)
            ->first();
           
     $existe = Memberships::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    public function membresiaIOS(Request $request){
    
     $username = $request->username;
     //$perfilall = Memberships::where('number_usuario', '=', $username)->first();
     
     $perfilall = Memberships::select("tarjeta.number_usuario","tarjeta.totals","tarjeta.visits", \DB::raw("CONCAT(users.name,' ',users.first_surname) as nombre"))
            ->join('users', 'tarjeta.number_usuario', '=', 'users.username')
            ->where('tarjeta.number_usuario', '=', $username)
            ->first();
           
     $existe = Memberships::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
      
     }
     else{
         $book = array(
                        "nombre" => "error"
                      );
        
        $respuesta = json_encode(array('resultado' => $book));     
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function puntos(Request $request){
    
     $username = $request->username;
     $point = Memberships::where('number_usuario', '=', $username)->value('totals');
     
     if($point != ""){
        $respuesta = json_encode(array('resultado' => $point));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "0"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    public function membresiaestadocuenta(Request $request){
        
    date_default_timezone_set("America/Mexico_City");
    $username = $request->username;
     $year = date('Y') ; // Fecha
     $valor = date('m') ; // Fecha
     $dia = date('d') ; // Fecha
     
     $inicial = $year . "-" . $valor . "-" . $dia . " " . "00:00:00";
     $final =   $year . "-" . $valor . "-" . $dia . " " . "24:59:59";
    
     $perfilallmov = Movement::
                select('tickets.id','tickets.number_usuario', 'tickets.punto', 'station.name', 'tickets.descrip', 'tickets.fh_ticket', 'tickets.created_at', \DB::raw('tickets.number_ticket as folios'),
                \DB::raw('(CASE 
                        WHEN tickets.punto != " " THEN tickets.punto
                        ELSE " "
                        END) AS punto'),
                        \DB::raw('(CASE 
                        WHEN tickets.fh_ticket != " " THEN tickets.fh_ticket
                        ELSE " "
                        END) AS fh_ticket'))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.number_usuario', '=', $username)
                ->where('tickets.created_at', '>=', $inicial)
                ->where('tickets.created_at', '<=', $final)
                ->orderBy('tickets.created_at', 'desc')
                ->get();
                
        $respuesta = json_encode(array('resultado' => $perfilallmov));      
             
        return response($respuesta);      
                
    }
    
     public function membresiaestadocuentaIOS(Request $request){
        
    date_default_timezone_set("America/Mexico_City");
    $username = $request->username;
     $year = date('Y') ; // Fecha
     $valor = date('m') ; // Fecha
     $dia = date('d') ; // Fecha
     
     $inicial = $year . "-" . $valor . "-" . $dia . " " . "00:00:00";
     $final =   $year . "-" . $valor . "-" . $dia . " " . "24:59:59";
     
     $perfilallmov = Movement::
                select('tickets.id','tickets.number_usuario', 'tickets.punto', 'station.name', 'tickets.descrip', 'tickets.fh_ticket', 'tickets.created_at', \DB::raw('tickets.number_ticket as folios'),
                \DB::raw('(CASE 
                        WHEN tickets.punto != " " THEN tickets.punto
                        ELSE 0
                        END) AS punto'),
                         \DB::raw('(CASE 
                        WHEN tickets.fh_ticket != " " THEN tickets.fh_ticket
                        ELSE " "
                        END) AS fh_ticket'))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.number_usuario', '=', $username)
                ->where('tickets.created_at', '>=', $inicial)
                ->where('tickets.created_at', '<=', $final)
                ->orderBy('tickets.created_at', 'desc')
                ->get();
            
        
       if($perfilallmov != ""){
           $respuesta = json_encode($perfilallmov);  
         }
         else{
             $respuesta = json_encode(array('resultado' => "error"));      
         }       
             
        return response($respuesta);      
                
    }
    
}