<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Role;
use App\Models\Catalogos\Permission;
use App\Models\Catalogos\Permission_Role;
use App\Models\Catalogos\CatBombas;
use App\Models\Catalogos\Empresas;
use App\Models\Catalogos\CatFacturas;
use App\Models\Catalogos\CatPrecios;
use App\Models\Catalogos\Facturas;
use App\Models\Catalogos\FacturaEmisor;
use App\Models\Catalogos\FacturaReceptor;
use App\Models\Catalogos\Pagos;
use App\Models\Catalogos\UserEstaciones;
use App\Models\Lealtad\Memberships;
use App\Models\Lealtad\Station;
use App\Models\Lealtad\Tickets;
use App\Models\Lealtad\Movement;
use App\Models\Lealtad\Voucher;
use App\Models\Lealtad\Awards;
use App\Models\Lealtad\Exchange;
use App\Models\Lealtad\History;
use App\Models\Lealtad\Dispatcher;
use App\Models\Lealtad\Change_Memberships;
use App\Models\Lealtad\ConjuntoMembership;
use App\Models\Lealtad\DoublePoints;
use App\Models\Lealtad\Count_Voucher;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
    
        $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1 || $rol == 2) { //verifica si es un usuario
           //dd($rol);
           //Lealtad
           $premio1 = \DB::table('canjes')->count();
           $premio2 = \DB::table('history')->count();
           $premio = $premio1 + $premio2;
           $litros = \DB::table('tickets')->sum('litro');
           $usuarios = \DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->count();
           $tickets = \DB::table('tickets')->count();
           $estaciones = Station::all();
           $totalEstaciones = count($estaciones);
           
          $year = "2020";
          //PREMIUM
          $timbresEstacionM = array();
          for ($i = 1; $i <= 12; $i++) {
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Magna")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->count();
              array_push($timbresEstacionM,$magnaene);
          }
          //MAGNA
          $timbresEstacionP = array();
          for ($i = 1; $i <= 12; $i++) {
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Premium")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->count();
              array_push($timbresEstacionP,$magnaene);
          }
          //*************************************************************************************************
            //GRAFICA DE PASTEL
            //litros
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
            //GRAFICA DE MESES
            $timbresEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL LITROS POR MES
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $ttick = Tickets::select(\DB::raw("SUM(litro) as total"))
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->value('total');
              array_push($timbresEstacionXM,$ttick);
            }
            //******************************************************************************************
            //GRAFICA DE PASTEL
            //HISTORIAL TOTAL 
            $graficavales = \DB::table('history')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'history.id_station', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $valesEstacioness = array();
            $valesnombreEstacioness = array();
            foreach ($graficavales as $graficavale) {
                array_push($valesnombreEstacioness, $graficavale->name);
                array_push($valesEstacioness,$graficavale->total);
            }
            
            //GRAFICA POR MES
            $valesEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL CANJES EN EL HISTORIAL 
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tval = History::where('history.todate', '>=', $inicial)
                    ->where('history.todate', '<=', $final)
                    ->count();
              array_push($valesEstacionXM,$tval);
            }
            
            //*************************************************************************************************
            //GRAFICA DE PASTEL
            //TICKETS
            $graficafolios = \DB::table('tickets')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            //dd($graficafolios);
            $nombreEstacionesss = array();
            $foliosEstacionesss = array();
            foreach ($graficafolios as $graficafolio) {
                array_push($nombreEstacionesss, $graficafolio->name);
                array_push($foliosEstacionesss, $graficafolio->total);
            }
            //GRAFICA DE MESES
            $foliosEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL LITROS POR MES
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tttick = Tickets::select(\DB::raw("COUNT(*) as total"))
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->value('total');
              array_push($foliosEstacionXM,$tttick);
            }
            
            //dd($graficavales);
            //**********************************************************************************************
            //TICKETS POR PRODUCTO
            //combustible
            $R = Tickets::where('producto', '=', 'Magna')
            ->count();
            $P = Tickets::where('producto', '=', 'Premium')
            ->count();     
           
            //TOTAL USUARIO POR SEXO
            $H = User::select('sex')
            ->where('sex', '=', 'H')
            ->count();     
            $M = User::select('sex')
            ->where('sex', '=', 'M')
            ->count();     
            
            
           //facturacion
           /* $estaciones = Station::all();
            $preciotim = CatPrecios::value('costo_timbre');
            $abonospen = Pagos::where('autorizado', "=", 1)->get();
            $totalEstaciones = count($estaciones);
            $totalTimbres = 0;
            $precioTimbre = $preciotim;
            $pendientes = count($abonospen);
            $nombreEstaciones = array();
            $timbresEstacion = array();
            foreach ($estaciones as $estacion) {
                $totalTimbres += $estacion->total_timbres;
                array_push($nombreEstaciones, $estacion->name);
                array_push($timbresEstacion,$estacion->total_timbres);
            }*/
            
            //Lealtad
            /*$graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }*/
            
            return view('pages.dashboard', compact('totalEstaciones', 'totalTimbres', 'precioTimbre', 'pendientes','timbresEstacionM','timbresEstacionP','litros','usuarios','tickets','premio', 
            'nombreEstaciones','nombreEstacioness','nombreEstacionesss','litrosEstacioness','timbresEstacion','foliosEstacionesss','R', 'P', 'H', 'M', 'timbresEstacionXM', 'valesEstacionXM','foliosEstacionXM', 'valesEstacioness','valesnombreEstacioness'));
  
           }
           /*else if ($rol == 2) { //verifica si es un usuario
               
            //Lealtad
           $premio1 = \DB::table('canjes')->where('descrip', '=', 'Premio')->count();
           $premio2 = \DB::table('history')->where('id_exchange', '=', 2)->count();
           $premio = $premio1 + $premio2;
           $litros = \DB::table('tickets')->sum('litro');
           $usuarios = \DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->count();
           $tickets = \DB::table('tickets')->count();
    
           //facturacion
            $estaciones = Station::all();
            $preciotim = CatPrecios::value('costo_timbre');
            $abonospen = Pagos::where('autorizado', "=", 1)->get();
            $totalEstaciones = count($estaciones);
            $totalTimbres = 0;
            $precioTimbre = $preciotim;
            $pendientes = count($abonospen);
            $nombreEstaciones = array();
            $timbresEstacion = array();
            foreach ($estaciones as $estacion) {
                $totalTimbres += $estacion->total_timbres;
                array_push($nombreEstaciones, $estacion->name);
                array_push($timbresEstacion,$estacion->total_timbres);
            }
            
            //Lealtad
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
           }*/
           else if ($rol == 3) { //verifica si es un usuario
        
           $station = UserEstaciones::where('id_users', '=', $id)->value('id_station');
            
            //Lealtad
           $premio1 = \DB::table('canjes')->where('descrip', '=', 'Premio')->where('id_estacion', '=', $station)->count();
           $premio2 = \DB::table('history')->where('id_exchange', '=', 2)->where('id_station', '=', $station)->count();
           $premio = $premio1 + $premio2;
           $litros = \DB::table('tickets')->select(\DB::raw('SUM(litro) as litro'))->where('id_gas', '=', $station)->value('litro');                 
      
           $usuarios = \DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->count();
           $tickets = \DB::table('tickets')->where('id_gas', '=', $station)->count();
           
           $estaciones = Station::all();
           $totalEstaciones = count($estaciones);
           
          $year = "2020";
          $timbresEstacionM = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Magna")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('id_gas', '=', $station)
                    ->count();
              array_push($timbresEstacionM,$magnaene);
          }
          
          $timbresEstacionP = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Premium")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('id_gas', '=', $station)
                    ->count();
              array_push($timbresEstacionP,$magnaene);
          }
            
            //litros
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->where('id_gas', '=', $station)
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
            
            $timbresEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $ttick = Tickets::where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('id_gas', '=', $station)
                    ->count();
              array_push($timbresEstacionXM,$ttick);
            }
            
            //vales
            $graficavales = \DB::table('history')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'history.id_station', '=', 'station.id')
            ->where('id_station', '=', $station)
            ->groupBy('station.name')
            ->get();
            $valesEstacioness = array();
            $valesnombreEstacioness = array();
            foreach ($graficavales as $graficavale) {
                array_push($valesnombreEstacioness, $graficavale->name);
                array_push($valesEstacioness,$graficavale->total);
            }
            
            $valesEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tval = History::where('history.todate', '>=', $inicial)
                    ->where('history.todate', '<=', $final)
                    ->where('id_station', '=', $station)
                    ->count();
              array_push($valesEstacionXM,$tval);
            }
            //dd($graficavales);
            
            
             //*************************************************************************************************
            //GRAFICA DE PASTEL
            //TICKETS
            $graficafolios = \DB::table('tickets')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->where('id_gas', '=', $station)
            ->groupBy('station.name')
            ->get();
            //dd($graficafolios);
            $nombreEstacionesss = array();
            $foliosEstacionesss = array();
            foreach ($graficafolios as $graficafolio) {
                array_push($nombreEstacionesss, $graficafolio->name);
                array_push($foliosEstacionesss, $graficafolio->total);
            }
            //GRAFICA DE MESES
            $foliosEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL LITROS POR MES
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tttick = Tickets::select(\DB::raw("COUNT(*) as total"))
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                     ->where('id_gas', '=', $station)
                    ->value('total');
              array_push($foliosEstacionXM,$tttick);
            }
            
            //combustible
            $R = Tickets::where('producto', '=', 'Magna')->where('id_gas', '=', $station)
            ->count();
            $P = Tickets::where('producto', '=', 'Premium')->where('id_gas', '=', $station)
            ->count();     
                   
            return view('pages.dashboard', compact('totalEstaciones', 'totalTimbres', 'precioTimbre', 'pendientes','timbresEstacionM','timbresEstacionP','litros','usuarios','tickets','premio', 
            'nombreEstaciones','nombreEstacioness','nombreEstacionesss','litrosEstacioness','timbresEstacion','foliosEstacionesss','R', 'P', 'H', 'M', 'timbresEstacionXM', 'valesEstacionXM','foliosEstacionXM', 'valesEstacioness','valesnombreEstacioness'));
  
           }
           else if ($rol == 5) { //verifica si es un usuario
                    
             $ids = \Auth::user()->id;
             $usuario = User::where('id', '=', $ids)->value('username');
            
           //Lealtad
           $premio1 = \DB::table('canjes')->where('descrip', '=', 'Premio')->where('number_usuario', '=', $usuario)->count();
           $premio2 = \DB::table('history')->where('id_exchange', '=', 2)->where('number_usuario', '=', $usuario)->count();
           $premio = $premio1 + $premio2;
           $litros = \DB::table('tickets')->where('number_usuario', '=', $usuario)->sum('litro');
           $usuarios = \DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->count();
           $tickets = \DB::table('tickets')->where('number_usuario', '=', $usuario)->count();
           $estaciones = Station::all();
           $totalEstaciones = count($estaciones);
           
          $year = "2020";
          $timbresEstacionM = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Magna")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('number_usuario', '=', $usuario)
                    ->count();
              array_push($timbresEstacionM,$magnaene);
          }
          
          $timbresEstacionP = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Premium")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('number_usuario', '=', $usuario)
                    ->count();
              array_push($timbresEstacionP,$magnaene);
          }
            
            //litros
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->where('number_usuario', '=', $usuario)
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
            
            $timbresEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $ttick = Tickets::where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('number_usuario', '=', $usuario)
                    ->count();
              array_push($timbresEstacionXM,$ttick);
            }
            
            //vales
            $graficavales = \DB::table('history')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'history.id_station', '=', 'station.id')
            ->where('number_usuario', '=', $usuario)
            ->groupBy('station.name')
            ->get();
            $valesEstacioness = array();
            $valesnombreEstacioness = array();
            foreach ($graficavales as $graficavale) {
                array_push($valesnombreEstacioness, $graficavale->name);
                array_push($valesEstacioness,$graficavale->total);
            }
            
            $valesEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tval = History::where('history.todate', '>=', $inicial)
                    ->where('history.todate', '<=', $final)
                    ->where('number_usuario', '=', $usuario)
                    ->count();
              array_push($valesEstacionXM,$tval);
            }
            //dd($graficavales);
            
            //combustible
            $R = Tickets::where('producto', '=', 'Magna')->where('number_usuario', '=', $usuario)
            ->count();
            $P = Tickets::where('producto', '=', 'Premium')->where('number_usuario', '=', $usuario)
            ->count();     
           
            
            $H = User::select('sex')
            ->where('sex', '=', 'H')
            ->where('username', '=', $usuario)
            ->count();     
            $M = User::select('sex')
            ->where('username', '=', $usuario)
            ->where('sex', '=', 'M')
            ->count();     
            
            
           //facturacion
           /* $estaciones = Station::all();
            $preciotim = CatPrecios::value('costo_timbre');
            $abonospen = Pagos::where('autorizado', "=", 1)->get();
            $totalEstaciones = count($estaciones);
            $totalTimbres = 0;
            $precioTimbre = $preciotim;
            $pendientes = count($abonospen);
            $nombreEstaciones = array();
            $timbresEstacion = array();
            foreach ($estaciones as $estacion) {
                $totalTimbres += $estacion->total_timbres;
                array_push($nombreEstaciones, $estacion->name);
                array_push($timbresEstacion,$estacion->total_timbres);
            }*/
            
            //Lealtad
            /*$graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }*/
            
            return view('pages.dashboardEstaciones', compact('totalEstaciones', 'totalTimbres', 'precioTimbre', 'pendientes','timbresEstacionM','timbresEstacionP','litros','usuarios','tickets','premio', 
            'nombreEstaciones','nombreEstacioness','litrosEstacioness','timbresEstacion','R', 'P', 'H', 'M', 'timbresEstacionXM', 'valesEstacionXM', 'valesEstacioness','valesnombreEstacioness'));
  
            
           }
           
           else if ($rol == 6) { //verifica si es un usuario
                   
           //Lealtad
           $premio1 = \DB::table('canjes')->count();
           $premio2 = \DB::table('history')->count();
           $premio = $premio1 + $premio2;
           $litros = \DB::table('tickets')->sum('litro');
           $usuarios = \DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->count();
           $tickets = \DB::table('tickets')->count();
           $estaciones = Station::all();
           $totalEstaciones = count($estaciones);
           
          $year = "2020";
          $timbresEstacionM = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Magna")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->count();
              array_push($timbresEstacionM,$magnaene);
          }
          
          $timbresEstacionP = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Premium")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->count();
              array_push($timbresEstacionP,$magnaene);
          }
            
            //litros
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
            
            $timbresEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $ttick = Tickets::where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->count();
              array_push($timbresEstacionXM,$ttick);
            }
            
            //vales
            $graficavales = \DB::table('history')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'history.id_station', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $valesEstacioness = array();
            $valesnombreEstacioness = array();
            foreach ($graficavales as $graficavale) {
                array_push($valesnombreEstacioness, $graficavale->name);
                array_push($valesEstacioness,$graficavale->total);
            }
            
            $valesEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tval = History::where('history.todate', '>=', $inicial)
                    ->where('history.todate', '<=', $final)
                    ->count();
              array_push($valesEstacionXM,$tval);
            }
            //dd($graficavales);
            
            //combustible
            $R = Tickets::where('producto', '=', 'Magna')
            ->count();
            $P = Tickets::where('producto', '=', 'Premium')
            ->count();     
           
            
            $H = User::select('sex')
            ->where('sex', '=', 'H')
            ->count();     
            $M = User::select('sex')
            ->where('sex', '=', 'M')
            ->count();     
            
            return view('pages.dashboardAdmin', compact('totalEstaciones', 'totalTimbres', 'precioTimbre', 'pendientes','timbresEstacionM','timbresEstacionP','litros','usuarios','tickets','premio', 
            'nombreEstaciones','nombreEstacioness','litrosEstacioness','timbresEstacion','R', 'P', 'H', 'M', 'timbresEstacionXM', 'valesEstacionXM', 'valesEstacioness','valesnombreEstacioness'));
  
            
           }
       
    }
    
    public function timbres(Request $request){
        $facturaEmisor=\DB::table('factura_emisor')->where('id_user','=','2')->get();
        return view('../Catalogos/default/timbre/timbres',compact('facturaEmisor','request'));
    }
    
    //GRAFICAS******************************************************************************************************
    
    public function graficas()
    {
    
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
    
           //timbres
            $estaciones = Station::all();
            $nombreEstaciones = array();
            $timbresEstacion = array();
            foreach ($estaciones as $estacion) {
                array_push($nombreEstaciones, $estacion->name);
                array_push($timbresEstacion,$estacion->total_timbres);
            }
            
            //litros
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
            
            //combustible
            $R = Tickets::where('producto', '=', 'Regular')
            ->count();
            $P = Tickets::where('producto', '=', 'Premium')
            ->count();     
            $D = Tickets::where('producto', '=', 'Diesel')
            ->count();   
            
            $H = User::select('sex')
            ->where('sex', '=', 'H')
            ->count();     
            $M = User::select('sex')
            ->where('sex', '=', 'M')
            ->count();     
            //dd($R);
           }
       
          return view('pages.graficas', compact('nombreEstaciones','nombreEstacioness','litrosEstacioness','timbresEstacion','R', 'P', 'D', 'H', 'M'));
    }
    
       public function graficasfilter(Request $request)
    {
     
        $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
               /*    
               //Filter ---------------------------------------------------------------------
                if ($request->min != "" && $request->max != "" && $request->station != ""){
                    $i = $request->min . " 00:00:00";
                    $f = $request->max . " 23:59:59";
             
               //timbres
                $estaciones = Station::where('id', '=', $request->station)->get();
                $nombreEstaciones = array();
                $timbresEstacion = array();
                foreach ($estaciones as $estacion) {
                    array_push($nombreEstaciones, $estacion->name);
                    array_push($timbresEstacion,$estacion->total_timbres);
                }
                
                //litros
                $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.id_gas', '=', $request->station)
                ->where('tickets.created_at', '>=', $i)
                ->where('tickets.created_at', '<=', $f)
                ->groupBy('station.name')
                ->get();
                $nombreEstacioness = array();
                $litrosEstacioness = array();
                foreach ($graficatickets as $graficaticket) {
                    array_push($nombreEstacioness, $graficaticket->name);
                    array_push($litrosEstacioness,$graficaticket->total);
                }
                
                 //combustible
                $R = Tickets::where('producto', '=', 'Regular')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('tickets.id_gas', '=', $request->station)
                ->count();
                $P = Tickets::where('producto', '=', 'Premium')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('tickets.id_gas', '=', $request->station)
                ->count();     
                $D = Tickets::where('producto', '=', 'Diesel')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('tickets.id_gas', '=', $request->station)
                ->count();   
                
                $H = User::select('sex')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('sex', '=', 'H')
                ->count();     
                $M = User::select('sex')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('sex', '=', 'M')
                ->count();     
               }
               //Filter ---------------------------------------------------------------------
                elseif ($request->min != "" && $request->max != ""){
                    $i = $request->min . " 00:00:00";
                    $f = $request->max . " 23:59:59";
             
               //timbres
                $estaciones = Station::all();
                $nombreEstaciones = array();
                $timbresEstacion = array();
                foreach ($estaciones as $estacion) {
                    array_push($nombreEstaciones, $estacion->name);
                    array_push($timbresEstacion,$estacion->total_timbres);
                }
                
                //litros
                $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.created_at', '>=', $i)
                ->where('tickets.created_at', '<=', $f)
                ->groupBy('station.name')
                ->get();
                $nombreEstacioness = array();
                $litrosEstacioness = array();
                foreach ($graficatickets as $graficaticket) {
                    array_push($nombreEstacioness, $graficaticket->name);
                    array_push($litrosEstacioness,$graficaticket->total);
                }
                
                 //combustible
                $R = Tickets::where('producto', '=', 'Regular')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->count();
                $P = Tickets::where('producto', '=', 'Premium')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->count();     
                $D = Tickets::where('producto', '=', 'Diesel')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->count();   
                
                $H = User::select('sex')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('sex', '=', 'H')
                ->count();     
                $M = User::select('sex')->where('created_at', '>=', $i)
                ->where('created_at', '<=', $f)
                ->where('sex', '=', 'M')
                ->count();     
               }*/
               //Filter ---------------------------------------------------------------------
                if ($request->station != ""){
               
           //Lealtad
           $premio1 = \DB::table('canjes')->where('descrip', '=', 'Premio')->count();
           $premio2 = \DB::table('history')->where('id_exchange', '=', 2)->count();
           $premio = $premio1 + $premio2;
           $litros = \DB::table('tickets')->sum('litro');
           $usuarios = \DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->count();
           $tickets = \DB::table('tickets')->count();
           $estaciones = Station::all();
           $totalEstaciones = count($estaciones);
           
          $year = "2020";
          $timbresEstacionM = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Magna")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('id_gas', '=', $request->station)
                    ->count();
              array_push($timbresEstacionM,$magnaene);
          }
          
          $timbresEstacionP = array();
          for ($i = 1; $i <= 12; $i++) {
              //ENERO ************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $magnaene = Tickets::where('producto', "=", "Premium")
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('id_gas', '=', $request->station)
                    ->count();
              array_push($timbresEstacionP,$magnaene);
          }
            
            //litros
            $graficatickets = \DB::table('tickets')->select("station.name", \DB::raw("SUM(litro) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
            ->where('id_gas', '=', $request->station)
            ->groupBy('station.name')
            ->get();
            $nombreEstacioness = array();
            $litrosEstacioness = array();
            foreach ($graficatickets as $graficaticket) {
                array_push($nombreEstacioness, $graficaticket->name);
                array_push($litrosEstacioness,$graficaticket->total);
            }
            
            $timbresEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $ttick = Tickets::select(\DB::raw("SUM(litro) as total"))
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                    ->where('id_gas', '=', $request->station)
                    ->value('total');
            
              array_push($timbresEstacionXM,$ttick);
            }
            
            //vales
            $graficavales = \DB::table('history')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'history.id_station', '=', 'station.id')
            ->where('id_station', '=', $request->station)
            ->groupBy('station.name')
            ->get();
            $valesEstacioness = array();
            $valesnombreEstacioness = array();
            foreach ($graficavales as $graficavale) {
                array_push($valesnombreEstacioness, $graficavale->name);
                array_push($valesEstacioness,$graficavale->total);
            }
            
            $valesEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL************************************************************
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tval = History::where('history.todate', '>=', $inicial)
                    ->where('history.todate', '<=', $final)
                    ->where('id_station', '=', $request->station)
                    ->count();
              array_push($valesEstacionXM,$tval);
            }
            
             //*************************************************************************************************
            //GRAFICA DE PASTEL
            //TICKETS
            $graficafolios = \DB::table('tickets')->select("station.name", \DB::raw("COUNT(*) as total"))
            ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->where('id_gas', '=', $request->station)
            ->groupBy('station.name')
            ->get();
            //dd($graficafolios);
            $nombreEstacionesss = array();
            $foliosEstacionesss = array();
            foreach ($graficafolios as $graficafolio) {
                array_push($nombreEstacionesss, $graficafolio->name);
                array_push($foliosEstacionesss, $graficafolio->total);
            }
            //GRAFICA DE MESES
            $foliosEstacionXM = array();
             for ($i = 1; $i <= 12; $i++) {
              //TOTAL LITROS POR MES
              if($i==1){$valor = "01";}elseif($i==2){$valor = "02";}elseif($i==3){$valor = "03";}elseif($i==4){$valor = "04";}elseif($i==5){$valor = "05";}elseif($i==6){$valor = "06";}
              elseif($i==7){$valor = "07";}elseif($i==8){$valor = "08";}elseif($i==9){$valor = "09";}elseif($i==10){$valor = "10";}elseif($i==11){$valor = "11";}elseif($i==12){$valor = "12";}
              $inicial = $year . "-" . $valor . "-" . "01" . " " . "00:00:00";
              $final =   $year . "-" . $valor . "-" . "31" . " " . "24:59:59";
              $tttick = Tickets::select(\DB::raw("COUNT(*) as total"))
                    ->where('tickets.created_at', '>=', $inicial)
                    ->where('tickets.created_at', '<=', $final)
                     ->where('id_gas', '=', $request->station)
                    ->value('total');
              array_push($foliosEstacionXM,$tttick);
            }
            
            //dd($graficavales);
            
            //combustible
            $R = Tickets::where('producto', '=', 'Magna')->where('id_gas', '=', $request->station)
            ->count();
            $P = Tickets::where('producto', '=', 'Premium')->where('id_gas', '=', $request->station)
            ->count();     
            
             return view('pages.dashboard', compact('totalEstaciones', 'totalTimbres', 'precioTimbre', 'pendientes','timbresEstacionM','timbresEstacionP','litros','usuarios','tickets','premio', 
            'nombreEstaciones','nombreEstacioness','nombreEstacionesss','litrosEstacioness','timbresEstacion','foliosEstacionesss','R', 'P', 'H', 'M', 'timbresEstacionXM', 'valesEstacionXM','foliosEstacionXM', 'valesEstacioness','valesnombreEstacioness'));
  
               
                  
               }
               else{
                          return redirect()->to('/')->withStatus(__('Selecciona alguna estacion.'));
               }
        }
                   return view('pages.graficas', compact('nombreEstaciones','nombreEstacioness','litrosEstacioness','timbresEstacion','R', 'P', 'D', 'H', 'M'));
 
    }
}
