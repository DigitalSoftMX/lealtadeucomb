<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Memberships;
use App\Models\Catalogos\Station;
use App\Models\Catalogos\Tickets;
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
use Mail;
use DB;

class MovEstateController extends Controller
{

    
public function registrar(Request $request){
    
    $membresia = $request->membership;
    $despachador = $request->dispatcher;
    
    $membership=Memberships::where('number_usuario', '=', $membresia)->where('active', '=', 1)->value('id');  

      /*$fechaactual = date('Y-m-d'); 

      $folio = $request->id;
      
      $repetidos = DB::select( DB::raw("SELECT numerousuario, numero_ticket, COUNT(numero_ticket) AS repetido FROM estadodecuenta GROUP BY numero_ticket, numerousuario ORDER BY numerousuario"));*/

      /*DB::table('estadodecuenta')
                            ->selectRaw('numerousuario,numero_ticket, COUNT(numero_ticket) as repetido')
                            ->groupBy('numero_ticket', 'numerousuario')
                            ->having('repetido','>',1) 
                            ->orderBy('numerousuario')
                            ->get();*/

     // dd($repetidos);
      if($membership != ""){//sirve para comprobar si el usuario existe en la tabla de mebresia

        $verififolioestation = Station::where('number_station', '=', $request->es)->value('id');
           if($verififolioestation != ""){//verifica la estacion que exista en la tabla de cat_station

                        date_default_timezone_set("America/Mexico_City");
                          $flecha = date('Y-m-d'); 
                          //dd($flecha);
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
                                $ano = substr($request->fh, 0, 4);
                                $mes = substr($request->fh, 4, 2);
                                $dia = substr($request->fh, 6, 2);
                                $fecha = ($ano."-".$mes."-".$dia);
                                
                                $hor = substr($request->fh, 8, 2);
                                $min = substr($request->fh, 10, 2);
                                $seg = substr($request->fh, 12, 2);
                                $hours = ($hor.":".$min.":".$seg);
                                
                               // dd($dia);
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
                                $litros = $request->ca;
                                $precio = $request->im;
                                
                                $point = $request->ca;
                                //$puntos = $point;
                                //$points = ($point * 2);
                                $puntos = (int)round($point);
                                
                                $num_server = $request->es;
                                $folio = $request->id;
                                $descripcion = "puntos sumados";
                                //cambiar producto
                                if($request->ti == 1){ $producto = "Magna"; }
                                elseif($request->ti == 2){ $producto = "Premium"; }
                                elseif($request->ti == 3){ $producto = "Diesel"; }
                                
                                //rango de dia
                                $fechaini = $fecha . " 00:00:00";
                                $fechafin = $fecha . " 23:59:59";
                            
                                  $exfolio=Tickets::
                                 //->where('number_usuario', '=', $membresia)
                                 //->where('generado', '=', $despachador)
                                 where('number_ticket', '=', $folio)
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
                                                       $respuesta = json_encode(array('resultado' => 'La membresia no existe'));	        
      
                                                    }
                                                     else if($puntos > 80){ $newpoints = 80; } //solo aceptan 80 puntos maximo
                                                     else{ $newpoints = $puntos; }
                            
                                                $acumuladopoint=\DB::table('tickets')->select(\DB::raw('SUM(punto) as Total'))->where('number_usuario', '=', $membresia)->whereDate('created_at', '=', $fechaserv)
                                                                ->value('Total');                 
                                               $resultpoint = ($acumuladopoint + $newpoints);
                                               if($resultpoint <= 80){ //maximo 80 punto por dia acumulados

                                                    $dato = Tickets::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folio,
                                                    'punto' => $newpoints,
                                                    'litro' => $litros,
                                                    'producto' => $producto,
                                                    'costo' => $precio,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $num_server,
                                                    'descrip' => $descripcion,
                                                    'fh_ticket' => $fecharegister,
                                                    ]); 
                                                    
                                                    if($dato != null){
                                                         $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folio)
                                                                 ->value('id');
                                                    
                                                        if($verifi != null){
                                                           $totpoi = \DB::table('tarjeta')->where('number_usuario', "=", $membresia)->increment('totals', $newpoints);
                                                            $respuesta = json_encode(array('resultado' => 'Puntos sumados'));	        
                                                            \DB::table('tarjeta')->where('number_usuario', "=", $membresia)->increment('visits', 1);
                                                            
                                                        }
                                                        else{
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                    }
                                                    else{
                                                        $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de trafico'));	        
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
               $respuesta = json_encode(array('resultado' => 'EL folio no pertenece a esta estacion'));	        
           }
                      
          }else{ 
               $respuesta = json_encode(array('resultado' => 'La membresia no existe'));	        
        }


              
                return response($respuesta);

    }
}