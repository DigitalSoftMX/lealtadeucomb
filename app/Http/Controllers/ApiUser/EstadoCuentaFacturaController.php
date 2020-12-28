<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Facturas;
use App\Models\Catalogos\CatFacturas;
use App\Models\Lealtad\Station;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class EstadoCuentaFacturaController extends Controller
{

 
    public function estadocuenta(Request $request){
    
     $mes = $request->mes;
     $year = "2020";
     $username = $request->username;
     $existe = User::where('username', '=', $username)->value("id");
     
     //dd($request->all());
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
     
     $esta = Station::where('name', '=', $request->estacion)->value("id");
      
     // dd($existe);
      $perfilall = Facturas::
                select('facturas.id','facturas.folio as folio', 'facturas.created_at', 'facturas.descripcion as combustible', 'facturas.archivopdf as archivo', 'tickets.litro as litros', 'station.name as namestation')
                ->join('station', 'facturas.id_estacion', '=', 'station.id')
                ->join('tickets', 'facturas.folio', '=', 'tickets.number_ticket')
                ->where('facturas.id_receptor', '=', $existe)
                ->where('facturas.created_at', '>=', $inicial)
                ->where('facturas.created_at', '<=', $final)
                ->where('facturas.id_estacion', '=', $esta)
                ->orderBy('facturas.created_at', 'desc')
                ->get();
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
     $year = "2020";
     $username = $request->username;
     $existe = User::where('username', '=', $username)->value("id");
     
     //dd($request->all());
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
     
     $esta = Station::where('name', '=', $request->estacion)->value("id");
      
     // dd($existe);
      $perfilall = Facturas::
                select('facturas.id','facturas.folio as folio', 'facturas.created_at', 'facturas.descripcion as combustible', 'facturas.archivopdf as archivo', 'tickets.litro as litros', 'station.name as namestation')
                ->join('station', 'facturas.id_estacion', '=', 'station.id')
                ->join('tickets', 'facturas.folio', '=', 'tickets.number_ticket')
                ->where('facturas.id_receptor', '=', $existe)
                ->where('facturas.created_at', '>=', $inicial)
                ->where('facturas.created_at', '<=', $final)
                ->where('facturas.id_estacion', '=', $esta)
                ->orderBy('facturas.created_at', 'desc')
                ->get();
     if($perfilall != ""){
        $respuesta = json_encode($perfilall);      
     }
     else{
        $respuesta = json_encode(array('resultado' => "error"));      
     }    
             
        return response($respuesta);
    
    }
    
      public function estaciones(Request $request){
  
          $estaciones = Station::select('station.name')->get();
            //$respuesta = json_encode($estaciones); 
            $respuesta = json_encode(array('resultado' => $estaciones));      
              return response($respuesta);
    
      }
      
       public function estacionesios(Request $request){
  
          $estaciones = Station::select('station.name')->get();
            //$respuesta = json_encode($estaciones); 
            $respuesta = json_encode($estaciones);      
              return response($respuesta);
    
      }
    
}