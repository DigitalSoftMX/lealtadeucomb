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
     
      //dd($inicial);
      
      $perfilall = Movement::
                select('tickets.id','tickets.number_usuario', 'tickets.punto', 'station.name', 'tickets.descrip', 'tickets.fh_ticket', 'tickets.created_at', \DB::raw('tickets.number_ticket as folios'),
                \DB::raw('(CASE 
                        WHEN tickets.punto != " " THEN tickets.punto
                        ELSE " "
                        END) AS punto'))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.number_usuario', '=', $username)
                ->where('tickets.created_at', '>=', $inicial)
                ->where('tickets.created_at', '<=', $final)
                ->where('tickets.descrip', '!=', "pendiente")
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
                        END) AS punto'))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.number_usuario', '=', $username)
                ->where('tickets.created_at', '>=', $inicial)
                ->where('tickets.created_at', '<=', $final)
                ->orderBy('tickets.created_at', 'desc')
                ->get();
                
     if($perfilall != ""){
        $respuesta = json_encode($perfilall); 
     }
      else{
         $book = array(
                        "nombre" => "error"
                      );
        
        $respuesta = json_encode(array('resultado' => $book));     
     }     
             
        return response($respuesta);
    
    
    }
    
}