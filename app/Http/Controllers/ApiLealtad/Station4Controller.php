<?php
 
namespace App\Http\Controllers\ApiLealtad;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Lealtad\Memberships;
use App\Models\Lealtad\Station;
use App\Models\Lealtad\Tickets;
use App\Models\Lealtad\Voucher;
use App\Models\Lealtad\Awards;
use App\Models\Lealtad\Exchange;
use App\Models\Lealtad\History;
use App\Models\Lealtad\Dispatcher;
use App\Models\Lealtad\Role_User;
use App\Models\Lealtad\Cat_Server;
use App\Models\Lealtad\ConjuntoMembership;
use App\Models\Lealtad\Change_Memberships;
use App\Models\Lealtad\DoblePuntos;
use App\Models\Lealtad\Count_Voucher;
use App\Models\Lealtad\Cat_Qr;
use phpseclib\Crypt\RSA;
use App\Models\Catalogos\Key;
use App\Models\Catalogos\FacturaReceptor;
use App\Models\Catalogos\CatBombas;
use App\Models\Catalogos\Facturas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Mail;
use DB;

class Station4Controller extends Controller
{

public function principal(Request $request){
    
       
        $count = Tickets::select('number_valor', 'number_ticket', 'number_gas')->where('descrip', '=', "pendiente")->where('id_gas', '=', 4)->count();
        
       	if($count >= 1){
   	 	
   	 	$respuesta = Tickets::select('number_valor', 'number_ticket', 'number_gas')->where('descrip', '=', "pendiente")->where('id_gas', '=', 4)->get();
        $contenedor = array();
     	
   	 	    $d = array();
   	    	$d = json_encode($respuesta);
   	 	    $json = json_encode($d);

            $station = Station::where('id', '=', 4)->value('ip');
            $url = 'http://'.$station.'/sales/public/recordlealtad.php';
            //dd($json);
            $ch = curl_init($url); 
            curl_setopt($ch, CURLOPT_HEADER, false);                                                                     
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);  
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                       
                'Content-Type: application/json','Content-Length: ' . strlen($json)) );                                                  
            $result = curl_exec($ch);
            
            //echo ' '. $result;
             curl_close($ch);
           
             var_dump(json_decode($result, true));
             //var_dump(json_encode($result, true));
             
        
             
           	//dd($array = json_decode($result, true));
           	 $array = json_decode($result, true);
           	
           	if($result == null){
           	    echo $resultado = json_encode(array('resultado' => 'No existen datos'));
           	}
           	else{
           	
   	 	    foreach ($array as $value) {
                    
                     $va = $value['valor'];
                     $fo = $value['folio'];
                     $pr = $value['producto'];
                     $li = $value['litro'];
                     $co = $value['costo'];
                     $fh = $value['fecha'];
                     $hr = $value['hora'];
                     $es = $value['estatus'];
        
                    if($value['mensaje'] == "correcto"){
                         $this->Sumar($va, $fo, $pr, $li, $co, $fh, $hr, $es);
                    }
                    else{
                         $this->NoSumar($va, $fo);
                    }
                }
            dd($result);
           	}
           	
   	 	}
   	 	else{
   	 		echo $resultado = json_encode(array('resultado' => 'No existen datos'));
   	 	}
   	 	
   	 
    }
    
    private function Sumar($decimal, $folionew, $tinew, $canew, $stnew, $fhnew, $hrnew, $etnew){
        
        $idticket = Tickets::where('number_ticket', '=', $folionew)->where('number_valor', '=', $decimal)->value('id');
        if($etnew == "L"){
            
                      $descript = "Pertenece a otro beneficio";
                       $ticket = Tickets::find($idticket);
                       $ticket->descrip = $descript;
                       $ticket->save();   
             }
              else{
                    $membresia = Tickets::where('number_ticket', '=', $folionew)->where('number_valor', '=', $decimal)->value('number_usuario');
                  
                     date_default_timezone_set("America/Mexico_City");
                          $flecha = date('Y-m-d'); 
                          //fecha servidor
                                $anoserv = substr($flecha, 0, 4);
                                $messerv = substr($flecha, 5, 2);
                                $diaserv = substr($flecha, 8, 2);
                                $fechaserv = ($anoserv."-".$messerv."-".$diaserv);
                                $horserv = substr($flecha, 11, 2);
                                $minserv = substr($flecha, 14, 2);
                                $segserv = substr($flecha, 17, 2);
                                $hoursserv = ($horserv.":".$minserv.":".$segserv);
                               
                              //fecha
                                $ano = substr($fhnew, 0, 4);
                                $mes = substr($fhnew, 4, 2);
                                $dia = substr($fhnew, 6, 2);
                                $fecha = ($ano."-".$mes."-".$dia);
                                
                                $hor = substr($hrnew, 0, 2);
                                $min = substr($hrnew, 3, 2);
                                $seg = "00";
                                $hours = ($hor.":".$min.":".$seg);
                                
                                if($dia == $diaserv){ //dia es el mismo
                                    $fvcuatro=true;
                                }
                                else{  //si el dia no es el mismo
                                       $menosdia = ($diaserv - 1);
                                    if(($dia == "31" and $diaserv = "01") || ($dia == "30" and $diaserv = "01")){
                                        $fvcuatro=true;    
                                    }
                                    else if($dia == $menosdia){
                                        $fvcuatro=true;    
                                    }
                                    else {
                                        $fvcuatro=false;
                                    }
                                }
                                
                                $fecharegister = ($fecha." ".$hours);
                                //
                                $litros = $canew;
                                $precio = $stnew;
                                
                                $point = $canew;
                                
                                 $puntosdob = DoblePuntos::where('id', '=', 1)->value('active');
                                 //dd($puntosdob);
                                if($puntosdob == 1){
                                    $points = ($point * 2);
                                    $puntos = (int)round($points);
                                    $tpuntos = 160;
                                }
                                else{
                                    $puntos = (int)round($point);
                                    $tpuntos = 80;
                                }
                                
                                //cambiar producto
                                  if($tinew == 1){ $producto = "Magna"; }
                                  elseif($tinew == 2){ $producto = "Premium"; }
                                  elseif($tinew == 3){ $producto = "Diesel"; }
                                //$producto = $denew;
                                
                                //rango de dia
                                $fechaini = $fecha . " 00:00:00";
                                $fechafin = $fecha . " 23:59:59";
                            
                                  $exfolio=Tickets::
                                     where('number_ticket', '=', $folionew)
                                   ->where('number_valor', '=', $decimal)
                                   ->where('descrip', '=', "pendiente")
                                   ->value('id');
                               
                            if($fvcuatro == true){ //24 horas activado
                               if($exfolio != null){ //no existe el folio o duplicidad
                               
                                                    if($producto == "Diesel"){ //poducto es disel se divide a cuarta parte
                                                        /* $newpoints = ($puntos / 4);
                                                         if($newpoints > 80){
                                                             $newpoints = 80;
                                                          }*/
                                                        $descript = "Diesel no puede sumar puntos";
                                                        $ticket = Tickets::find($idticket);
                                                        $ticket->descrip = $descript;
                                                        $ticket->save();
      
                                                    }
                                                     else if($puntos > $tpuntos){ $newpoints = $tpuntos; } //solo aceptan 80 puntos maximo
                                                     else{ $newpoints = $puntos; }
                            
                                               $acumuladopoint=\DB::table('tickets')->select(\DB::raw('SUM(punto) as Total'))->where('number_usuario', '=', $membresia)->whereDate('created_at', '=', $fechaserv)
                                                                ->value('Total');                 
                                               $resultpoint = ($acumuladopoint + $newpoints);
                                               if($resultpoint <= $tpuntos){ //maximo 80 punto por dia acumulados
                                                    
                                                    $descript = "puntos sumados";
                                                    
                                                    $ticket = Tickets::find($idticket);
                                                    $ticket->punto = $newpoints;
                                                    $ticket->litro = $litros;
                                                    $ticket->producto= $producto;
                                                    $ticket->costo = $precio;
                                                    $ticket->descrip = $descript;
                                                    $ticket->fh_ticket = $fecharegister;
                                                    $ticket->save();
                                                    
                                                     if($ticket != null){
                                                    
                                                        $grupomem = ConjuntoMembership::where('membresia', '=', $membresia)->value('number_usuario');
                                                           if($grupomem != null){
                                                               $totpoi = \DB::table('tarjeta')->where('number_usuario', "=", $grupomem)->increment('totals', $newpoints);
                                                               $totpoin = \DB::table('conjunto_memberships')->where('number_usuario', "=", $grupomem)->increment('puntos', $newpoints);
                                                                $respuesta = json_encode(array('resultado' => 'Puntos sumados'));	        
                                                                \DB::table('tarjeta')->where('number_usuario', "=", $grupomem)->increment('visits', 1);
                                                           }
                                                           else{
                                                               $totpoi = \DB::table('tarjeta')->where('number_usuario', "=", $membresia)->increment('totals', $newpoints);
                                                                $respuesta = json_encode(array('resultado' => 'Puntos sumados'));	        
                                                                \DB::table('tarjeta')->where('number_usuario', "=", $membresia)->increment('visits', 1);
                                                           }
                                                     }
                                                 
                                               }
                                               else{
                                                    $descript = "Solo se permiten sumar 80 puntos por día";
                                                    $ticket = Tickets::find($idticket);
                                                    $ticket->descrip = $descript;
                                                    $ticket->save();
                                               }
                                        }
                                        else{
                                            $descript = "El folio no existe";
                                            $ticket = Tickets::find($idticket);
                                            $ticket->descrip = $descript;
                                            $ticket->save();
                                        }
                             }
                              else{
                                       $descript = "No se pudo ingresar ya pasaron más de 24 horas";
                                       $ticket = Tickets::find($idticket);
                                       $ticket->descrip = $descript;
                                       $ticket->save();
                                  }
                        }
                        
                  
    }
    
     private function NoSumar($decimal, $folionew){
        
        $idticket = Tickets::where('number_ticket', '=', $folionew)->where('number_valor', '=', $decimal)->value('id');
        
                       $descript = "Información errónea";
                       $ticket = Tickets::find($idticket);
                       $ticket->descrip = $descript;
                       $ticket->save();

    }
    
}