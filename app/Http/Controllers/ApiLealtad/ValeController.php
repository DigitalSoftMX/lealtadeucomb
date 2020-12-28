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
use App\Models\Catalogos\Role_User;
use App\Models\Lealtad\Faturation;
use App\Models\Lealtad\Cat_Server;
use App\Models\Lealtad\Change_Memberships;
use App\Models\Lealtad\DoublePoints;
use App\Models\Lealtad\Count_Voucher;
use App\Models\Lealtad\Cat_Qr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Mail;

class ValeController extends Controller
{

    public function vale(Request $request){
    
     date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d') ; // Fecha
           
     $username = $request->username;
     $perfilall = Voucher::select('vouchers.id', 'vouchers.name', 'vouchers.points', 'vouchers.value', 'station.name', 'station.address', 'station.phone as telefono', 'station.email as correo', 'cat_status.name_status', 'vouchers.id_station', 'vouchers.total_voucher') 
                ->join('cat_status', 'vouchers.id_status', '=', 'cat_status.id')
                ->join('station', 'vouchers.id_station', '=', 'station.id')
                ->where('vouchers.total_voucher', '>', 0)
                ->get();
                   
    $existe = Voucher::value("id");
     
     if($existe != ""){
                                                              
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function valeIOS(Request $request){
    
    
     date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d') ; // Fecha
           
     $username = $request->username;
     $perfilall = Voucher::select('vouchers.id_station as id', 'vouchers.name', 'vouchers.points', 'vouchers.value', 'station.name', 'station.address', 'station.phone as telefono', 'station.email as correo', 'cat_status.name_status', 'vouchers.id_station', 'vouchers.total_voucher') 
                ->join('cat_status', 'vouchers.id_status', '=', 'cat_status.id')
                ->join('station', 'vouchers.id_station', '=', 'station.id')
                ->where('vouchers.total_voucher', '>', 0)
                ->get();
                   
    $existe = Voucher::value("id");
     
     if($existe != ""){
                                                              
        $respuesta = json_encode($perfilall);      
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
    
    public function premio(Request $request){
    
     date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d') ; // Fecha
           
     $username = $request->username;
     $perfilall = Awards::select('awards.id', 'awards.name', 'awards.points', 'awards.value', 'awards.img','cat_status.name_status') 
                ->join('cat_status', 'awards.id_status', '=', 'cat_status.id')
                ->where('awards.active', '=', 1)
                ->get();
             
    $existe = Awards::value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
     public function premioestacion(Request $request){
    
     date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d') ; // Fecha
           
     $username = $request->username;
     $perfilall = Station::get();
             
    $existe = Station::value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    public function premioIOS(Request $request){
    
     date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d') ; // Fecha
           
     //$username = $request->username;
     $perfilall = Awards::select('awards.id', 'awards.name', 'awards.points', 'awards.value', 'awards.img','cat_status.name_status') 
                ->join('cat_status', 'awards.id_status', '=', 'cat_status.id')
                ->where('awards.active', '=', 1)
                ->get();
             
    $existe = Awards::value("id");
     
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
    
    
    public function agregarvale(Request $request){
        
        //$respuesta = json_encode(array('resultado' => $request->id));      
       $username = $request->username;
       $variable = $request->id;
       $convernumiden = (int) $variable;
        $id_us = User::where('username', '=', $username)->value('id');
               $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->value('role_id');
                 if($rol != ""){ //verifica si es un usuario
                    date_default_timezone_set("America/Mexico_City");
                    $fech = date('Y-m-d') ; $i = "$fech 00:00:00"; $f = "$fech 23:59:59";
                    $qr_memberships = Memberships::where('id_users', '=', $id_us)->value('number_usuario');
                   
                    $count1 = Exchange::where('number_usuario', '=', $qr_memberships)->where('estado_uno', '>=', $i)->where('estado_uno', '<=', $f)->count(); //contar del exchange
                    $count2 = History::where('number_usuario', '=', $qr_memberships)->where('todate', '>=', $i)->where('todate', '<=', $f)->count(); //contar del historial
                    $newcount1 = ($count1 + $count2); //suma los numeros existen en las 2 tablas
                    $countVaucher = Voucher::where('id_station', '=', $convernumiden)->value('id_count_voucher'); //id del contador de vaucher actual 
                    $maxVoucher = Count_Voucher::where('id', '=', $countVaucher)->value('max'); //saca el maximo del count vaucher
                    $idconvernumiden = Voucher::where('id_station', '=', $convernumiden)->value('id'); //id del contador de vaucher actual 
                    $voucher_valores = Voucher::findOrFail($idconvernumiden); //saca toda la fila de voucher
                    
                    if($newcount1 < 1){ //cuenta los vaucher en general vales y premios y regresa si son menores a tres
                    $fecha = date('Y-m-d h:i') ; // Fecha 
                    //muestra el numero ultimo de exchange 
                    $count11 = Exchange::select('conta')->orderBy('conta', 'desc')->limit(1)->where('id_estacion', '=', $voucher_valores->id_station)->max('conta');
                    $count22 = History::select('numero')->orderBy('numero', 'desc')->limit(1)->where('id_station', '=', $voucher_valores->id_station)->max('numero');      
                    //dd($count11);
                    if($count11 > $count22){ $newcount = $count11; } else {$newcount = $count22; }
                    $total_points = Memberships::where('id_users', '=', $id_us)->value('totals'); //total de puntos que se tienen
                    $number1 = (int)$count11;
                
                     if($number1 < $maxVoucher){ //verifica si el numero es menor al maximo de numero de vales que hay
                           if($total_points >= $voucher_valores->points){ //verifica si le alcansan los puntos a la membresia
                                $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                                $numero1 = Exchange::select('conta')->orderBy('conta', 'desc')->limit(1)->where('id_estacion', '=', $voucher_valores->id_station)->max('conta');
                                $numero2 = History::select('numero')->orderBy('numero', 'desc')->limit(1)->where('id_station', '=', $voucher_valores->id_station)->max('numero');
                        if($numero1 == null and $numero2 == null){ //verifica que los numeros no estan vacios
                                  $c  = Count_Voucher::where('id', '=', $countVaucher)->value('min');
                                  $newnumero = $c; //declara a nuevo numero con el minimo que existe
                                      
                                  $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                    $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Api",
                        'id_estacion' => $voucher_valores->id_station,
                        'punto' => $voucher_valores->points,
                        'value' => $voucher_valores->value,
                        'number_usuario' => $qr_memberships,
                        'estado' => 1,
                        'descrip' => "Se desconto",
                        'estado_uno' => $fecha, 
                        ]);
                         $tot = ($total_points - $voucher_valores->points);
                          $update = Memberships::where('id_users', '=', $id_us)
                          ->where('number_usuario', '=', $qr_memberships)
                          ->update(['totals' => $tot]);
         
                           $decrement = \DB::table('vouchers')->where('id_station', '=', $convernumiden)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                       //$url = $this->getUrlPrefix();
                      //return redirect()->to($url)->with('message', "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.");        
                      //enviar correo
                              $corre = User::where('username', '=', $username)->value('email');
                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                if($corre != ""){
                                                                                      
                                    $nombre = "contacto@digitalsoftlealtad.com";
                                    $de = "contacto@digitalsoftlealtad.com";
                                    $para = $corre;
                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                        
                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                        
                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                   $message->from('contacto@digitalsoftlealtad.com');
                                   $message->to($para);
                                   });
                               }
                                            $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                  
                                }
                                else{
                                   if($numero1 > $numero2){ $newnumero = $numero1+1; } else { $newnumero = $numero2+1;} //toma el valor maximo de cualquier de las 2 tablas
                                   
                                   $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                     $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Api",
                        'id_estacion' => $voucher_valores->id_station,
                        'punto' => $voucher_valores->points,
                        'value' => $voucher_valores->value,
                        'number_usuario' => $qr_memberships,
                        'estado' => 1,
                        'descrip' => "Se desconto",
                        'estado_uno' => $fecha, 
                        ]);
                  
                        
                         $tot = ($total_points - $voucher_valores->points);
                          $update = Memberships::where('id_users', '=', $id_us)
                          ->where('number_usuario', '=', $qr_memberships)
                          ->update(['totals' => $tot]);
         
                           $decrement = \DB::table('vouchers')->where('id_station', '=', $convernumiden)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                       //$url = $this->getUrlPrefix();
                      //return redirect()->to($url)->with('message', "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.");        
                
                //enviar correo
                              $corre = User::where('username', '=', $username)->value('email');
                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                if($corre != ""){
                                                                                      
                                    $nombre = "contacto@digitalsoftlealtad.com";
                                    $de = "contacto@digitalsoftlealtad.com";
                                    $para = $corre;
                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                        
                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                        
                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                   $message->from('contacto@digitalsoftlealtad.com');
                                   $message->to($para);
                                   });
                               }
                      $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                      
                                }     
                           }
                           else{
                                $respuesta = json_encode(array('resultado' => 'No se tiene suficientes puntos'));      
                           }      
                        } 
                        
                        
                        
                        else{
         
                            
                            if($newcount == null){ // verifica que exista algun vale en las tablas 
                                //$newnumero = Count_Voucher::where('id_station', '=', $countVaucher)->value('min'); // se le asigna el numero minimo que existe 
                                $cou  = Count_Voucher::where('id_station', '=', $voucher_valores->id_station)->value('id');
                            }
                            else{
                               $cou  = Count_Voucher::where('id_station', '=', $voucher_valores->id_station)->where('max', '>', $newcount)->value('id');
                            }
                            
                            if($cou == null){
                                $respuesta = json_encode(array('resultado' => 'Se acabaron los vales en esta estacion'));      
                            }
                            else{
                            $update = Voucher::where('id_station', '=', $convernumiden)
                            ->update(['id_count_voucher' => $cou]);
                             $newnumero  = Count_Voucher::where('id', '=', $cou)->value('min');                 
                            }
                            
                        
                     
                      $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                     $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Api",
                        'id_estacion' => $voucher_valores->id_station,
                        'punto' => $voucher_valores->points,
                        'value' => $voucher_valores->value,
                        'number_usuario' => $qr_memberships,
                        'estado' => 1,
                        'descrip' => "Se desconto",
                        'estado_uno' => $fecha, 
                        ]);
                  
                        
                         $tot = ($total_points - $voucher_valores->points);
                          $update = Memberships::where('id_users', '=', $id_us)
                          ->where('number_usuario', '=', $qr_memberships)
                          ->update(['totals' => $tot]);
         
                           $decrement = \DB::table('vouchers')->where('id_station', '=', $convernumiden)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                      // $url = $this->getUrlPrefix();
                      //return redirect()->to($url)->with('message', "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.");        
                      //enviar correo
                              $corre = User::where('username', '=', $username)->value('email');
                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                if($corre != ""){
                                                                                      
                                    $nombre = "contacto@digitalsoftlealtad.com";
                                    $de = "contacto@digitalsoftlealtad.com";
                                    $para = $corre;
                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                        
                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                        
                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                   $message->from('contacto@digitalsoftlealtad.com');
                                   $message->to($para);
                                   });
                               }
                      $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                }
                    }
                else{
                      $respuesta = json_encode(array('resultado' => 'Solo se permite 1 vale por dia'));      
                }
        
        
                 }
                 else{
                     $respuesta = json_encode(array('resultado' => 'No es un usuario.'));      
                                
                 }
        
        
          return response($respuesta);
      
                   
        
        
        
        
        
        
        
        
    }
    
    public function agregarvaleIOS(Request $request){
        
     
       $username = $request->username;
       $variable = $request->id;
       $convernumiden = (int) $variable;
      
        $id_us = User::where('username', '=', $username)->value('id');
               $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->value('role_id');
                 if($rol != ""){ //verifica si es un usuario
                    date_default_timezone_set("America/Mexico_City");
                    $fech = date('Y-m-d') ; $i = "$fech 00:00:00"; $f = "$fech 23:59:59";
                    $qr_memberships = Memberships::where('id_users', '=', $id_us)->value('number_usuario');
                   
                    $count1 = Exchange::where('number_usuario', '=', $qr_memberships)->where('estado_uno', '>=', $i)->where('estado_uno', '<=', $f)->count(); //contar del exchange
                    $count2 = History::where('number_usuario', '=', $qr_memberships)->where('todate', '>=', $i)->where('todate', '<=', $f)->count(); //contar del historial
                    $newcount1 = ($count1 + $count2); //suma los numeros existen en las 2 tablas
                    $countVaucher = Voucher::where('id_station', '=', $convernumiden)->value('id_count_voucher'); //id del contador de vaucher actual 
                     $maxVoucher = Count_Voucher::where('id', '=', $countVaucher)->value('max'); //saca el maximo del count vaucher
                     $idconvernumiden = Voucher::where('id_station', '=', $convernumiden)->value('id'); //id del contador de vaucher actual 
                    $voucher_valores = Voucher::findOrFail($idconvernumiden); //saca toda la fila de voucher
       
                    if($newcount1 < 1){ //cuenta los vaucher en general vales y premios y regresa si son menores a tres
                    $fecha = date('Y-m-d h:i') ; // Fecha 
                    //muestra el numero ultimo de exchange 
                    $count11 = Exchange::select('conta')->orderBy('conta', 'desc')->limit(1)->where('id_estacion', '=', $voucher_valores->id_station)->value('conta');
                    $count22 = History::select('numero')->orderBy('numero', 'desc')->limit(1)->where('id_station', '=', $voucher_valores->id_station)->value('numero');                              
                    if($count11 > $count22){ $newcount = $count11; } else {$newcount = $count22; }
                    $total_points = Memberships::where('id_users', '=', $id_us)->value('totals'); //total de puntos que se tienen
                    $number1 = (int)$count11;
                
                     if($number1 < $maxVoucher){ //verifica si el numero es menor al maximo de numero de vales que hay
                           if($total_points >= $voucher_valores->points){ //verifica si le alcansan los puntos a la membresia
                                $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                                $numero1 = Exchange::select('conta')->orderBy('conta', 'desc')->limit(1)->where('id_estacion', '=', $voucher_valores->id_station)->value('conta');
                                $numero2 = History::select('numero')->orderBy('numero', 'desc')->limit(1)->where('id_station', '=', $voucher_valores->id_station)->value('numero');
                        if($numero1 == null and $numero2 == null){ //verifica que los numeros no estan vacios
                                  $c  = Count_Voucher::where('id', '=', $countVaucher)->value('min');
                                  $newnumero = $c; //declara a nuevo numero con el minimo que existe
                                      
                                  $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                    $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Api",
                        'id_estacion' => $voucher_valores->id_station,
                        'punto' => $voucher_valores->points,
                        'value' => $voucher_valores->value,
                        'number_usuario' => $qr_memberships,
                        'estado' => 1,
                        'descrip' => "Se desconto",
                        'estado_uno' => $fecha, 
                        ]);
                         $tot = ($total_points - $voucher_valores->points);
                          $update = Memberships::where('id_users', '=', $id_us)
                          ->where('number_usuario', '=', $qr_memberships)
                          ->update(['totals' => $tot]);
         
                           $decrement = \DB::table('vouchers')->where('id_station', '=', $convernumiden)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                       //$url = $this->getUrlPrefix();
                      //return redirect()->to($url)->with('message', "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.");        
                      //enviar correo
                              $corre = User::where('username', '=', $username)->value('email');
                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                if($corre != ""){
                                                                                      
                                    $nombre = "contacto@digitalsoftlealtad.com";
                                    $de = "contacto@digitalsoftlealtad.com";
                                    $para = $corre;
                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                        
                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                        
                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                   $message->from('contacto@digitalsoftlealtad.com');
                                   $message->to($para);
                                   });
                               }
                                            $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                  
                                }
                                else{
                                   if($numero1 > $numero2){ $newnumero = $numero1+1; } else { $newnumero = $numero2+1;} //toma el valor maximo de cualquier de las 2 tablas
                                   
                                   $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                     $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Api",
                        'id_estacion' => $voucher_valores->id_station,
                        'punto' => $voucher_valores->points,
                        'value' => $voucher_valores->value,
                        'number_usuario' => $qr_memberships,
                        'estado' => 1,
                        'descrip' => "Se desconto",
                        'estado_uno' => $fecha, 
                        ]);
                  
                        
                         $tot = ($total_points - $voucher_valores->points);
                          $update = Memberships::where('id_users', '=', $id_us)
                          ->where('number_usuario', '=', $qr_memberships)
                          ->update(['totals' => $tot]);
         
                           $decrement = \DB::table('vouchers')->where('id_station', '=', $convernumiden)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                       //$url = $this->getUrlPrefix();
                      //return redirect()->to($url)->with('message', "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.");        
                
                //enviar correo
                              $corre = User::where('username', '=', $username)->value('email');
                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                if($corre != ""){
                                                                                      
                                    $nombre = "contacto@digitalsoftlealtad.com";
                                    $de = "contacto@digitalsoftlealtad.com";
                                    $para = $corre;
                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                        
                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                        
                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                   $message->from('contacto@digitalsoftlealtad.com');
                                   $message->to($para);
                                   });
                               }
                      $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                      
                                }     
                           }
                           else{
                                $respuesta = json_encode(array('resultado' => 'No se tiene suficientes puntos'));      
                           }      
                        } 
                        
                        
                        
                        else{
         
                            
                            if($newcount == null){ // verifica que exista algun vale en las tablas 
                                //$newnumero = Count_Voucher::where('id_station', '=', $countVaucher)->value('min'); // se le asigna el numero minimo que existe 
                                $cou  = Count_Voucher::where('id_station', '=', $voucher_valores->id_station)->value('id');
                            }
                            else{
                               $cou  = Count_Voucher::where('id_station', '=', $voucher_valores->id_station)->where('max', '>', $newcount)->value('id');
                            }
                            
                            if($cou == null){
                                $respuesta = json_encode(array('resultado' => 'Se acabaron los vales en esta estacion'));      
                            }
                            else{
                            $update = Voucher::where('id_station', '=', $convernumiden)
                            ->update(['id_count_voucher' => $cou]);
                             $newnumero  = Count_Voucher::where('id', '=', $cou)->value('min');                 
                            }
                            
                        
                     
                      $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                     $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Api",
                        'id_estacion' => $voucher_valores->id_station,
                        'punto' => $voucher_valores->points,
                        'value' => $voucher_valores->value,
                        'number_usuario' => $qr_memberships,
                        'estado' => 1,
                        'descrip' => "Se desconto",
                        'estado_uno' => $fecha, 
                        ]);
                  
                        
                         $tot = ($total_points - $voucher_valores->points);
                          $update = Memberships::where('id_users', '=', $id_us)
                          ->where('number_usuario', '=', $qr_memberships)
                          ->update(['totals' => $tot]);
         
                           $decrement = \DB::table('vouchers')->where('id_station', '=', $convernumiden)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                      // $url = $this->getUrlPrefix();
                      //return redirect()->to($url)->with('message', "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.");        
                      //enviar correo
                              $corre = User::where('username', '=', $username)->value('email');
                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                if($corre != ""){
                                                                                      
                                    $nombre = "contacto@digitalsoftlealtad.com";
                                    $de = "contacto@digitalsoftlealtad.com";
                                    $para = $corre;
                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                        
                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                        
                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                   $message->from('contacto@digitalsoftlealtad.com');
                                   $message->to($para);
                                   });
                               }
                      $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                }
                    }
                else{
                      $respuesta = json_encode(array('resultado' => 'Solo se permite 1 vale por dia'));      
                }
        
        
                 }
                 else{
                     $respuesta = json_encode(array('resultado' => 'No es un usuario.'));      
                                
                 }
        
        
          return response($respuesta);
      
                   
        
        
        
        
        
        
        
        
    }
    
    public function agregarpremio(Request $request){
         
       $username = $request->username;
       $estacion = $request->estacion;
       $premio = $request->premio;
     
      
        $id_us = User::where('username', '=', $username)->value('id');
               $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->value('role_id');
                 if($rol != ""){ //verifica si es un usuario
                    date_default_timezone_set("America/Mexico_City");
                    $fech = date('Y-m-d') ; $i = "$fech 00:00:00"; $f = "$fech 23:59:59";
                    $qr_memberships = Memberships::where('id_users', '=', $id_us)->value('number_usuario');
                 
                    $count1 = Exchange::where('number_usuario', '=', $qr_memberships)->where('estado_uno', '>=', $i)->where('estado_uno', '<=', $f)->where('descrip', '=', 'Premio')->count(); //contar del exchange
                    $count2 = History::where('number_usuario', '=', $qr_memberships)->where('todate', '>=', $i)->where('todate', '<=', $f)->where('id_exchange', '=', 2)->count(); //contar del historial
                    $newcount1 = ($count1 + $count2); //suma los numeros existen en las 2 tablas
                    $voucher_valores = Awards::findOrFail($premio); //saca toda la fila del premio
                  
                    if($newcount1 < 1){ //cuenta los vaucher en general vales y premios y regresa si son menores a uno
                    $fecha = date('Y-m-d h:i') ; // Fecha 
    
                    $total_points = Memberships::where('id_users', '=', $id_us)->value('totals'); //total de puntos que se tienen
                    
                
                           if($total_points >= $voucher_valores->points){ //verifica si le alcansan los puntos a la membresia
                                      
                                      $alea = Exchange::select('id')->where('descrip', '=', 'Premio')->orderBy('id', 'desc')->limit(1)->value('id');
                                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                                    
                                        $datos = Exchange::create([
                                        'identificador' => $folio,
                                        'conta' => $premio,
                                        'generado' => "Api",
                                        'id_estacion' => $estacion,
                                        'punto' => $voucher_valores->points,
                                        'value' => $voucher_valores->value,
                                        'number_usuario' => $qr_memberships,
                                        'estado' => 1,
                                        'descrip' => "Premio",
                                        'estado_uno' => $fecha, 
                                        ]);
                                         $tot = ($total_points - $voucher_valores->points);
                                          $update = Memberships::where('id_users', '=', $id_us)
                                          ->where('number_usuario', '=', $qr_memberships)
                                          ->update(['totals' => $tot]);
                         

                                           $station = Station::where('id', '=', $estacion)->value('name');
                                      
                                          //enviar correo
                                              $corre = User::where('username', '=', $username)->value('email');
                                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                                if($corre != ""){
                                                                                                      
                                                    $nombre = "ricardo.resendiz@digitalsoft.mx";
                                                    $de = "ricardo.resendiz@digitalsoft.mx";
                                                    $para = $corre;
                                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                                        
                                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                                        
                                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                                   $message->from('ricardo.resendiz@digitalsoft.mx');
                                                   $message->to($para);
                                                   });
                                               }
                                            $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                           }
                           else{
                                $respuesta = json_encode(array('resultado' => 'No se tiene suficientes puntos'));      
                           }      
                    }
                else{
                      $respuesta = json_encode(array('resultado' => 'Solo se permite 1 premio por dia'));      
                }
        
        
                 }
                 else{
                     $respuesta = json_encode(array('resultado' => 'No es un usuario.'));      
                                
                 }
        
        
          return response($respuesta);
      
                   
        
        
        
        
        
        
        
        
    }
    
    public function agregarpremioIOS(Request $request){
         
       $username = $request->username;
       $estacion = $request->estacion;
       $premio = $request->premio;
     
      
        $id_us = User::where('username', '=', $username)->value('id');
               $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->value('role_id');
                 if($rol != ""){ //verifica si es un usuario
                    date_default_timezone_set("America/Mexico_City");
                    $fech = date('Y-m-d') ; $i = "$fech 00:00:00"; $f = "$fech 23:59:59";
                    $qr_memberships = Memberships::where('id_users', '=', $id_us)->value('number_usuario');
                 
                    $count1 = Exchange::where('number_usuario', '=', $qr_memberships)->where('estado_uno', '>=', $i)->where('estado_uno', '<=', $f)->where('descrip', '=', 'Premio')->count(); //contar del exchange
                    $count2 = History::where('number_usuario', '=', $qr_memberships)->where('todate', '>=', $i)->where('todate', '<=', $f)->where('id_exchange', '=', 2)->count(); //contar del historial
                    $newcount1 = ($count1 + $count2); //suma los numeros existen en las 2 tablas
                    $voucher_valores = Awards::findOrFail($premio); //saca toda la fila del premio
                  
                    if($newcount1 < 1){ //cuenta los vaucher en general vales y premios y regresa si son menores a uno
                    $fecha = date('Y-m-d h:i') ; // Fecha 
    
                    $total_points = Memberships::where('id_users', '=', $id_us)->value('totals'); //total de puntos que se tienen
                    
                
                           if($total_points >= $voucher_valores->points){ //verifica si le alcansan los puntos a la membresia
                                      
                                      $alea = Exchange::select('id')->where('descrip', '=', 'Premio')->orderBy('id', 'desc')->limit(1)->value('id');
                                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                                    
                                        $datos = Exchange::create([
                                        'identificador' => $folio,
                                        'conta' => $premio,
                                        'generado' => "Api",
                                        'id_estacion' => $estacion,
                                        'punto' => $voucher_valores->points,
                                        'value' => $voucher_valores->value,
                                        'number_usuario' => $qr_memberships,
                                        'estado' => 1,
                                        'descrip' => "Premio",
                                        'estado_uno' => $fecha, 
                                        ]);
                                         $tot = ($total_points - $voucher_valores->points);
                                          $update = Memberships::where('id_users', '=', $id_us)
                                          ->where('number_usuario', '=', $qr_memberships)
                                          ->update(['totals' => $tot]);
                         

                                           $station = Station::where('id', '=', $estacion)->value('name');
                                      
                                          //enviar correo
                                              $corre = User::where('username', '=', $username)->value('email');
                                              $poi = \DB::table('tarjeta')->where('number_usuario', "=", $username)->value('totals');
                                                if($corre != ""){
                                                                                                      
                                                    $nombre = "ricardo.resendiz@digitalsoft.mx";
                                                    $de = "ricardo.resendiz@digitalsoft.mx";
                                                    $para = $corre;
                                                    $asunto  = "Se cagaron los puntos correctamente";
                                                                                                        
                                                   $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'puntos' => $tot, 'total' => $poi);
                                                                                        
                                                   Mail::send('mails.mails2', $data, function($message) use($de, $para){
                                                   $message->from('ricardo.resendiz@digitalsoft.mx');
                                                   $message->to($para);
                                                   });
                                               }
                                            $respuesta = json_encode(array('resultado' => "Recuerda presentar este Folio $folio junto con tu identificación oficial en la estación que seleccionaste, Recuerda que solo en esta estación $station se podra entregar.")); 
                           }
                           else{
                                $respuesta = json_encode(array('resultado' => 'No se tiene suficientes puntos'));      
                           }      
                    }
                else{
                      $respuesta = json_encode(array('resultado' => 'Solo se permite 1 premio por dia'));      
                }
        
        
                 }
                 else{
                     $respuesta = json_encode(array('resultado' => 'No es un usuario.'));      
                                
                 }
        
        
          return response($respuesta);
      
                   
        
        
        
        
        
        
        
        
    }
    
}