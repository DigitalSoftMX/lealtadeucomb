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
    
    $membresia = $request->membership;
    $despachador = $request->dispatcher;
    $folios = $request->folio;
    //$membresia = "18111111";
    //$folios = "80Z9Y_5X2093HY9036541109724";
    //$despachador = "App";
    
    $membership=Memberships::where('number_usuario', '=', $membresia)->where('active', '=', 1)->value('id'); 
    
     if($membership != ""){//sirve para comprobar si el usuario existe en la tabla de membresia
 
                $decimal = substr($folios, 0, 15);
                $esnew = substr($folios, 15, 5);
                $folionew = substr($folios, 20);
    //dd($esnew);
                 $ocupado=Tickets::where('number_ticket', '=', $folionew)
                                 ->where('number_valor', '=', $decimal)
                                 ->value('number_ticket');
                     if($ocupado == null){
             
    //*************************************************************************************************************************                            
       date_default_timezone_set("America/Mexico_City");
                          $flecha = date('Y-m-d'); 
                          $flechahor = date('Y-m-d G:i:s'); 
                          //fecha servidor
                                $anoserv = substr($flecha, 0, 4);
                                $messerv = substr($flecha, 5, 2);
                                $diaserv = substr($flecha, 8, 2);
                                $fechaserv = ($anoserv."-".$messerv."-".$diaserv);
                           
       $xticket=Tickets::where('number_usuario', '=', $membresia)
                                 ->where('created_at', '>=', $fechaserv . " 00:00:00")
                                 ->where('created_at', '<=', $fechaserv . " 23:59:59")
                                 ->count();
                                 //dd($xticket);
                                 if($xticket == false){
                                     $reslxticket = 0;
                                 }
                                 else{
                                     $reslxticket = $xticket;
                                 }

      if($reslxticket < 4){ 
                            
       $verififolioestation = Station::where('number_station', '=', $esnew)->value('id');
           if($verififolioestation != ""){//verifica la estacion que exista en la tabla de cat_station
            
             
                                                    $dato = Tickets::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folionew,
                                                    'number_valor' => $decimal,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $esnew,
                                                    'descrip' => 'pendiente',
                                                    'created_at' => $flechahor,
                                                    ]); 
                                                    //dd($dato);
                                                    // VERIFICA QUE SI SE GUARDO EN LA BD
                                                    if($dato != null){
                                                         $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folionew)
                                                                 ->where('number_valor', '=', $decimal)
                                                                 ->value('id');
                                                    
                                                        if($verifi == null){
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                        else{
                                                            $respuesta = json_encode(array('resultado' => 'Se guardo correctamente'));
                                                        }
                                                    }
                                                    else{
                                                        //SI NO GUARDA ENTONCES VUELVE A VERIFICAR QUE SE GUARDO EN LA BD 
                                                        $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folionew)
                                                                 ->where('number_valor', '=', $decimal)
                                                                 ->value('id');
                                                    
                                                        if($verifi != null){
                                                            //ERROR DEFINITIVO QUE NO SE GUARDO EN LA BD POR ALGUNA RAZON
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                        else{
                                                            $respuesta = json_encode(array('resultado' => 'Se guardo correctamente'));
                                                        }
                                                        	        
                                                    }
           }
           else{
               $respuesta = json_encode(array('resultado' => 'EL folio no pertenece a esta estacion'));	        
           }
      }
      else{
               $respuesta = json_encode(array('resultado' => 'Intentelo otro dia solo se permiten un numero limitado'));
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
    


public function principalformulario(Request $request){
    
    $membresia = $request->membership;
    $despachador = $request->dispatcher;
    
    $membership=Memberships::where('number_usuario', '=', $membresia)->where('active', '=', 1)->value('id'); 
    
     if($membership != ""){//sirve para comprobar si el usuario existe en la tabla de membresia
 
                $decimal = $request->alfa;
                $esnew = $request->estacion;
                $folionew = $request->venta;
    
                 $ocupado=Tickets::where('number_ticket', '=', $folionew)
                                 ->where('number_valor', '=', $decimal)
                                 ->value('number_ticket');
                     if($ocupado == null){
             
    //*************************************************************************************************************************                            
             date_default_timezone_set("America/Mexico_City");
                          $flecha = date('Y-m-d'); 
                          $flechahor = date('Y-m-d G:i:s');
                          //fecha servidor
                                $anoserv = substr($flecha, 0, 4);
                                $messerv = substr($flecha, 5, 2);
                                $diaserv = substr($flecha, 8, 2);
                                $fechaserv = ($anoserv."-".$messerv."-".$diaserv);
                           
               $xticket=Tickets::where('number_usuario', '=', $membresia)
                                 ->where('created_at', '>=', $fechaserv . " 00:00:00")
                                 ->where('created_at', '<=', $fechaserv . " 23:59:59")
                                 ->count();
                                 //dd($xticket);
                                 if($xticket == false){
                                     $reslxticket = 0;
                                 }
                                 else{
                                     $reslxticket = $xticket;
                                 }

      if($reslxticket < 4){ 
          
       $verififolioestation = Station::where('name', '=', $esnew)->value('id');
       $nameverififolioestation = Station::where('name', '=', $esnew)->value('number_station');
           if($verififolioestation != ""){//verifica la estacion que exista en la tabla de cat_station
            
             
                                                    $dato = Tickets::create([
                                                    'number_usuario' => $membresia,
                                                    'generado' => $despachador,
                                                    'number_ticket' => $folionew,
                                                    'number_valor' => $decimal,
                                                    'id_gas' => $verififolioestation,
                                                    'number_gas' => $nameverififolioestation,
                                                    'descrip' => 'pendiente',
                                                    'created_at' => $flechahor,
                                                    ]); 
                                                    //dd($dato);
                                                    // VERIFICA QUE SI SE GUARDO EN LA BD
                                                    if($dato != null){
                                                         $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folionew)
                                                                 ->where('number_valor', '=', $decimal)
                                                                 ->value('id');
                                                    
                                                        if($verifi == null){
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                        else{
                                                            $respuesta = json_encode(array('resultado' => 'Se guardo correctamente'));
                                                        }
                                                    }
                                                    else{
                                                        //SI NO GUARDA ENTONCES VUELVE A VERIFICAR QUE SE GUARDO EN LA BD 
                                                        $verifi=Tickets::where('number_usuario', '=', $membresia)
                                                                 ->where('number_ticket', '=', $folionew)
                                                                 ->where('number_valor', '=', $decimal)
                                                                 ->value('id');
                                                    
                                                        if($verifi != null){
                                                            //ERROR DEFINITIVO QUE NO SE GUARDO EN LA BD POR ALGUNA RAZON
                                                             $respuesta = json_encode(array('resultado' => 'Enviar mas tarde exceso de traficos'));	        
                                                        }
                                                        else{
                                                            $respuesta = json_encode(array('resultado' => 'Se guardo correctamente'));
                                                        }
                                                        	        
                                                    }
           }
           else{
               $respuesta = json_encode(array('resultado' => 'EL folio no pertenece a esta estacion'));	        
           }
           
      }
      else{
               $respuesta = json_encode(array('resultado' => 'Intentelo otro dia solo se permiten un numero limitado'));
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
    
    
}