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

class EstadoCuentaController extends Controller
{

 
    public function estadocuenta(Request $request){
    
     $mes = $request->mes;
     $year = $request->year;
     $username = $request->username;
     //dd($mes);
     if($request->mes == "Enero"){ $valor = "01"; }
     else if($request->mes == "Febrero"){ $valor = "02"; }
     else if($request->mes == "Marzo"){ $valor = "03"; }
     else if($request->mes == "Abril"){ $valor = "04"; }
     else if($request->mes == "Mayo"){ $valor = "05"; }
     else if($request->mes == "Junio"){ $valor = "06"; }
     else if($request->mes == "Julio"){ $valor = "07"; }
     else if($request->mes == "Agosto"){ $valor = "08"; }
     else if($request->mes == "Septiembre"){ $valor = "09"; }
     else if($request->mes == "Octubre"){ $valor = "10"; }
     else if($request->mes == "Noviembre"){ $valor = "11"; }
     else if($request->mes == "Diciembre"){ $valor = "12"; }
      
     
     $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
     $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
     
     // dd($inicial);
      
      $perfilall = Movement::
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
                ->where('tickets.descrip', '!=', 'pendiente')
                ->orderBy('tickets.created_at', 'desc')
                ->get();
                
        /*        $perfilall = Exchange::
                select('exchange.id','exchange.qr_memberships', 'exchange.points', 'station.name', 'exchange.concept', 'exchange.todate', \DB::raw('exchange.folio as folios'))
                ->join('station', 'exchange.id_station', '=', 'station.id')
                ->where('qr_memberships', '=', $username)
                ->where('created_at', '>=', $inicial)
                ->where('created_at', '<=', $final)
                ->union($mov)
                ->get();
                
        $existe = Exchange::
                select('exchange.id','exchange.qr_memberships', 'exchange.points', 'station.name', 'exchange.concept', 'exchange.todate', \DB::raw('exchange.folio as folios'))
                ->join('station', 'exchange.id_station', '=', 'station.id')
                ->where('qr_memberships', '=', $username)
                ->where('created_at', '>=', $inicial)
                ->where('created_at', '<=', $final)
                ->union($mov)
                ->value('id');*/
                
     if($perfilall != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function estadocuentaIOS(Request $request){
    
     $mes = $request->mes;
     $year = $request->year;
     $username = $request->username;
     
     if($request->mes == "Enero"){ $valor = "01"; }
     else if($request->mes == "Febrero"){ $valor = "02"; }
     else if($request->mes == "Marzo"){ $valor = "03"; }
     else if($request->mes == "Abril"){ $valor = "04"; }
     else if($request->mes == "Mayo"){ $valor = "05"; }
     else if($request->mes == "Junio"){ $valor = "06"; }
     else if($request->mes == "Julio"){ $valor = "07"; }
     else if($request->mes == "Agosto"){ $valor = "08"; }
     else if($request->mes == "Septiembre"){ $valor = "09"; }
     else if($request->mes == "Octubre"){ $valor = "10"; }
     else if($request->mes == "Noviembre"){ $valor = "11"; }
     else if($request->mes == "Diciembre"){ $valor = "12"; }
      
     
     $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
     $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
     
      $perfilall = Movement::
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
                ->where('tickets.descrip', '!=', 'pendiente')
                ->orderBy('tickets.created_at', 'desc')
                ->get();
                
     if($perfilall != ""){
        $respuesta = json_encode($perfilall); 
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
    
    
    }
    
}