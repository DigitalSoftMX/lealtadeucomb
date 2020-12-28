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
use Mail;

class RegistrarController extends Controller
{

     
public function registrar(Request $request){
    
    $membresia = $request->membership;
    $ticket = $request->ticket;
    $despachador = $request->dispatcher;
    
    $membership=Memberships::where('number_usuario', '=', $membresia)->value('id');  
   
      if($membership != ""){

      $verestacion = 1;  
      $servidor = 1; 

         if($servidor == $verestacion){
           $verififolioestation = Station::where('number_station', '=', $request->es)->value('id');
           if($verififolioestation != ""){
               
             $verificar = "1";
                  if($verificar != "" ){
                     
                        date_default_timezone_set("America/Mexico_City");
                          
                        $folio = $request->id;
                         
                                $flecha = date('Y-m-d H:s:m') ; // Fecha
                                
                                //fecha servidor
                                $anoserv = substr($flecha, 0, 4);
                                $messerv = substr($flecha, 5, 2);
                                $diaserv = substr($flecha, 8, 2);
                                $fechaserv = ($anoserv."-".$messerv."-".$diaserv);
                                $horserv = substr($flecha, 11, 2);
                                $minserv = substr($flecha, 14, 2);
                                $segserv = substr($flecha, 17, 2);
                                $hoursserv = ($horserv.":".$minserv.":".$segserv);
                               // dd($hoursserv);
                                
                                //fecha ticket         
                                $ano = substr($request->fh, 0, 4);
                                $mes = substr($request->fh, 4, 2);
                                $dia = substr($request->fh, 6, 2);
                                $fecha = ($ano."-".$mes."-".$dia);
                                $fecha1 = ($ano."-".$mes."-".$dia);
                                
                                $hor = substr($request->fh, 8, 2);
                                $min = substr($request->fh, 10, 2);
                                $seg = substr($request->fh, 12, 2);
                                $hours = ($hor.":".$min.":".$seg);
                                $hours1 = ($hor.":".$min.":".$seg);
                               
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
                               
                               //dd($fvcuatro);
                               
                                $fecharegister = ($fecha." ".$hours);
                                                  
                                $litros = $request->ca;
                                $precio = $request->im;
                                
                                if($request->ti == 1){
                                $producto = "Magna";
                                }
                                elseif($request->ti == 2){
                                $producto = "Premium";
                                }
                                elseif($request->ti == 3){
                                $producto = "Diesel";
                                }
                                
                                
                                $pago = 18;
                                
                                $point = $request->ca;
                                //$puntos = $point;
                                //$points = ($point * 2);
                                $puntos = (int)round($point);
                                
                                 $fechaini = $fecha . " 00:00:00";
                                 $fechafin = $fecha . " 23:59:59";
                            
                                 $num_server = $request->es;
                                 $exfolio=Movement::where('number_ticket', '=', $folio)
                                 ->where('id_gas', '=', $num_server)
                                 //->where('id_station', '=', $verififolioestation)
                                 //->whereDate('created_at', '=', $fecha)
                                 ->value('id');

                                //dd($exfolio);

                               //$exfolio = "";
                               if($exfolio == ""){ //no existe el folio

                                 /*$existe=Movement::where('qr_membership', '=', $membresia)
                                 ->whereDate('created_at', '=', $fecha)->value('id');
                                 */
                                 /*$existe=Movement::where('qr_membership', '=', $membresia)
                                 ->whereDate('created_at', '=', $fecha)
                                 ->count();*/
                                 $existe = 1;
                                 if($existe != ""){ //ya sumo puntos este dia   
                                      
                                      if($fvcuatro == true){ //24 horas activado
                                          
                                      if($puntos != ""){ //puntos no son 0    
                                                 
                                               $double = DoublePoints::where('id_station', '=', $verififolioestation)
                                                      ->where('time_ini', '<=', $hours)
                                                      ->where('time_fin', '>=', $hours1)
                                                      ->where('todate_ini', '<=', $fecha)
                                                      ->where('todate_fin', '>=', $fecha1)
                                                      ->value('name_points');
                                                      
                                            //$double="";
                                             if($double != "") { //si hay doble puntos
                                                 $total = $puntos * 2;
                                                          
                                                    $concept = "Puntos Dobles Sumados";
                                                    $puntos = ($puntos + $puntos);
                                                      if($producto == "Diesel"){
                                                // dd($puntos);
                                                         $newpoints = ($puntos / 4);
                                                         if($newpoints > 80){
                                                         $newpoints = 80;
                                                         }
                                                        }
                                                        else if($puntos > 80){
                                                         $newpoints = 80;
                                                     }
                                                     else{
                                                         $newpoints = $puntos;
                                                     }
                                                     date_default_timezone_set("America/Mexico_City");
                                                     $fecharegisters = date('Y-m-d H:s:m') ; // Fecha
                                                     $dato = Movement::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folio,
                                                    'punto' => $newpoints,
                                                    'litro' => $litros,
                                                    'producto' => $producto,
                                                    'costo' => $precio,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $num_server,
                                                    'descrip' => $concept,
                                                    'fh_ticket' => $fecharegisters,
                                                    'created_at' => $fecharegister,
                                                    'updated_at' => $fecharegister,
                                                    ]); 
                                                    if($dato != ""){
                                                       
                                                         $verifi=Movement::where('number_usuario', '=', $membresia)
                                                               ->whereDate('created_at', '=', $fecharegister)
                                                               ->whereDate('generado', '=', $despachador)
                                                               ->whereDate('number_ticket', '=', $folio)
                                                               ->get();
                                
                                                        if($verifi != ""){
                                                           $totpoi = \DB::table('memberships')->where('qr_membership', "=", $membresia)->increment('total_point', $newpoints);
                                                       if($totpoi != ""){
                                                               $respuesta = json_encode(array('resultado' => 'Puntos dobles sumados'));	        
                                                                 \DB::table('memberships')->where('qr_membership', "=", $membresia)->increment('visits', 1);
                                                                 //enviar correo
                                                          $corre = User::where('username', '=', $membresia)->value('email');
                                                           $poi = \DB::table('memberships')->where('qr_membership', "=", $membresia)->value('total_point');
                                                                if($corre != ""){
                                                                  
                                                                $nombre = "atencion_a_clientes@eucomb.com.mx";
                                                                $de = "atencion_a_clientes@eucomb.com.mx";
                                                                $para = $corre;
                                                                $asunto  = "Se cargaron los puntos correctamente";
                                                                
                                                               $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $poi, 'total' => $newpoints);
                                                
                                                               Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                                               $message->from('atencion_a_clientes@eucomb.com.mx', 'Eucomb');
                                                               $message->subject('Eucomb puntos cargados');
                                                               $message->to($para);
                                                               });
                                                               
                                                               if($poi >= 500){
                                                                   
                                                               
                                                               //son mayores a 500puntos
                                                               $nombre = "atencion_a_clientes@eucomb.com.mx";
                                                                $de = "atencion_a_clientes@eucomb.com.mx";
                                                                $para = $corre;
                                                                $asunto  = "Eucomb puntos";
                                                                
                                                                $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => '80', 'total' => '122');
                                                
                                                               Mail::send('mails.mails3', $data, function($message) use($de, $para){
                                                               $message->from('atencion_a_clientes@eucomb.com.mx', 'Eucomb');
                                                               $message->subject('Eucomb puntos');
                                                               $message->to($para);
                                                               });
                                                               
                                                                  
                                                               }
                                                               
                                                               }

                                                       }   
                                                        }
                                                        else{
                                                        $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de trafico'));	        
                                                        }
                                                     
                                                    }
                                                    else{
                                                        $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de trafico'));	        
                                                    }
                                                        
                                                     
                                                         }

                                                         
                                                        else{ //puntos sumados normales
                                                        
                                                        if($producto == "Diesel"){
                                                // dd($puntos);
                                                         $newpoints = ($puntos / 4);
                                                         if($newpoints > 80){
                                                         $newpoints = 80;
                                                         }
                                                }
                                                else if($puntos > 80){
                                                         $newpoints = 80;
                                                     }
                                                     else{
                                                         $newpoints = $puntos;
                                                     }
                                                      date_default_timezone_set("America/Mexico_City");
                                                     $fecharegisters = date('Y-m-d H:s:m') ; // Fecha
                                                    
                                                    $concept = "puntos sumados";
                                                    $dato = Movement::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folio,
                                                    'punto' => $newpoints,
                                                    'litro' => $litros,
                                                    'producto' => $producto,
                                                    'costo' => $precio,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $num_server,
                                                    'descrip' => $concept,
                                                    'fh_ticket' => $fecharegisters,
                                                    'created_at' => $fecharegister,
                                                    'updated_at' => $fecharegister,
                                                    ]); 
                                                    
                                                    if($dato != ""){
                                                         $verifi=Movement::where('qr_membership', '=', $membresia)
                                                               ->whereDate('created_at', '=', $fecharegister)
                                                               ->whereDate('qr_dispatcher', '=', $despachador)
                                                               ->whereDate('qr_ticket', '=', $folio)
                                                               ->get();
                                
                                                        if($verifi != ""){
                                                           $totpoi = \DB::table('memberships')->where('qr_membership', "=", $membresia)->increment('total_point', $newpoints);
                                                       if($totpoi != ""){
                                                               $respuesta = json_encode(array('resultado' => 'Puntos sumados'));	        
                                                                 \DB::table('memberships')->where('qr_membership', "=", $membresia)->increment('visits', 1);
                                                                 //enviar correo
                                                          $corre = User::where('username', '=', $membresia)->value('email');
                                                           $poi = \DB::table('memberships')->where('qr_membership', "=", $membresia)->value('total_point');
                                                                if($corre != ""){
                                                                  
                                                                $nombre = "atencion_a_clientes@eucomb.com.mx";
                                                                $de = "atencion_a_clientes@eucomb.com.mx";
                                                                $para = $corre;
                                                                $asunto  = "Se cargaron los puntos correctamente";
                                                                
                                                               $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $poi, 'total' => $newpoints);
                                                
                                                               Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                                               $message->from('atencion_a_clientes@eucomb.com.mx', 'Eucomb');
                                                               $message->subject('Eucomb puntos cargados');
                                                               $message->to($para);
                                                               });
                                                            }
                                                               
                                                               if($poi >= 500){
                                                                   
                                                               
                                                               //son mayores a 500puntos
                                                               $nombre = "atencion_a_clientes@eucomb.com.mx";
                                                               $de = "atencion_a_clientes@eucomb.com.mx";
                                                               $para = $corre;
                                                               $asunto  = "Eucomb puntos";
                                                                
                                                               $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => '100', 'total' => '122');
                                                
                                                              /* Mail::send('mails.mails3', $data, function($message) use($de, $para){
                                                               $message->from('atencion_a_clientes@eucomb.com.mx', 'Eucomb');
                                                               $message->subject('Eucomb puntos');
                                                               $message->to($para);
                                                               });
                                                               */
                                                                   
                                                               }

                                                       }   
                                                        }
                                                        else{
                                                        $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de trafico'));	        
                                                        }
                                                     
                                                    }
                                                    else{
                                                        $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de trafico'));	        
                                                    }
                                                        
                                                
                                                     //return redirect()->to($url)->with('message', "Puntos Sumados.");                  
                                                     }


                                            }
                                            else{
                                                //  return redirect()->to($url)->with('message', "Los puntos estan en 0");        
                                                  $respuesta = json_encode(array('resultado' => 'Los puntos estan en 0'));	        
            
                                            }
                                            
                                      }    
                                             else{
                                                //  return redirect()->to($url)->with('message', "No se pudo agregar se paso de las 24 horas para ingresar su tiket");        
                                                  $respuesta = json_encode(array('resultado' => 'No se pudo agregar se paso de las 24 horas para ingresar su tiket'));	        
                                        }
                                        
                                            }//si hay puntos
                                            else{
                                                if($producto == "Diesel"){
                                                // dd($puntos);
                                                         $newpoints = ($puntos / 4);
                                                         if($newpoints > 80){
                                                         $newpoints = 80;
                                                         }
                                                }
                                                else if($puntos > 80){
                                                         $newpoints = 80;
                                                     }
                                                     else{
                                                         $newpoints = $puntos;
                                                     }
                                                      date_default_timezone_set("America/Mexico_City");
                                                     $fecharegisters = date('Y-m-d H:s:m') ; // Fecha
                
                                                 $concept = "Ya sumo puntos este dia";
                                                    $dato = Movement::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folio,
                                                    'punto' => $newpoints,
                                                    'litro' => $litros,
                                                    'producto' => $producto,
                                                    'costo' => $precio,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $num_server,
                                                    'drecrip' => $concept,
                                                    'fh_ticket' => $fecharegisters,
                                                    'created_at' => $fecharegister,
                                                    'updated_at' => $fecharegister,
                                                    
                                                    ]); 
                                                     //return redirect()->to($url)->with('message', "Ya sumo puntos este dia.");  
                                                     $respuesta = json_encode(array('resultado' => 'Ya sumo puntos este dia'));	        
                                            }
                                        }
                                        else{
                                            $respuesta = json_encode(array('resultado' => 'El folio ya fue utilizado'));	        
                                        }
                    }else{  
                            $respuesta = json_encode(array('resultado' => 'Mandelo mas tarde o comuniquese con el proveedor'));	        
                        }
           }
           else{
               $respuesta = json_encode(array('resultado' => 'EL folio no pertenece a esta estacion'));	        
           }
               }else{ 
               $respuesta = json_encode(array('resultado' => 'EL qr del despachador no pertenece a esta estacion'));	        
               }            
          }else{ 
               $respuesta = json_encode(array('resultado' => 'La membresia no existe'));	        
        }








    //  $respuesta = json_encode(array('resultado' => "Bienvenido"));	        
              
                return response($respuesta);




       


    }
}
