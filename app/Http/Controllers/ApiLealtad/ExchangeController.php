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

class ExchangeController extends Controller
{

 
    public function exchange(Request $request){
    
     $username = $request->username;
    // $perfilall = Exchange::where('qr_memberships', '=', $username)->get();
      $perfilall = History::
                join('station', 'history.id_station', '=', 'station.id')
                ->where('history.number_usuario', '=', $username)  
                ->where('history.id_exchange', '=', 1)
               ->get();
    $existe = History::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function exchangeDisponibles(Request $request){
    
     $username = $request->username;
      $perfilall = Exchange::
                join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->where('canjes.number_usuario', '=', $username)  
                ->where('canjes.estado', '>=', 1)  
                ->where('canjes.descrip', '!=', 'Premio')  
                ->get();
    $existe = Exchange::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    //VALES IOS -____________________________________________________________-
    public function exchangeIOS(Request $request){
    
     $username = $request->username;
    // $perfilall = Exchange::where('qr_memberships', '=', $username)->get();
      $perfilall = History::
                join('station', 'history.id_station', '=', 'station.id')
                ->where('history.number_usuario', '=', $username)  
                ->where('history.id_exchange', '=', 1)
               ->get();
    $existe = History::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode($perfilall);      
     }
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function exchangeDisponiblesIOS(Request $request){
    
     $username = $request->username;
      $perfilall = Exchange::select('canjes.id', 'canjes.id_estacion', 'canjes.identificador', 'canjes.estado_uno', 'station.name', 'canjes.estado', 'cat_state.name_state')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->where('canjes.number_usuario', '=', $username)  
                ->where('canjes.estado', '>=', 1)  
                ->where('canjes.descrip', '!=', 'Premio')  
                ->get();
    $existe = Exchange::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode($perfilall);      
     }
       
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    //PREMIOS ---------------------------------------------------------------
    public function exchangepremios(Request $request){
    
     $username = $request->username;
    // $perfilall = Exchange::where('qr_memberships', '=', $username)->get();
      $perfilall = History::
                join('station', 'history.id_station', '=', 'station.id')
                ->join('awards', 'history.numero', '=', 'awards.id')
                ->where('history.number_usuario', '=', $username)  
                ->where('history.id_exchange', '=', 2)
               ->get();
    $existe = History::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function exchangeDisponiblespremios(Request $request){
    
     $username = $request->username;
      $perfilall = Exchange::
                join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.number_usuario', '=', $username)  
                ->where('canjes.estado', '>=', 1)  
                ->where('canjes.descrip', '=', 'Premio')  
                ->get();
                
    $existe = Exchange::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode(array('resultado' => $perfilall));      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    //IOS************************************************************************
    
    public function exchangeDisponiblespremiosIOS(Request $request){
    
     $username = $request->username;
      $perfilall = Exchange::select('canjes.id', 'canjes.id_estacion', 'canjes.identificador', 'canjes.estado_uno', 'station.name', 'canjes.estado', 'cat_state.name_state')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.number_usuario', '=', $username)  
                ->where('canjes.estado', '>=', 1)  
                ->where('canjes.descrip', '=', 'Premio')  
                ->get();
                
    $existe = Exchange::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode($perfilall);      
     }
     
             
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    public function exchangepremiosIOS(Request $request){
    
     $username = $request->username;
    // $perfilall = Exchange::where('qr_memberships', '=', $username)->get();
      $perfilall = History::
                join('station', 'history.id_station', '=', 'station.id')
                ->join('awards', 'history.numero', '=', 'awards.id')
                ->where('history.number_usuario', '=', $username)  
                ->where('history.id_exchange', '=', 2)
               ->get();
    $existe = History::where('number_usuario', '=', $username)->value("id");
     
     if($existe != ""){
        $respuesta = json_encode($perfilall);      
     }
           
        return response($respuesta);
        //return response()->json($beneficios);

    }
    
    
    
}