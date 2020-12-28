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

class NewTicketsController extends Controller
{

public function principal(Request $request){
    
    $folios="S79B4_5WQ0G8BK303498854729";
    $membresia = "18111111";
    $despachador = "API";
                
    //$membresia = $request->membership;
    //$despachador = $request->dispatcher;
    //$folios = $request->folio;
    
    $membership=Memberships::where('number_usuario', '=', $membresia)->where('active', '=', 1)->value('id'); 
    
     if($membership != ""){//sirve para comprobar si el usuario existe en la tabla de membresia
 
                $decimal = substr($folios, 0, 15);
                $esnew = substr($folios, 15, 5);
                $folionew = substr($folios, 20);
    
                 $ocupado=Tickets::where('number_ticket', '=', $folionew)
                                 ->where('number_valor', '=', $decimal)
                                 ->value('number_ticket');
                     if($ocupado == null){
             
    //*************************************************************************************************************************                            
                            
       $verififolioestation = Station::where('number_station', '=', $esnew)->value('id');
           if($verififolioestation != ""){//verifica la estacion que exista en la tabla de cat_station
            
             $ipestation = Station::where('number_station', '=', $esnew)->value('ip');
              $ch = curl_init('http://'.$ipestation.'/sales/public/recordlealtad.php?valor='.$decimal.'&folio='.$folionew.''); 
              curl_setopt($ch, CURLOPT_HEADER, false);                                                                     
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);
                curl_close($ch);
                
                //echo 'curl  '. $result;
                 $names = json_decode($result, true);
                
                //echo $names['mensaje'];
                //echo "<br>";
                
                if($names['mensaje'] == "correcto"){

                        /*echo $names['valor'];
                        echo "<br>";
                        echo $names['folio'];
                        echo "<br>";]*/
                        $tinew = $names['producto'];
                        //echo "<br>";
                        $canew = $names['litro'];
                        ///echo "<br>";
                        //echo $names['precio'];
                        //echo "<br>";
                        $stnew = $names['costo'];
                        //echo "<br>";
                        $fhnew = $names['fecha'];
                        //echo "<br>";
                        $hrnew = $names['hora'];
                        //echo "<br>";
                         $names['estatus'];       
    //****************************************************************************************************************
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
                              
                                
                                $num_server = $esnew;
                                $descripcion = "puntos sumados";
                                
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
                                   ->value('id');
                               
                                $xticket=Tickets::where('number_usuario', '=', $membresia)
                                 ->where('created_at', '>=', $fechaserv . " 00:00:00")
                                 ->where('created_at', '<=', $fechaserv . " 23:59:59")
                                 ->count();
                                 
                                 if($xticket == false){
                                     $reslxticket = 0;
                                 }
                                 else{
                                     $reslxticket = $xticket;
                                 }

                        if($reslxticket < 4){ 
                            if($fvcuatro == true){ //24 horas activado
                               if($exfolio == null){ //no existe el folio o duplicidad
                               
                                                    if($producto == "Diesel"){ //poducto es disel se divide a cuarta parte
                                                        /* $newpoints = ($puntos / 4);
                                                         if($newpoints > 80){
                                                             $newpoints = 80;
                                                          }*/
                                                       $respuesta = json_encode(array('resultado' => 'El producto es disel'));	        
      
                                                    }
                                                     else if($puntos > $tpuntos){ $newpoints = $tpuntos; } //solo aceptan 80 puntos maximo
                                                     else{ $newpoints = $puntos; }
                            
                                               $acumuladopoint=\DB::table('tickets')->select(\DB::raw('SUM(punto) as Total'))->where('number_usuario', '=', $membresia)->whereDate('created_at', '=', $fechaserv)
                                                                ->value('Total');                 
                                               $resultpoint = ($acumuladopoint + $newpoints);
                                               if($resultpoint <= $tpuntos){ //maximo 80 punto por dia acumulados

                                                    $dato = Tickets::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folionew,
                                                    'number_valor' => $decimal,
                                                    'punto' => $newpoints,
                                                    'litro' => $litros,
                                                    'producto' => $producto,
                                                    'costo' => $precio,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $num_server,
                                                    'descrip' => $descripcion,
                                                    'fh_ticket' => $fecharegister,
                                                    ]); 
                                                    //dd($dato);
                                                    // VERIFICA QUE SI SE GUARDO EN LA BD
                                                    if($dato != null){
                                                         $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folionew)
                                                                 ->where('number_valor', '=', $decimal)
                                                                 ->value('id');
                                                    
                                                        if($verifi != null){
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
                                                           
                                                             //verifica que tenga datos fiscales
                                                             $usuarioid=User::where('username', '=', $membresia)->value('id'); 
                                                              $datfiscal = FacturaReceptor::where('id_user', '=', $usuarioid)->value('id');
                                                              if($datfiscal != null){
                                                                  $this->factura($folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fecharegister, $banew, $usuarioid, $verififolioestation);
                                                              }
                                                        }
                                                        else{
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                    }
                                                    else{
                                                        //SI NO GUARDA ENTONCES VUELVE A VERIFICAR QUE SE GUARDO EN LA BD 
                                                        $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folionew)
                                                                 ->where('number_valor', '=', $decimal)
                                                                 ->value('id');
                                                    
                                                        if($verifi != null){
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
                                                           
                                                             //verifica que tenga datos fiscales
                                                             $usuarioid=User::where('username', '=', $membresia)->value('id'); 
                                                              $datfiscal = FacturaReceptor::where('id_user', '=', $usuarioid)->value('id');
                                                              if($datfiscal != null){
                                                                  $this->factura($folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fecharegister, $banew, $usuarioid, $verififolioestation);
                                                              }
                                                        }
                                                        else{
                                                            //ERROR DEFINITIVO QUE NO SE GUARDO EN LA BD POR ALGUNA RAZON
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                        	        
                                                    }
                                               }
                                               else{
                                                    $respuesta = json_encode(array('resultado' => 'El maximo de puntos acumulados es de 80 por dia'));	        
                                               }
                                        }
                                        else{
                                            $respuesta = json_encode(array('resultado' => 'El folio ya fue utilizado'));	        
                                        }
                             }
                              else{
                                    $respuesta = json_encode(array('resultado' => 'No se pudo agregar se paso de las 24 horas para ingresar su tiket'));	        
                                  }
                        }
                         else{
                              $respuesta = json_encode(array('resultado' => 'Intentelo otro dia solo se permiten un numero limitado'));
                              }
             }
              else{
                      $respuesta = json_encode(array('resultado' => 'El folio no se encontro'));	        
                  }
           }
           else{
               $respuesta = json_encode(array('resultado' => 'EL folio no pertenece a esta estacion'));	        
           }
          
                       //*****************************************************************************************
                     }
                     else{
                          $respuesta = json_encode(array('resultado' => 'El folio ya fue utilizado'));	        
                     }
                
                 
           
    }
    else{
          $respuesta = json_encode(array('resultado' => 'La membresia no existe'));	        
    }

              
                return response($respuesta);

    }
    
    
    private function factura($folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fecharegister, $banew, $usuarioid, $verififolioestation){
        
        $bombaid=CatBombas::where('numero', '=', $bonew)->value('id'); 
                                                             
        $dato = Facturas::create([
                'folio' => $folionew,
                'fecha' => $fecharegister,
                'formapago' => $fpnew,
                'subtotal' => $stnew,
                'total' => $ttnew,
                'id_emisor' => $usuarioid,
                'id_receptor' => $usuarioid,
                'cantidad' => $canew,
                'descripcion' => $denew,
                'valorunitario' => $vunew,
                'base' => $banew,
                'id_estacion' => $verififolioestation,
                'id_bomba' => $bombaid,
                'estatus' => 1,
                ]); 
                
        return true;
        
    }
    
}