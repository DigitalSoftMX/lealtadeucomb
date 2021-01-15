<?php

namespace App\Core\Util;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
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
use App\Models\Lealtad\Client;
use App\Models\Lealtad\Station;
use App\Models\Lealtad\Tickets;
use App\Models\Lealtad\Movement;
use App\Models\Lealtad\Voucher;
use App\Models\Lealtad\Awards;
use App\Models\Lealtad\Exchange;
use App\Models\Lealtad\Exchange_Award;
use App\Models\Lealtad\History;
use App\Models\Lealtad\Dispatcher;
use App\Models\Lealtad\Change_Memberships;
use App\Models\Lealtad\ConjuntoMembership;
use App\Models\Lealtad\DoblePuntos;
use App\Models\Lealtad\Count_Voucher;
use App\Models\Lealtad\UserEstacion;
use Illuminate\Support\Facades\Storage;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use SimpleXMLElement;
use App\Http\Controllers\SWServices\Authentication\AuthenticationService as Authentication;
use App\Http\Controllers\SWServices\Stamp\StampService as StampService;
use App\Http\Controllers\SWServices\JSonIssuer\JsonIssuerService as jsonEmisionTimbrado;
use App\Http\Controllers\SWServices\JSonIssuer\JsonIssuerRequest as jsonIssuerRequest;
use App\Http\Controllers\SWServices\Services as Services;
use App\Http\Controllers\SWServices\JSonCuenta\JsonCuentaService as jsonCuenta;
use App\Http\Controllers\SWServices\JSonCuenta\JsonCuentaRequest as jsonCuentaRequest;
use App\Http\Controllers\SWServices\Csd\CsdService as CsdService;

trait CatalogTrait
{
    public $list_form = null;
    public $form = null;
    public $tpl_prefix = 'Catalogos.default.';
    public $tpl_list_data = null;
    public $url_prefix = null;
    public $model = null;
    public $field_list = ['id' => 'id'];
    public $form_id = null;
    public $name = null;
    public $name_plural = null;
    protected $validators = ['add' => [], 'edit' => [], 'ver' => []];

    public function getName()
    {
        if (!$this->name) {
            return str_ireplace('controller', '', join('', array_slice(explode('\\', get_class($this)), -1)));
            //return get_class($this);
        }
        return $this->name;
    }

    public function getNamePlural()
    {
        return $this->name_plural;
    }

    public function getUrlPrefix()
    {
        return $this->url_prefix;
    }

    public function setValidatorAdd($validation_array)
    {
        $this->validators['add'] = $validation_array;
    }

    public function setValidatorVer($validation_array)
    {
        $this->validators['ver'] = $validation_array;
    }

    public function setValidatorEdit($validation_array)
    {
        $this->validators['edit'] = $validation_array;
    }

    public function getValidatorAdd()
    {
        return $this->validators['add'];
    }

    public function getValidatorVer()
    {
        return $this->validators['ver'];
    }

    public function getValidatorEdit()
    {
        return $this->validators['edit'];
    }

    protected function getModelInstance()
    {
        return new $this->model();
    }

    // MÉTODOS PARA LISTAR INSERTAR, MODIFICAR Y ELIMINAR    
    public function Index()
    {
        $id = \Auth::user()->id;
        $url = $this->getUrlPrefix();
        $ins = ("*$url-ins");
        $mod = ("*$url-mod");
        $eli = ("*$url-eli");
        $ver = ("*$url-ver");
        $fac = ("*$url-fac");
        $pac = ("*$url-pac");
        $fil = ("*$url-fil");
        
        $valins = \Entrust::can($ins);
        $valmod = \Entrust::can($mod);
        $valeli = \Entrust::can($eli);
        $valver = \Entrust::can($ver);
        $valfac = \Entrust::can($fac);
        $valpac = \Entrust::can($pac);
        $valfil = \Entrust::can($fil);
        $names = $this->name;
        $show = "";
        
          if($url == "empresas"){
              return view($this->tpl_prefix . 'listempresas', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
          }
          else if($url == "facturas"){
              return view($this->tpl_prefix . 'listfactura', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
          }
          else if($url == "history"){
              $show = "false";
              return view($this->tpl_prefix . 'list2', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
          }
          else if($url == "pagos" || $url == "pagosautorizados" || $url == "pagoshistorial"){
              $show = "";
              return view($this->tpl_prefix . 'listPagos', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
          }
          else if($url == "usermemberships" || $url == "usuariomovement" || $url == "usuarioexchange" || $url == "usuariohistory"){
              $show = "false";
              return view($this->tpl_prefix . 'list2', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
          }
          else if($url == "procesoexchange" || $url == "entregaexchange" || $url == "cobrarexchange"){
              $ids = \Auth::user()->id;
              $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
              
               if ($rol == 6) { //verifica si es un usuario
               $show = "";
               
                return view($this->tpl_prefix . 'listfilterestaciones', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
              }
              else{
              return view($this->tpl_prefix . 'listfilter', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
              }
          }
          else if($url == "catestaciones"){
              $ids = \Auth::user()->id;
              $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
              
               if ($rol == 6) { //verifica si es un usuario
               $show = "";
               
                return view($this->tpl_prefix . 'listestaciones', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
              }
              else{
              return view($this->tpl_prefix . 'list2', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
              }
          }
          else if($url == "adminvoucher"){
            $ids = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
            if ($rol == 3) { //verifica si es un usuario
                 return view($this->tpl_prefix . 'listvauchers', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac); 
               }
               else{
                  return view($this->tpl_prefix . 'listfilter', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac)->with('fil', $fil);
               }
          }
          else if($valfil == true){
              return view($this->tpl_prefix . 'listfilter', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac)->with('fil', $fil);
          }
          else{
              return view($this->tpl_prefix . 'list2', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac);
          }
              
    }

    //--------------------------------------------------------------------------------------------------------------------
    public function getJlist()
    {
        // Informacion que viene de un controlador
        $model = $this->getModelInstance();
        $name = $this->name_plural;
        $names = $this->name;
        
        if ($names == "Catalogo Facturas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = CatFacturas::select("cat_facturas.id", "cat_facturas.nombre", "cat_facturas.rfc", "cat_facturas.numero", \DB::raw("CONCAT(users.name,' ',users.first_surname,' ',users.second_surname) as nameuser"))
                    ->join('users', 'cat_facturas.id_user', '=', 'users.id')
                    ->get();
            } else if ($rol == 2) {
                $data = CatFacturas::select("cat_facturas.id", "cat_facturas.nombre", "cat_facturas.rfc", "cat_facturas.numero", \DB::raw("CONCAT(users.name,' ',users.first_surname,' ',users.second_surname) as nameuser"))
                    ->join('users', 'cat_facturas.id_user', '=', 'users.id')
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Usuarios") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1 || $rol == 3 || $rol == 2 || $rol == 6) { //verifica si es un usuario
                //$data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id", \DB::raw('count(canjes.number_usuario) as total'))
                $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    //->leftjoin('canjes', 'users.id', '=', 'canjes.number_usuario')
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    //->groupBy('canjes.number_usuario')
                    ->get();
            } 
            // dd($data);
            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Usuarios de Estaciones") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "role_user.role_id", "users_estaciones.id_users", "users_estaciones.id_station", "station.name as estacion")
                    ->leftjoin('users_estaciones', 'users.id', '=', 'users_estaciones.id_users')
                    ->leftjoin('station', 'users_estaciones.id_station', '=', 'station.id')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 3)
                    ->where('users.active', '<', 2)
                    ->get();
            } 
             //dd($data);
            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Usuarios Empresas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = User::select("users.id", "users.name", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "users.username as empresa", "role_user.role_id")
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 2)
                    ->where('users.active', '<', 2)
                    ->get();
            } else if ($rol == 2) {
                $data = User::select("users.id", "users.name", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "users.username as empresa", "role_user.role_id")
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 2)
                    ->where('users.id', '=', $id)
                    ->where('users.active', '<', 2)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Empresas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = Empresas::select("empresas.id", "empresas.nombre", "empresas.direccion", "empresas.telefono", "empresas.imglogo", "empresas.total_facturas", "empresas.total_timbres", "empresas.activo", \DB::raw("CONCAT(users.name,' ',users.first_surname,' ',users.second_surname) as nameuser"))
                    ->join('users', 'empresas.id_user', '=', 'users.id')
                    ->where('empresas.activo', '<', 2)
                    ->get();
            } else if ($rol == 2) {
                $data = Empresas::select("empresas.id", "empresas.nombre", "empresas.direccion", "empresas.telefono", "empresas.imglogo", "empresas.total_facturas", "empresas.total_timbres", "empresas.activo", \DB::raw("CONCAT(users.name,' ',users.first_surname,' ',users.second_surname) as nameuser"))
                    ->join('users', 'empresas.id_user', '=', 'users.id')
                    ->where('empresas.id_user', '=', $id)
                    ->where('empresas.activo', '<', 2)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Estaciones") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1 || $rol == 6) { //verifica si es un usuario
               /* $data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa", "factura_emisor.rfc", "factura_emisor.emailfiscal")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->join('factura_emisor', 'station.id', '=', 'factura_emisor.id_estacion')
                    ->where('empresas.activo', '<', 2)
                    ->where('station.active', '<', 2)
                    ->get();*/
                    
                    $data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('empresas.activo', '<', 2)
                    ->where('station.active', '<', 2)
                    ->get();
                    
            } else if ($rol == 2) {
                $usuario = Empresas::where('id_user', '=', $id)->value('id');
                /*$data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa", "factura_emisor.rfc", "factura_emisor.emailfiscal")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->join('factura_emisor', 'station.id', '=', 'factura_emisor.id_estacion')
                    ->where('station.id_empresa', '=', $usuario)
                    ->where('empresas.activo', '<', 2)
                    ->where('station.active', '<', 2)
                    ->get();*/
                    
                    $data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('station.id_empresa', '=', $usuario)
                    ->where('empresas.activo', '<', 2)
                    ->where('station.active', '<', 2)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Bombas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = CatBombas::select("cat_bombas.id", "cat_bombas.nombre", "cat_bombas.numero","station.name as estacion", "empresas.nombre as empresa")
                    ->join('station', 'cat_bombas.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('empresas.activo', '<', 2)
                    ->where('cat_bombas.activo', '<', 2)
                    ->get();
            } else if ($rol == 2) {
                $usuario = Empresas::where('id_user', '=', $id)->value('id');
                $data = CatBombas::select("cat_bombas.id", "cat_bombas.nombre", "cat_bombas.numero","station.name as estacion", "empresas.nombre as empresa")
                    ->join('station', 'cat_bombas.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('cat_bombas.id_empresa', '=', $usuario)
                    ->where('empresas.activo', '<', 2)
                    ->where('cat_bombas.activo', '<', 2)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Pagos") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.archivo","station.name as estacion", "station.id_empresa","empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.archivo', '=', null)
                    ->get();
            } else if ($rol == 2) {
                $usuario = Empresas::where('id_user', '=', $id)->value('id');
                $data = Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.archivo","station.name as estacion", "station.id_empresa", "empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.id_empresa', '=', $usuario)
                    ->where('pagos.archivo', '=', null)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Pagos Autorizados") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.autorizado", "pagos.archivo","station.name as estacion", "station.id_empresa","empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.archivo', '!=', null)
                    ->where('pagos.autorizado', '=', 1)
                    ->get();
            } else if ($rol == 2) {
                $usuario = Empresas::where('id_user', '=', $id)->value('id');
                $data = Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.autorizado","pagos.archivo","station.name as estacion", "station.id_empresa", "empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.id_empresa', '=', $usuario)
                    ->where('pagos.archivo', '!=', null)
                    ->where('pagos.autorizado', '=', 1)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Pagos Historial") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                $data = Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.autorizado", "pagos.archivo","station.name as estacion", "station.id_empresa","empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.archivo', '!=', null)
                    ->where('pagos.autorizado', '>', 1)
                    ->get();
            } else if ($rol == 2) {
                $usuario = Empresas::where('id_user', '=', $id)->value('id');
                $data = Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.autorizado","pagos.archivo","station.name as estacion", "station.id_empresa", "empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.id_empresa', '=', $usuario)
                    ->where('pagos.archivo', '!=', null)
                    ->where('pagos.autorizado', '>', 1)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Facturas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
            
                $data = Facturas::select("facturas.id", "facturas.serie", "facturas.fecha", "facturas.formapago", "facturas.descripcion", "facturas.estatus", "facturas.archivopdf", "facturo.username as emis", "recibio.name as recept")
                    ->join('users as facturo', 'facturas.id_emisor', '=', 'facturo.id')
                    ->join('users as recibio', 'facturas.id_receptor', '=', 'recibio.id')
                    ->where('facturas.sello', '!=', null)
                    ->get();
               // $data = Facturas::get();        
                    //dd($data);
            } else if ($rol == 2) {
                $data = Facturas::select("facturas.id", "facturas.serie", "facturas.fecha", "facturas.formapago", "facturas.descripcion", "facturas.estatus", "facturas.archivopdf", "facturas.id_receptor", "facturas.id_emisor", "emisor.username as emis", "receptor.username as recept")
                    ->join('users as emisor', 'facturas.id_emisor', '=', 'emisor.id')
                    ->join('users as receptor', 'facturas.id_receptor', '=', 'receptor.id')
                    ->where('facturas.id_emisor', '=', $id)
                    ->where('facturas.sello', '!=', null)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        //**********************LEALTAD******************************************************************
        elseif($names == "Asignar Membresias"){
            $data = ConjuntoMembership::select('conjunto_memberships.id','conjunto_memberships.membresia','conjunto_memberships.number_usuario','conjunto_memberships.puntos', 'users.name', 'users.first_surname', 'users.second_surname')
            ->join('users', 'conjunto_memberships.number_usuario', '=', 'users.username')
            ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
            
        }
        elseif($names == "Agregar Vales"){
            /*$data = Count_Voucher::select('count_vouchers.id','count_vouchers.id_station','count_vouchers.min','count_vouchers.max', 'station.name', 'vouchers.total_voucher')
            ->join('station', 'count_vouchers.id_station', '=', 'station.id')
            ->join('vouchers', 'count_vouchers.id_station', '=', 'vouchers.id_station')
            ->get();*/
            
            $data = Count_Voucher::select('count_vouchers.id','count_vouchers.id_station','count_vouchers.min','count_vouchers.max', 'station.name')
            ->join('station', 'count_vouchers.id_station', '=', 'station.id')
            ->get();
            
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
            
        }
        elseif($names == "Vale"){
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d') ; // Fecha
            $data = Voucher::select('vouchers.id', 'vouchers.name as nombre', 'vouchers.points', 'vouchers.value', 'station.name', 'cat_status.name_status', 'vouchers.id_station', 'vouchers.total_voucher') 
                ->join('cat_status', 'vouchers.id_status', '=', 'cat_status.id')
                ->join('station', 'vouchers.id_station', '=', 'station.id')
                ->where('vouchers.total_voucher', '>', 0)
                //->distinct()->get(['value']);
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Administracion Vale"){
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d') ; // Fecha
            $data = Voucher::select('vouchers.id', 'vouchers.name as nombre', 'vouchers.points', 'vouchers.value', 'station.name', 'cat_status.name_status', 'vouchers.id_station', 'vouchers.total_voucher') 
                ->join('cat_status', 'vouchers.id_status', '=', 'cat_status.id')
                ->join('station', 'vouchers.id_station', '=', 'station.id')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Perfil"){
            $id = \Auth::user()->id;
            $data = User::where('users.id', '=', $id)
            ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Facturacion"){
            $id = \Auth::user()->id;
             $qr_memberships = Memberships::where('id_users', '=', $id)->value('number_usuario');
            ///$factura = Facturacion::where('id_user', '=', $qr_memberships)->value('id');
             
            $data = Facturacion::where('id_user', '=', $qr_memberships)
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Administrador Facturacion"){
            $data = Facturacion::get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Usuario"){
            $data = User::select('users.id', 'tarjeta.number_usuario', 'users.name', 'users.first_surname', 'users.second_surname', 'users.username', 'users.email', 'users.sex', 'users.active')
                ->join('tarjeta', 'tarjeta.id_users', '=', 'users.id')
               // ->where('users.id', '=', 'memberships.id_users')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Usuarios con mas puntos"){
            $data = User::select('users.id', 'tarjeta.number_usuario', 'users.name', 'users.first_surname', 'users.second_surname', 'tarjeta.totals', 'tarjeta.visits')
                ->join('tarjeta', 'tarjeta.id_users', '=', 'users.id')
                ->where('tarjeta.totals', '>=', 2000)
                ->orderBy('tarjeta.totals','ASC')
                ->get();
                //dd($data);
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "QR"){
                $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'cat_active.name_active', 'tarjeta.todate')
                ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
                ->where('id_users', '=', 0)->get();
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Membresia"){
                $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'cat_active.name_active', 'tarjeta.todate')
                ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
                //->where('id_users', '>', 0)
                ->get();
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Mi Membresia"){
            $id = \Auth::user()->id;
                  //dd($id);
            $rol = Role_User::where('user_id', '=', $id)->where('role_id', '=', 5)->get();
              if($rol != " "){
                $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits', 'users.username')
                ->join('users', 'tarjeta.id_users', '=', 'users.id')
                ->where('id_users', '=', $id)
                ->get();
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
              }
              else{
                $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits', 'users.username')
                ->join('users', 'tarjeta.id_users', '=', 'users.id')
                ->get();
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
              }
        }
        elseif($names == "Movimiento"){
                
                date_default_timezone_set("America/Mexico_City");
                          $flecha = date('Y-m-d'); 
                          //fecha servidor
                                $anoserv = substr($flecha, 0, 4);
                                $messerv = substr($flecha, 5, 2);
                                $diaserv = substr($flecha, 8, 2);
                                $fechaservi = ($anoserv."-".$messerv."-"."01");
                                $fechaservf = ($anoserv."-".$messerv."-"."31");
                                
                $i = $fechaservi . " 00:00:00";
                $f = $fechaservf . " 23:59:59";
                
                $data = Movement::
                select('tickets.id','tickets.number_usuario', 'tickets.generado','tickets.number_ticket','tickets.punto', 'tickets.litro', 'tickets.producto', 'station.name', 'tickets.descrip', 'tickets.created_at')
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('tickets.created_at', '>=', $i)
                ->where('tickets.created_at', '<=', $f)
                ->get();
                
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
             
                
              }
        elseif($names == "Estado de Cuenta"){
            $id_us = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->get();
              if($rol != ""){
                $qr_memberships = Memberships::where('id_users', '=', $id_us)->value('number_usuario');
                $mov = Movement::
                select('tickets.id','tickets.number_usuario', 'tickets.punto', 'station.name', 'tickets.descrip', 'tickets.created_at as fecha', \DB::raw('tickets.number_ticket as folios'))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('number_usuario', '=', $qr_memberships);
                
                $data = Exchange::
                select('canjes.id','canjes.number_usuario', 'canjes.punto', 'station.name', 'canjes.descrip', 'canjes.estado_uno as fecha', \DB::raw('canjes.identificador as folios'))
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->where('number_usuario', '=', $qr_memberships)
                ->union($mov)
                ->get();
                
                //$first = DB::table('users')->whereNull('first_surname');
                //$users = DB::table('users')->whereNull('first_surname')->union($first)->get();

                
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
              }}
        elseif($names == "Administracion de Membresia"){
            $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'cat_active.name_active', 'tarjeta.todate')
                ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
                ->where('id_users', '=', 0)
                ->where('tarjeta.active', '=', '1')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Estacion"){
            $data = Station::select('station.id', 'station.name', 'station.address') 
                //->join('cat_type', 'station.id_type', '=', 'cat_type.id')
                //->join('cat_server', 'station.id_comes', '=', 'cat_server.id')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Premio"){
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d') ; // Fecha
            $data = Awards::select('awards.id', 'awards.name', 'awards.points', 'awards.value', 'awards.active', 'cat_status.name_status') 
                ->join('cat_status', 'awards.id_status', '=', 'cat_status.id')
                ->where('awards.active', '=', 1)
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Administracion Premio"){
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d') ; // Fecha
            $data = Awards::select('awards.id', 'awards.name', 'awards.img', 'awards.points', 'awards.value', 'awards.active', 'cat_status.name_status') 
                ->join('cat_status', 'awards.id_status', '=', 'cat_status.id')
                ->where('awards.active', '<=', 2)
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Vale Master"){
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d') ; // Fecha
            $data = Voucher::select('vouchers.id', 'vouchers.name', 'vouchers.points', 'vouchers.value', 'station.name', 'cat_status.name_status', 'vouchers.id_station', 'vouchers.total_voucher') 
                ->join('cat_status', 'vouchers.id_status', '=', 'cat_status.id')
                ->join('station', 'vouchers.id_station', '=', 'station.id')
                ->where('vouchers.total_voucher', '>', 0)
            ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Premio Master"){
            $data = Awards::select('awards.id', 'awards.name', 'awards.points', 'awards.value', 'cat_status.name_status') 
                ->join('cat_status', 'awards.id_status', '=', 'cat_status.id')
                ->where('awards.active', '=', 1)
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  }
        elseif($names == "Intercambiar"){ 
             $data = Exchange::
               join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
       }
        elseif($names == "Historial"){ //GENERAL MUESTRA EL HISTORIAL DE TODOS LOS VALES Y PREMIOS 
            $data = History::select('history.id', 'history.folio', 'history.folio_exchange', 'history.numero', 'history.todate_cerficado', 'history.id_admin', 'history.number_usuario', 'history.id_product', 'history.id_station', 'history.points', 'history.value', 'history.todate as fecha', 'users.name as username', 'cat_exchange.name_exchange')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Despachador"){ //
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->where('role_id', '=', 4)->get();
              if($rol != ""){
                  $data = Dispatcher::select('dispatcher.id', 'dispatcher.qr_dispatcher', 'cat_active.name_active', 'dispatcher.todate', 'users.username', 'station.name')
                ->join('cat_active', 'dispatcher.active', '=', 'cat_active.id')
                ->join('station', 'dispatcher.id_station', '=', 'station.id')
                ->join('users', 'dispatcher.id_users', '=', 'users.id')
                ->get();
              }
              else{
                 $data = Dispatcher::select('dispatcher.id', 'dispatcher.qr_dispatcher', 'cat_active.name_active', 'dispatcher.todate', 'users.username', 'station.name')
                ->join('cat_active', 'dispatcher.active', '=', 'cat_active.id')
                ->join('station', 'dispatcher.id_station', '=', 'station.id')
                ->join('users', 'dispatcher.id_users', '=', 'users.id')
                ->get();
              }
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Despachos"){ //
             
              $data = \DB::table("dispatcher")
              ->select("dispatcher.id","dispatcher.id_users", "dispatcher.qr_dispatcher", "users.name as nombre", "users.first_surname", "station.name", \DB::raw("(SELECT COUNT(*) FROM tickets WHERE dispatcher.qr_dispatcher = tickets.generado) as Total"))
               ->join('users', 'dispatcher.id_users', '=', 'users.id')
               ->join('station', 'dispatcher.id_station', '=', 'station.id')
                ->get();
    
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Usuarios Movimientos Detallados"){
               //dd($request->all());
               $value = $request->session()->get('detalles');
               $qr_memberships = Memberships::where('id_users', '=', $value)->value('number_usuario');
           
               $data = Tickets::select('tickets.id','tickets.number_usuario', 'tickets.generado','tickets.litro','tickets.punto', 'tickets.producto','station.name', 'tickets.descrip', \DB::raw('tickets.number_ticket as folios'))
                ->join('station', 'tickets.id_gas', '=', 'station.id')
                ->where('number_usuario', '=', $qr_memberships)
                ->get();
                return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
              
        }
        elseif($names == "Administradores de Estacion"){ //ADMIN GEMMA ASIGNAR ADMIN DE ESTACION A UNA ESTACION PROPIA 
            $data = Faturation::select('faturation.id', 'cat_active.name_active', 'faturation.todate', 'users.username', 'station.name')
                ->join('cat_active', 'faturation.active', '=', 'cat_active.id')
                ->join('station', 'faturation.id_station', '=', 'station.id')
                ->join('users', 'faturation.id_users', '=', 'users.id')
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Proceso"){ //ADMIN ESTACION PARA EL CANJE SOLO MUESTRE PROCESO
             $id_us = \Auth::user()->id;
             //dd($id_us);
             $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 3)->value('role_id');
             if($rol == 3){
             $id = \Auth::user()->id;
             $station = UserEstacion::where('id_users', '=', $id)->value('id_station');
                
                  $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                  \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 1)
                ->get();
                
                /*$data = Exchange_Award::select('canjes_awards.id', 'canjes_awards.identificador', 'canjes_awards.number_usuario', 'canjes_awards.descrip', 'canjes_awards.conta', 'station.name', 'canjes_awards.value', 'cat_state.name_state', 'canjes_awards.estado_uno', 'tarjeta.totals as punto') 
                ->join('tarjeta', 'canjes_awards.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes_awards.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes_awards.estado', '=', 'cat_state.id')
                ->where('canjes_awards.estado', '=', 1)
                ->where('canjes_awards.id_estacion', '=', $station)
                ->union($mov)
                ->get();*/

            }
            else{
           
                 $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.estado', '=', 1)
                ->get();
                
                //dd($data);
                
            }
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
       }
        elseif($names == "Cobrar"){ //ADMIN ESTACION PARA EL CANJE SOLO MUESTRE COBRAR
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                 $station = UserEstacion::where('id_users', '=', $id)->value('id_station');
            
                $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 3)
                ->get();  
            }
            else{
                $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.estado', '=', 3)
                ->get();      
            }       
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
       }
        elseif($names == "Entrega"){ //ADMIN ESTACION PARA EL CANJE SOLO MUESTRE Entregar
                 $id_us = \Auth::user()->id;
             $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 3)->value('role_id');
             if($rol != ""){
               $id = \Auth::user()->id;
               $station = UserEstacion::where('id_users', '=', $id)->value('id_station');
                $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 2)
                ->get();
            }
            else{
           
                 $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                  \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.estado', '=', 2)
                ->get();
                //dd($data);
            }
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
       }
        elseif($names == "Recibido"){ //ADMIN ESTACION PARA EL CANJE SOLO MUESTRE PROCESO
              $id = \Auth::user()->id;
              $station = UserEstacion::where('id_users', '=', $id)->value('id_station');
              $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.conta', 'station.name', 'canjes.punto', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','awards.name as premio') 
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 4)
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
       }
        elseif($names == "Mi Vale"){ //USUARIOS MUESTRA LOS VALES QUE A SOLICITADO Y ESTAN PROCESO DE CANJE
              $id = \Auth::user()->id;
              $qr_memberships = Memberships::where('id_users', '=', $id)->value('number_usuario');
              $data = Exchange::
                join('station', 'canjes.id_estacion', '=', 'station.id')
                ->where('canjes.number_usuario', '=', $qr_memberships)  
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
       }
        elseif($names == "Mi Historial"){ //USUARIO MUESTRA SU HISTORIAL DE VALES O PREMIOS SOLICITADOS CON EXITO
            $id = \Auth::user()->id;
            $qr_memberships = Memberships::where('id_users', '=', $id)->value('number_usuario');
            $data = History::
                join('users', 'history.id_admin', '=', 'users.id')
                ->where('history.number_usuario', '=', $qr_memberships)  
                ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
        }
        elseif($names == "Usuario de Estacion"){
            $data = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                   ->where('role_user.role_id', '=', 3)
                    ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Usuario Despachador"){
            $data = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                   ->where('role_user.role_id', '=', 4)
                    ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Cambio de Membresia"){
            $data = Change_Memberships::join('users', 'change_memberships.id_users', '=', 'users.id')
                    ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
        elseif($names == "Puntos Dobles"){
           $data = DoblePuntos::select('doublepoint.id','doublepoint.active')
                        ->get();
            return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );
        }
       
        else {
            $data = $model::all();
            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
    }

    public function getJlistt($ids)
    {
        $model = $this->getModelInstance();
        $name = $this->name_plural;
        $names = $this->name;
      
         if ($names == "Estaciones") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
                /*$data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa", "factura_emisor.rfc", "factura_emisor.emailfiscal")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->join('factura_emisor', 'station.id', '=', 'factura_emisor.id_estacion')
                    ->where('station.id_empresa', '=', $ids)
                    ->get();*/
                   // dd($data);
                    $data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('empresas.activo', '<', 2)
                    ->where('station.active', '<', 2)
                    ->get();
                    
            } else if ($rol == 2) {
               /*$data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa", "factura_emisor.rfc", "factura_emisor.emailfiscal")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->join('factura_emisor', 'station.id', '=', 'factura_emisor.id_estacion')
                    ->where('station.id_empresa', '=', $ids)
                    ->where('empresas.id_user', '=', $id)
                    ->get();*/
                     $data = Station::select("station.id", "station.name", "station.number_station", "station.address", "station.phone", "station.total_facturas", "station.total_timbres", "empresas.nombre as empresa")
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('station.id_empresa', '=', $usuario)
                    ->where('empresas.activo', '<', 2)
                    ->where('station.active', '<', 2)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Bombas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1 || $rol == 6 || $rol == 2) { //verifica si es un usuario
                $data = CatBombas::select("cat_bombas.id", "cat_bombas.nombre", "cat_bombas.numero","station.name as estacion", "empresas.nombre as empresa")
                    ->join('station', 'cat_bombas.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('cat_bombas.id_estacion', '=', $ids)
                    ->get();
            } /*else if ($rol == 2 ) {
                $usuario = Empresas::where('id_user', '=', $id)->value('id');
                $data = CatBombas::select("cat_bombas.id", "cat_bombas.nombre", "cat_bombas.numero","station.name as estacion", "empresas.nombre as empresa")
                    ->join('station', 'cat_bombas.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('cat_bombas.id_empresa', '=', $usuario)
                    ->where('empresas.activo', '<', 2)
                    ->get();
        
            }*/

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Facturas") {
            $id = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id)->value('role_id');
            if ($rol == 1) { //verifica si es un usuario
            
                $data = Facturas::select("facturas.id", "facturas.serie", "facturas.fecha", "facturas.formapago", "facturas.descripcion", "facturas.estatus", "facturas.archivopdf", "facturo.username as emis", "recibio.name as recept")
                    ->join('users as facturo', 'facturas.id_emisor', '=', 'facturo.id')
                    ->join('users as recibio', 'facturas.id_receptor', '=', 'recibio.id')
                    ->where('facturas.sello', '!=', null)
                    ->where('facturas.id_bomba', '=', $ids)
                    ->get();
               // $data = Facturas::get();        
                    //dd($data);
            } else if ($rol == 2) {
                $data = Facturas::select("facturas.id", "facturas.serie", "facturas.fecha", "facturas.formapago", "facturas.descripcion", "facturas.estatus", "facturas.archivopdf", "facturas.id_receptor", "facturas.id_emisor", "emisor.username as emis", "receptor.username as recept")
                    ->join('users as emisor', 'facturas.id_emisor', '=', 'emisor.id')
                    ->join('users as receptor', 'facturas.id_receptor', '=', 'receptor.id')
                    ->where('facturas.id_emisor', '=', $id)
                    ->where('facturas.sello', '!=', null)
                    ->where('facturas.id_bomba', '=', $ids)
                    ->get();
            }

            return response()->json(['draw' => "1", 'data' => $data, 'recordsTotal' => $data->count()]);
        }
        else if ($names == "Movimiento"){
        $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'tickets.created_at', 'station.name as nombre', 'users.name', 'users.first_surname')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
             ->where('number_usuario', '=', $ids)
             ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
    }
   
      
    }
    
    public function postJFilter(Request $request)
    {
  
    //estado cuenta
    if($request->url == "movement"){
      
     if ($request->min != "" && $request->max != "" && $request->membresia != ""){
         $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
     
          $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'station.name as nombre', 'users.name', 'users.first_surname','tickets.created_at')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
              ->where('tickets.created_at', '>=', $i)
                ->where('tickets.created_at', '<=', $f)
                ->where('number_usuario', '=', $request->membresia)
                ->get();
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
         
           $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'station.name as nombre', 'users.name', 'users.first_surname','tickets.created_at')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
                ->where('tickets.created_at', '>=', $i)
                ->where('tickets.created_at', '<=', $f)
                ->get();
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->membresia != ""){
        $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'tickets.created_at', 'station.name as nombre', 'users.name', 'users.first_surname')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
             ->where('number_usuario', '=', $request->membresia)
             ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
     else if($request->folio != ""){
        $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'tickets.created_at', 'station.name as nombre', 'users.name', 'users.first_surname')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
             ->where('tickets.number_ticket', '=', $request->folio)
             ->get();
            
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
      else if($request->first_surname != "" && $request->second_surname != "" && $request->nombre != ""){
        $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'station.name as nombre', 'users.name', 'users.first_surname','tickets.created_at')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
             ->where('users.name', '=', $request->nombre)
             ->where('users.first_surname', '=', $request->first_surname)
             ->where('users.second_surname', '=', $request->second_surname)
             ->get();
     
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
     }
     else if($request->nombre != ""){

      $data = Tickets::select('tickets.id', 'tickets.number_usuario', 'tickets.generado', 'tickets.number_ticket', 'tickets.punto', 'tickets.litro', 'tickets.producto', 'tickets.descrip', 'station.name as nombre', 'users.name', 'users.first_surname','tickets.created_at')
             ->join('station', 'tickets.id_gas', '=', 'station.id')
             ->join('users', 'tickets.number_usuario', '=', 'users.username')
             ->where('users.name', '=', $request->nombre)
             ->get();
      return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
    }
    else if($request->url == "admingmemberships"){
        if ($request->min != "" && $request->max != "" && $request->membresia != ""){
          $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
     
        $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario','cat_active.name_active', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits')
             ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
                ->where('tarjeta.todate', '>=', $i)
                ->where('tarjeta.todate', '<=', $f)
                ->where('number_usuario', '=', $request->membresia)
                ->where('tarjeta.id_users', '=', 0)
                ->get();
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
    
    $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'users.name', 'users.last_name', 'cat_active.name_active', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits')
                ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
                ->where('tarjeta.todate', '>=', $i)
                ->where('tarjeta.todate', '<=', $f)
                ->where('tarjeta.id_users', '=', 0)
                ->get();
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->membresia != ""){
        $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario','cat_active.name_active', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits')
             ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
             ->where('tarjeta.number_usuario', '=', $request->membresia)
             ->where('tarjeta.id_users', '=', 0)
             ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
      else if($request->nombre != ""){
     
     $data = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'users.name', 'users.last_name', 'cat_active.name_active', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits')
                ->join('cat_active', 'tarjeta.active', '=', 'cat_active.id')
                ->join('users', 'tarjeta.number_usuario', '=', 'users.username')
             ->where('users.name', '=', $request->nombre)
             ->where('tarjeta.id_users', '=', 0)
             ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
    }
    //usuarios
    else if($request->url == "userclient"){
       
        if ($request->min != "" && $request->max != ""){
        $i = $request->min . " 00:00:00";
        $f = $request->max . " 23:59:59";
     
                $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "users.created_at", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('users.created_at', '>=', $i)
                    ->where('users.created_at', '<=', $f)
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->get();
                    
             return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

      } 
        else if ($request->min != "" && $request->max != "" && $request->membresia != ""){
        $i = $request->min . " 00:00:00";
        $f = $request->max . " 23:59:59";
                $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('users.created_at', '>=', $i)
                    ->where('users.created_at', '<=', $f)
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->where('users.username', '=', $request->membresia)
                    ->get();
             return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

      }
        else if($request->membresia != ""){
           $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->where('users.username', '=', $request->membresia)
                    ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
        else if($request->nombre != ""){
           $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->where('users.name', '=', $request->nombre)
                    ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
     }
     else if($request->first_surname != "" && $request->second_surname != "" && $request->nombre != ""){
           $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->where('users.name', '=', $request->nombre)
                    ->where('users.first_surname', '=', $request->first_surname)
                    ->where('users.second_surname', '=', $request->second_surname)
                    ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
     }
     else if($request->email != ""){
           $data = User::select("users.id", "users.name", "users.username", "users.first_surname", "users.second_surname", "users.email", "users.phone", "users.active", "factura_receptor.rfc", "tarjeta.totals", "role_user.role_id")
                    ->leftjoin('factura_receptor', 'users.id', '=', 'factura_receptor.id_user')
                    ->join('tarjeta', 'users.id', '=', 'tarjeta.id_users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 5)
                    ->whereNotIn('users.active', [3])
                    ->where('email', '=', $request->email)
                    ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
     }
    }
    else if($request->url == "dispatchermovement"){
         $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
         
        $data = \DB::table("dispatcher")
              ->select("dispatcher.id","dispatcher.id_users", "dispatcher.qr_dispatcher", "users.name as nombre", "users.last_name", "station.name", \DB::raw("(SELECT COUNT(*) FROM tickets WHERE dispatcher.qr_dispatcher = tickets.generado AND created_at >= '$i' AND created_at <= '$f') as Total"))
               ->join('users', 'dispatcher.id_users', '=', 'users.id')
               ->join('station', 'dispatcher.id_station', '=', 'station.id')
                ->get();
    
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
    }
    //history
    else if($request->url == "history"){
     
      if ($request->min != "" && $request->max != "" && $request->estacion != ""){
         $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
       
       $data = History::select('history.id', 'history.id_exchange', 'history.folio', 'history.folio_exchange', 'history.numero', 'history.todate_cerficado', 'history.id_admin', 'history.number_usuario', 'history.id_product', 'history.id_station', 'history.points', 'history.value', 'history.todate as fecha', 'users.name as username', 'cat_exchange.name_exchange')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->where('history.todate', '>=', $i)
                ->where('history.todate', '<=', $f)
                ->where('history.id_station', '<=', $request->estacion)
                ->get();
                
                
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
         
      $data = History::select('history.id', 'history.id_exchange', 'history.folio', 'history.folio_exchange', 'history.numero', 'history.todate_cerficado', 'history.id_admin', 'history.number_usuario', 'history.id_product', 'history.id_station', 'history.points', 'history.value', 'history.todate as fecha', 'users.name as username', 'cat_exchange.name_exchange')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->where('history.todate', '>=', $i)
                ->where('history.todate', '<=', $f)
                ->get();
                
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->estacion != ""){
       
        $data = History::select('history.id', 'history.id_exchange', 'history.folio', 'history.folio_exchange', 'history.numero', 'history.todate_cerficado', 'history.id_admin', 'history.number_usuario', 'history.id_product', 'history.id_station', 'history.points', 'history.value', 'history.todate as fecha', 'users.name as username', 'cat_exchange.name_exchange')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->where('history.id_station', '<=', $request->estacion)
                ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
     else if($request->membresia != ""){
        $data = History::select('history.id', 'history.id_exchange', 'history.folio', 'history.folio_exchange', 'history.numero', 'history.todate_cerficado', 'history.id_admin', 'history.number_usuario', 'history.id_product', 'history.id_station', 'history.points', 'history.value', 'history.todate as fecha', 'users.name as username', 'cat_exchange.name_exchange')
                ->join('users', 'history.id_admin', '=', 'users.id')
                ->join('cat_exchange', 'history.id_exchange', '=', 'cat_exchange.id')
                ->where('history.number_usuario', '<=', $request->membresia)
                ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
     }
    else if($request->url == "conjuntomembership"){
        if ($request->min != "" && $request->max != "" && $request->membresia != ""){
          $i = $request->min . " 00:00:00";
          $f = $request->max . " 23:59:59";
     
        $data = ConjuntoMembership::select('conjunto_memberships.id', 'conjunto_memberships.number_usuario','conjunto_memberships.membresia', 'conjunto_memberships.puntos', 'users.name', 'users.last_name')
                ->join('users', 'conjunto_memberships.number_usuario', '=', 'users.username')
                ->where('conjunto_memberships.created_at', '>=', $i)
                ->where('conjunto_memberships.created_at', '<=', $f)
                ->where('conjunto_memberships.number_usuario', '=', $request->membresia)
                ->get();
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
    
        $data = ConjuntoMembership::select('conjunto_memberships.id', 'conjunto_memberships.number_usuario','conjunto_memberships.membresia', 'conjunto_memberships.puntos', 'users.name', 'users.last_name')
                ->join('users', 'conjunto_memberships.number_usuario', '=', 'users.username')
                ->where('conjunto_memberships.created_at', '>=', $i)
                ->where('conjunto_memberships.created_at', '<=', $f)
                ->get();
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->membresia != ""){
        $data = ConjuntoMembership::select('conjunto_memberships.id', 'conjunto_memberships.number_usuario','conjunto_memberships.membresia', 'conjunto_memberships.puntos', 'users.name', 'users.last_name')
                ->join('users', 'conjunto_memberships.number_usuario', '=', 'users.username')
                ->where('conjunto_memberships.number_usuario', '=', $request->membresia)
                ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
     
       else if($request->lastname != ""){

        $data = ConjuntoMembership::select('conjunto_memberships.id', 'conjunto_memberships.number_usuario','conjunto_memberships.membresia', 'conjunto_memberships.puntos', 'users.name', 'users.last_name')
                ->join('users', 'conjunto_memberships.number_usuario', '=', 'users.username')
                ->where('conjunto_memberships.created_at', '>=', $i)
                ->where('conjunto_memberships.created_at', '<=', $f)
                ->where('users.name', '=', $request->nombre)
                ->where('users.last_name', '=', $request->lastname)
                ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  
     }

      else if($request->nombre != ""){
     
        $data = ConjuntoMembership::select('conjunto_memberships.id', 'conjunto_memberships.number_usuario','conjunto_memberships.membresia', 'conjunto_memberships.puntos', 'users.name', 'users.last_name')
                ->join('users', 'conjunto_memberships.number_usuario', '=', 'users.username')
                ->where('conjunto_memberships.created_at', '>=', $i)
                ->where('conjunto_memberships.created_at', '<=', $f)
                ->where('users.name', '=', $request->nombre)
                ->get();
        return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );  

     }
    }
    //canjes
    else if($request->url == "cobrarexchange"){
       if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
           $idr = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $idr)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                $station = Faturation::where('id_users', '=', $id)->value('id_station');
           
               $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.created_at', '>=', $i)
                ->where('canjes.created_at', '<=', $f)
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 3)
                ->get();  
              }
              else{
                 $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.created_at', '>=', $i)
                ->where('canjes.created_at', '<=', $f)
                ->where('canjes.estado', '=', 3)
                ->get();  
              }
                
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
      else if($request->folio != ""){
          $idr = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $idr)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                $station = Faturation::where('id_users', '=', $id)->value('id_station');
           
               $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.identificador', '=', $request->folio)
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 3)
             ->get();  
              }
              else{
                 $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.identificador', '=', $request->folio)
                ->where('canjes.estado', '=', 3)
                ->get();  
              }
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
    
    }
    else if($request->url == "procesoexchange"){
      if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
           $idr = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $idr)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                $station = Faturation::where('id_users', '=', $id)->value('id_station');
           
              $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.created_at', '>=', $i)
                ->where('canjes.created_at', '<=', $f)
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 1)
             ->get();  
              }
              else{
                $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.created_at', '>=', $i)
                ->where('canjes.created_at', '<=', $f)
                ->where('canjes.estado', '=', 1)
                ->get();  
                
                
                
              }
                
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     else if($request->folio != ""){
          $idr = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $idr)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                $station = Faturation::where('id_users', '=', $id)->value('id_station');
           
               $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.identificador', '=', $request->folio)
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 1)
             ->get();  
              }
              else{
                 $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno','canjes.estado_dos','canjes.estado_tres', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.identificador', '=', $request->folio)
                ->where('canjes.estado', '=', 1)
                ->get();  
              }
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
     
    }
    else if($request->url == "entregaexchange"){
       if($request->min != "" && $request->max != "") {
       $i = $request->min . " 00:00:00";
         $f = $request->max . " 23:59:59";
           $idr = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $idr)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                $station = Faturation::where('id_users', '=', $id)->value('id_station');
           
              $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.created_at', '>=', $i)
                ->where('canjes.created_at', '<=', $f)
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 2)
             ->get();  
              }
              else{
                $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.created_at', '>=', $i)
                ->where('canjes.created_at', '<=', $f)
                ->where('canjes.estado', '=', 2)
                ->get();  
              }
                
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
      else if($request->folio != ""){
          $idr = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $idr)->where('role_id', '=', 3)->value('role_id');
              if($rol != ""){
                $station = Faturation::where('id_users', '=', $id)->value('id_station');
           
              $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.identificador', '=', $request->folio)
                ->where('canjes.id_estacion', '=', $station)
                ->where('canjes.estado', '=', 2)
             ->get();  
              }
              else{
                $data = Exchange::select('canjes.id', 'canjes.identificador', 'canjes.number_usuario', 'canjes.conta', 'canjes.descrip', 'station.name', 'canjes.value', 'cat_state.name_state', 'canjes.estado_uno', 'tarjeta.totals as punto','awards.name as premio',
                 \DB::raw('(CASE 
                        WHEN canjes.descrip = "premio" THEN canjes.descrip
                        ELSE "vale"
                        END) AS dtip')) 
                ->join('tarjeta', 'canjes.number_usuario', '=', 'tarjeta.number_usuario')
                ->join('station', 'canjes.id_estacion', '=', 'station.id')
                ->join('cat_state', 'canjes.estado', '=', 'cat_state.id')
                ->leftjoin('awards', 'canjes.conta', '=', 'awards.id')
                ->where('canjes.identificador', '=', $request->folio)
                ->where('canjes.estado', '=', 2)
                ->get();  
              }
       return response()->json(['draw'=>"1",'data' => $data,'recordsTotal'=>$data->count()] );        
     }
    
    }
    
   }
  

    //AGREGAR FORMULARIO A EL CAMPO ADD-----------------------------------------------------------------------------------------
    public function getAdd()
    {
        $model = $this->getModelInstance();
        $names = $this->name;
       
        if($names == "Usuarios"){
        $url = $this->getUrlPrefix();
        return view($this->tpl_prefix.'timbre.usuariocliente', array('catalog' => $this));
        }
        else if($names == "Usuarios Empresas"){
        $url = $this->getUrlPrefix();
        return view($this->tpl_prefix.'timbre.usuarioempresa', array('catalog' => $this));
        }
        else if($names == "Estaciones"){
        $url = $this->getUrlPrefix();
        return view($this->tpl_prefix.'timbre.estacionempresa', array('catalog' => $this));
        }
        else if($names == "Administracion Premio"){
        $url = $this->getUrlPrefix();
        return view($this->tpl_prefix.'timbre.premios', array('catalog' => $this));
        }
        else{
            $form = \FormBuilder::create($this->form, [
            'method' => 'POST',
            'model' => $this->getModelInstance(),
            'url' => ($this->url_prefix . '/add')
        ]);
        }
        return view($this->tpl_prefix . 'add', array('catalog' => $this), compact('form'));
    }

    //---------------------------------------------------------------------------------------------------------------------------
    public function postAdd(Request $request)
    {
        $url = $this->getUrlPrefix();
        $model = $this->getModelInstance();
        $v = Validator::make($request->all(), $this->getValidatorAdd());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d') ; // Fecha
   
            $names = $this->name;
            //USUARIOS 
            if ($names == "Usuarios") {
                $member = User::where('email', '=', $request->email)->value('id');
                if ($member == "") {
                    if($request->activo == "on"){ $activo = 0; } else { $activo = 1; }
                     $mem = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                               ->where('role_user.role_id', '=', 5)
                               ->orderBy('users.id', 'desc')->limit(1)->value('username');
                     if($mem == null){
                         $nuevo = 2000001;
                     }
                     else{
                     $nuevo = $mem + 1;
                     }
                     
                    User::create([
                        'name' => $request->name,
                        'first_surname' => $request->app_name,
                        'second_surname' => $request->apm_name,
                        'username' => $nuevo,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'sex' => $request->sex,
                        'phone' => $request->telefono,
                        'active' => $activo,
                    ]);
                    $user = User::where('email', '=', $request->email)->value('id');
                    Role_User::create([
                        'user_id' => $user,
                        'role_id' => 5,
                    ]);
                    
                    /*FacturaReceptor::create([
                        'nombre' => $request->nombre,
                        'rfc' => $request->rfc,
                        'usocfdi' => $request->usocfdi,
                        'emailfiscal' => $request->emailfiscal,
                        'id_user' => $user,
                    ]);*/
                    
                    Memberships::create([
                     'number_usuario' => $nuevo,
                     'active' => 1,
                     'todate' => $fecha,
                     'totals' => 100,
                     'visits' => 0,
                     'id_users' => $user,
                  ]);
                  
                   Client::create([
                     'user_id' => $user,
                     'current_balance' => 0,
                     'shared_balance' => 0,
                     'points' => 0,
                     'image' => $nuevo,
                     'birthdate' => '0000-00-00',
                  ]);
                  
                    $id_imagen = User::where('username', '=', $nuevo)->value('image');
              
                    if($id_imagen == null){
                    $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($nuevo, 'QRCODE'). ' ';
                    list(, $Base64Img) = explode(';', $Base64Img);
                    list(, $Base64Img) = explode(',', $Base64Img);
                    $Base64Img = base64_decode($Base64Img);
                    file_put_contents("img/usuarioimg/$nuevo.jpg", $Base64Img); 
                    
                    $t = User::find($user);
                    $t->image = $nuevo;
                    $t->save();
                    }
      
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                } else {
                    return redirect()->to($url)->withStatus(__('El correo electronico ya existe.'));
                }
            }
            elseif ($names == "Usuarios de Estaciones") {
                $member = User::where('email', '=', $request->email)->value('id');
                if ($member == "") {
            //        dd($request->id_station);
                $exist = UserEstaciones::join('users', 'users_estaciones.id_users', '=', 'users.id')
                                      ->where('users_estaciones.id_station', '=', $request->id_station)
                                      ->where('users.active', '=', 1)
                                      ->count();
                                      
                if($exist == 0){      
                    User::create([
                        'name' => $request->name,
                        'first_surname' => $request->first_surname,
                        'second_surname' => $request->second_surname,
                        'username' => $request->email,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'sex' => $request->sex,
                        'phone' => $request->telefono,
                        'active' => 1,
                    ]);
                    $user = User::where('email', '=', $request->email)->value('id');
                    Role_User::create([
                        'user_id' => $user,
                        'role_id' => 3,
                    ]);
                    UserEstaciones::create([
                        'id_users' => $user,
                        'id_station' => $request->id_station,
                    ]);
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                    }
                     else{
                    return redirect()->to($url)->withStatus(__('Ya existe un usuario con esta estacion.'));
                     }
                } else {
                    return redirect()->to($url)->withStatus(__('El correo electronico ya existe.'));
                }
            }
            
            //USUARIOS EMPRESAS
            elseif ($names == "Usuarios Empresas") {
                $member = User::where('email', '=', $request->email)->value('id');
                if ($member == "") {
                    
                    if($request->activo == "on"){ $activo = 1; } else { $activo = 0; }
                    User::create([
                        'name' => $request->name,
                        'first_surname' => $request->first_surname,
                        'second_surname' => $request->second_surname,
                        'username' => $request->nombre,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'sex' => $request->sex,
                        'phone' => $request->telefono,
                        'active' => $activo,
                    ]);
                    $user = User::where('email', '=', $request->email)->value('id');
                    Role_User::create([
                        'user_id' => $user,
                        'role_id' => 2,
                    ]);
                    
                    if($request->file('imglogo') != null){
                    $file = $request->file('imglogo');
                    $nombre = $file->getClientOriginalName();
                    \Storage::disk('logos')->put($nombre,  \File::get($file));
                    }
                    else{
                        $nombre = "";
                    }
                    
                    Empresas::create([
                        'nombre' => $request->nombre,
                        'direccion' => $request->direccion,
                        'telefono' => $request->telefonoempresa,
                        'imglogo' => $nombre,
                        'activo' => $activo,
                        'id_user' => $user,
                    ]);
                  
        
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                } else {
                    return redirect()->to($url)->withStatus(__('El correo electronico ya existe.'));
                }
            }
            elseif ($names == "Empresas") {
                $member = Empresas::where('nombre', '=', $request->nombre)->value('id');
                if ($member == "") {
                    $file = $request->file('imglogo');
                    $nombre = $file->getClientOriginalName();
                    Empresas::create([
                        'nombre' => $request->nombre,
                        'direccion' => $request->direccion,
                        'telefono' => $request->telefono,
                        'imglogo' => $nombre,
                        'activo' => $request->activo,
                        'id_user' => $request->id_user,
                    ]);
                  
                     $fileKey=$request->file('imglogo');
                     $nombreKey = $fileKey->getClientOriginalName();
                     \Storage::disk('logos')->put($nombreKey,  \File::get($fileKey));
              
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                } else {
                    return redirect()->to($url)->withStatus(__('El nombre de la empresa ya existe.'));
                }
            }
            elseif ($names == "Bombas") {
            
            $veribom=CatBombas::where('numero', '=', $request->numero)->value('id');
              
              if($veribom == null){
                  
                $empresa = Station::where('id', '=', $request->id_estacion)->value('id_empresa');
        
                    CatBombas::create([
                        'nombre' => $request->nombre,
                        'numero' => $request->numero,
                        'id_estacion' => $request->id_estacion,
                        'id_empresa' => $empresa,
                        'activo' => 1,
                    ]);
                  
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
              }
              else{
                    return redirect()->to($url)->withStatus(__('El numero de la bomba ya existe.'));
              }
                
            } 
            elseif ($names == "Estaciones") {
              
              $veriesta=Station::where('number_station', '=', $request->numero)->value('id');
              //dd($veriesta);
              if($veriesta == null){
                 
              $usuario=Empresas::where('id', '=', $request->id_empresa)->value('id_user');
                $empresa=$request->id_empresa;
                   //  dd($request->emailfiscal);
               Station::create([
                    'name' => $request->name,
                    'number_station' =>$request->numero,
                    'address' => $request->direccion,
                    'telefono' => $request->telefono,
                    'total_timbres' => 5,
                    'total_facturas' => 0,
                    'telefono' => $request->telefono,
                    'id_empresa' => $empresa,
                    'id_type' => 1,
                    'activo' => 1
                ]);
             
                $esta=Station::where('id_empresa', '=', $empresa)
                ->where('number_station', '=', $request->numero)
                ->where('address', '=', $request->direccion)
                ->where('name', '=', $request->name)
                ->value('id');
                
                 if($request->file('fileimg') != null){
                   $fileImg=$request->file('fileimg');
                    \Storage::disk('estaciones')->put($request->name.'.jpg',  \File::get($fileImg));
                }
                else{           
                    return redirect()->to($url)->withStatus(__('Tiene que cargar la imagen de la estaci��n.'));
                    }
                    
                    
                 /*if($request->file('fileKey') != null and $request->file('fileCer') != null){
               // Creando una carpeta en en storage
                \Storage::makeDirectory('csd/' . $esta);
    
               $fileKey=$request->file('fileKey');
               $nombreKey = $fileKey->getClientOriginalName();
               \Storage::disk('empresas')->put('/'.$esta.'/'.$nombreKey,  \File::get($fileKey));
    
               $fileCer=$request->file('fileCer');
               $nombreCer = $fileCer->getClientOriginalName();
               \Storage::disk('empresas')->put('/'.$esta.'/'.$nombreCer,  \File::get($fileCer));
                }
                else{           
                    return redirect()->to($url)->withStatus(__('Tiene que cargar los archivos CER y KEY.'));
                    }
                
                if($request->file('consituacion') != null){
                   $fileCon=$request->file('consituacion');
                   $nombreCon = $fileCon->getClientOriginalName();
                   \Storage::disk('empresas')->put('/'.$esta.'/'.$nombreCon,  \File::get($fileCon));
                }
                else{           
                    return redirect()->to($url)->withStatus(__('Tiene que cargar la constancia.'));
                    }
           
           
                FacturaEmisor::create([
                    'nombre' => $request->nombre,
                    'rfc' =>$request->rfc,
                    'regimenfiscal' => $request->regimenfiscal,
                    'direccionfiscal' => $request->direccion,
                    'cp' => $request->codigopostal,
                    'emailfiscal' => $request->emailfiscal,
                    'archivocer' => $nombreCer,
                    'archivokey' => $nombreKey,
                    'consituacion' => $nombreCon,
                    'avredescripcion1' => $request->avredescripcion1,
                    'descripcion1' => $request->descripcion1,
                    'avredescripcion2' => $request->avredescripcion2,
                    'descripcion2' => $request->descripcion2,
                    'avredescripcion3' => $request->avredescripcion3,
                    'descripcion3' => $request->descripcion3,
                    'nocertificado' => $request->nocertificado,
                    'passcerti' => $request->passcerti,
                    //'cuenta' => $request->cuenta,
                    'pass' => $request->rfc,
                    'user' => $request->emailfiscal,
                    'id_user' => $usuario,
                    'id_estacion' => $esta,
                    'id_empresa' => $empresa,
                ]);
               
                 $Data = ['token' => 'Bearer T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRkZEFZcDFhY3lhUC95OUZOaU1xZGttU2ttV0RUQjZyZVIwNDRzUTRTVVlGckRJREdyclBhbWk0QmZyblRkaUtIVFQ0dGRKMExqZFpTS0wydzdNcEg4QmVrWEQ4L1RMZkxkUU5WV1duMTJTOTd6OWY3U0ZVVU9YNzBua2xCSjE0N3o1dTVEbGRqU280cXVjWFgvOGV0NjQwbGFsMm5Xak5NckJLRHdreXNGUzVhbllxSlpSdURjWjA1TEdWSW1seW9INXFMVVY4SEtvYlgrT0N3N0pjaFpuOExLR0REY0phNG42TG83RDJvL3ZVRzk2ZmRISXVUQUhVamlOVERzK09ucmtEWmxyYitpaHVyRlhqVUd0dVF5dThiTklyL3JFdFVPV2VSZ2gyUWFxU2NoczdvRlNIL3JBK3IweUVoNXVJdC9kVmdWbzVpUm9xeC96RmYwYWZVY0UrVWllc0M4WmNKZUdWaWZnaG4rbDVDRFVyMkgwZFpJdU5QL2QrSlA4Qlc.HTktXkSaHo82KUTDpF2gzt5N4fgF8xK1zJ5DDC_xANI',
                        'url' => 'https://api.sw.com.mx/management/api/users'];

                        $JsonBody = json_encode(['Email' => $request->emailfiscal,
                            'Password' => $request->rfc,
                            'Name' => $request->nombre,
                            'RFC' => $request->rfc,
                            'Profile' => 3,
                            'Stamps' => 5,
                            'IdParent' => '2e95f8ce-e6a5-4d4d-bd88-2d2a947a412d',
                            'Unlimited' => false,
                            'Active' => true
                            ]);
                        
                        $resultadoJson = self::CallAPI($Data, $JsonBody);
                
                         //dd($resultadoJson);
                
                    if($resultadoJson->status=="success"){
            
                        $params = array(
                            "url"=>"http://services.sw.com.mx",
                            "user"=>$request->emailfiscal,
                            "password"=>$request->rfc
                              );
            
                        try {        
                            $isactivo = true;
                            $type = "stamp";
                            $password = $request->passcerti;
                           
                            $rutaCer = storage_path("app/csd/2/CSD_GASA_SGP740904213_20161018_124351s.cer");
                            $rutaKey = storage_path("app/csd/2/CSD_GASA_SGP740904213_20161018_124351.key");
                            
                            $b64Cer = base64_encode(file_get_contents($rutaCer));
                            $b64Key = base64_encode(file_get_contents($rutaKey));
                            CsdService::Set($params);
                            $response = CsdService::UploadCsd($isactivo, $type, $b64Cer, $b64Key, $password);
                            //dd($response);
                             if($response->status=="success"){
                                return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                            }
                             else{
                                  return redirect()->to($url)->withStatus(__('La cuenta se registro pero el CER Y KEY no estan autorizados.'));
                             }
                        }
                        catch(Exception $e){
                              $e->getMessage();
                        }
                    }
                    else{
                        return redirect()->to($url)->withStatus(__('Error no se registro la cuenta puede ser que ya exista.' + $resultadoJson->message));
                    }*/

                
                
              }
              else{
                        return redirect()->to($url)->withStatus(__('El n��mero de la estaci��n ya existe.'));
              }
                        return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
            }
            elseif ($names == "Precios") {
            
                  $precio = (($request->num_ticket) * ($request->costo_timbre));
                  $precioadmin = (($request->num_ticket) * ($request->costo_timbre_admin));
                  $ganancia = (($precio) - ($precioadmin));
                    CatPrecios::create([
                        'num_ticket' => $request->num_ticket,
                        'costo' => $precio,
                        'costo_timbre' => $request->costo_timbre,
                        'costo_admin' => $precioadmin,
                        'costo_timbre_admin' => $request->costo_timbre_admin,
                        'ganancia' => $ganancia,
                ]);
                  
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                
            } 
            
            //****LEALTAD *******************************************************
            elseif($names == "Membresia"){
                date_default_timezone_set("America/Mexico_City");
                $fecha = date('Y-m-d') ; // Fecha
                $order = Memberships::create([
                'number_usuario' => $request->qr_membership,
                'active' => $request->active,
                'todate' => $fecha,
                ]);
                 return redirect()->to($url);
            }
            elseif($names == "QR"){
                 
                if($request->qr_membership != ""){
                
                 $verifi = Memberships::where('number_usuario', '=', $request->qr_membership)->value('id');  
               if($verifi == ""){
          
                date_default_timezone_set("America/Mexico_City");
                $fecha = date('Y-m-d') ; // Fecha
                
                $order = Memberships::create([
                'number_usuario' => $request->qr_membership,
                'active' => $request->active,
                'todate' => $fecha,
                'totals' => 0,
                'visits' => 0,
                'id_users' => 0,]);    
                 return redirect()->to($url)->with('message', "EL QR se ingreso correctamente");         
               }
               else{
                 return redirect()->to($url)->with('message', "EL QR ya existe");         
               }
               
                }
                else{
                    $file = $request->file('qr');
                   //obtenemos el nombre del archivo
                   $nombre = $file->getClientOriginalName();
                   //indicamos que queremos guardar un nuevo archivo en el disco local
                   \Storage::disk('local')->put($nombre,  \File::get($file));
                   
                    Excel::load('/storage/app/'.$nombre, function($reader) {
                     date_default_timezone_set("America/Mexico_City");
                     $fecha = date('Y-m-d') ; // Fecha
                                
                     foreach ($reader->get() as $book) {
                     $verifi = Memberships::where('number_usuario', '=', $request->qr_membership)->value('id');  
                     if($verifi == ""){
          
                     Memberships::create([
                     'number_usuario' => $book->qr_membership,
                     'active' =>$book->active,
                     'todate' => $fecha,
                     'totals' => 0,
                     'visits' => 0,
                     'id_users' => 0
                     ]);
                     }
                     }
                 });
                          return redirect()->to($url);
               }
          }
            elseif($names == "Despachador"){
              
               $qr_dispatcher = Dispatcher::where('qr_dispatcher', '=', $request->qr_dispatcher)->value('qr_dispatcher');  
          
               if($request->qr_dispatcher == $qr_dispatcher){
                          return redirect()->to($url)->with('message', "EL QR del despachador ya existe");         
               }
               else{
                    $datos = User::create([
                    'name' => $request->name,
                    'first_surname' => $request->first_surname,
                    'username' => $request->qr_dispatcher,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'sex' => $request->sex,
                    ]);
                  
                    date_default_timezone_set("America/Mexico_City");
                    $fecha = date('Y-m-d') ; // Fecha
                    $id_user = User::where('username', '=', $request->qr_dispatcher)->value('id');
                    $dato = Dispatcher::create([
                    'qr_dispatcher' => $request->qr_dispatcher,
                    'active' => $request->active,
                    'todate' => $fecha,
                    'id_users' => $id_user,
                    'id_station' => $request->id_station,
                    ]);
                    
                    $dat = Role_User::create([
                    'user_id' => $id_user,
                    'role_id' => 4,
                    ]);
                   
                     return redirect()->to($url);        
                    
               }
          }
            elseif($names == "Administradores de Estacion"){
              
               $faturation = User::where('username', '=', $request->username)->value('username');  
          
               if($request->username == $faturation){
                          return redirect()->to($url)->with('message', "EL usuario ya existe");         
               }
               else{
               $datos = User::create([
                'name' => $request->name,
                'first_surname' => $request->first_surname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'sex' => $request->sex,
                ]);
              
                date_default_timezone_set("America/Mexico_City");
                $fecha = date('Y-m-d') ; // Fecha
                $id_user = User::where('username', '=', $request->username)->value('id');
                $dato = Faturation::create([
                'active' => $request->active,
                'todate' => $fecha,
                'id_users' => $id_user,
                'id_station' => $request->id_station,
                ]);
                
                $dat = Role_User::create([
                'user_id' => $id_user,
                'role_id' => 3,
                ]);
                 return redirect()->to($url);        
         
               }
                
             }
            elseif($names == "Administracion Vale"){
              
              $verivoucher = Voucher::where('id_station', '=', $request->id_station)->value('id');
              if($verivoucher == null){
              $vericount = Count_Voucher::where('id_station', '=', $request->id_station)->value('id');
              if($vericount != null){
              $tot = Count_Voucher::where('id_station', '=', $request->id_station)->value('max');
               $datos = Voucher::create([
                'name' => $request->name,
                'points' => $request->points,
                'value' => $request->value,
                'id_status' => $request->id_status,
                'id_station' => $request->id_station,
                'id_count_voucher' => $vericount,
                'total_voucher' => $tot,
                ]);
              
                  return redirect()->to($url)->withStatus(__('Se agrego correctamente.'));
               
              }
              else{
                  return redirect()->to($url)->withStatus(__('No tiene un conteo en esta estacion.'));
              }
              
              }
              else{
                  return redirect()->to($url)->withStatus(__('Ya existe un vale en esta estacion.'));
              }
              
             }
            elseif($names == "Administracion Premio"){
              
              if($request->file('fileimg') != null){
                   $fileCon=$request->file('fileimg');
                   $nombreCon = $fileCon->getClientOriginalName();
                   \Storage::disk('premios')->put($nombreCon,  \File::get($fileCon));
                }
                    else{           
                    return redirect()->to($url)->withStatus(__('Tiene que cargar la imagen.'));
                    }
                
                
                $datos = Awards::create([
                'name' => $request->name,
                'points' => $request->puntos,
                'value' => $request->valor,
                'id_status' => $request->id_status,
                'id_station' => 1,
                'active' => $request->activo,
                'img' => $nombreCon,
                ]);
               
                 return redirect()->to($url)->withStatus(__('Se agrego correctamente.'));      
          }
            elseif($names == "Agregar Vales"){
              
            $verificacion = Count_Voucher::select('max')->orderBy('id', 'desc')->limit(1)->value('max');
                
              //verificamos si existe en el rango indicado
             // $verificacion = \DB::table('count_vouchers')->value('max');
                    //->whereBetween('max', array($request->min, $request->max))->value('max');
              if($verificacion < $request->min){
                  if($request->min < $request->max){
                 
                   //suma de cuantos vales se agregaron
                  $contador=0;  
                  for ($i = $request->min; $i <= $request->max; $i++){ $contador++; }
                        $voucher = Voucher::where('id_station', '=', $request->id_station)->value('total_voucher');
                     
                     $datos = Count_Voucher::create([
                    'id_station' => $request->id_station,
                    'min' => $request->min,
                    'max' => $request->max,
                    ]);
                     
                        $total = ($voucher + $contador);                                
                             $update = Voucher::where('id_station', '=', $request->id_station)
                            ->update(['total_voucher' => $total]);
                            
                            $primera = Voucher::where('id_station', '=', $request->id_station)->value('id_count_voucher');
                            
                            if($primera == 0){
                            $valorcount = Count_Voucher::where('id_station', '=', $request->id_station)
                                                       ->where('min', '=', $request->min)
                                                       ->where('max', '=', $request->max)
                                                       ->value('id');
                             $update = Voucher::where('id_station', '=', $request->id_station)
                            ->update(['id_count_voucher' => $valorcount]); 
                            }
                            
                     return redirect()->to($url)->withStatus("Se guardo con exito");         
                      
                  }
                  else{
                     return redirect()->to($url)->withStatus("Lo siento el numero minimo $request->min tiene que ser menor a el numero $request->max");         
                  }
              }
              else{
                return redirect()->to($url)->withStatus("Lo siento el numero minimo tiene que ser mayor a $verificacion");         
              }        
          }
            elseif($names == "Asignar Membresias"){
              
            $verifi = Memberships::where('number_usuario', '=', $request->number_usuario)->value('id');  
            
            if($verifi != " "){
                //dd($request->all());
              if($request->membresia1 != null){
                   //dd($request->membresia1);
               $vconj = ConjuntoMembership::where('membresia', '=', $request->membresia1)->value('id'); 
               //dd($vconj);
               if($vconj == null){
               //dd($request->membresia1);
               $datos = ConjuntoMembership::create([
               'membresia' => $request->membresia1,
               'number_usuario' => $request->number_usuario,
               'puntos' => 0,
               ]);
               
               }
              }
                //dd($request->membresia2);
              if($request->membresia2 != null){
               $vconj = ConjuntoMembership::where('membresia', '=', $request->membresia2)->value('id'); 
                    //dd($vconj);
               if($vconj == null){
                    //dd($request->membresia2);
              $datos = ConjuntoMembership::create([
               'membresia' => $request->membresia2,
               'number_usuario' => $request->number_usuario,
               'puntos' => 0,
               ]);
               }
              }
              
              if($request->membresia3 != null){
               $vconj = ConjuntoMembership::where('membresia', '=', $request->membresia3)->value('id'); 
               if($vconj == null){
              $datos = ConjuntoMembership::create([
               'membresia' => $request->membresia3,
               'number_usuario' => $request->number_usuario,
               'puntos' => 0,
               ]);
               }
              }
              
              if($request->membresia4 != null){
               $vconj = ConjuntoMembership::where('membresia', '=', $request->membresia4)->value('id'); 
               if($vconj == null){
              $datos = ConjuntoMembership::create([
               'membresia' => $request->membresia4,
               'number_usuario' => $request->number_usuario,
               'puntos' => 0,
               ]);
               }
              }
              
              if($request->membresia5 != null){
               $vconj = ConjuntoMembership::where('membresia', '=', $request->membresia5)->value('id'); 
               if($vconj == null){
              $datos = ConjuntoMembership::create([
               'membresia' => $request->membresia5,
               'number_usuario' => $request->number_usuario,
               'puntos' => 0,
               ]);
               }
              }
              
                return redirect()->to($url)->withStatus(__('Se agregaron correctamente'));         
            }
            else{
                return redirect()->to($url)->withStatus(__('La membresia no existe'));        
            }
         }
             else {
                $url = $this->getUrlPrefix();
                $data = $model::create($request->all());
                return redirect()->to($url);
            }
        }
    }

    //----------------------------------------------------------------------------------------------------------------------- 
    public function getEdit($id)
    {
        
        $model = $this->getModelInstance();
        $data = $model::findOrFail($id);
        $names = $this->name;
        
        if($names == "Pagos"){
        $url = $this->getUrlPrefix();
        $valor= $id;
        return view($this->tpl_prefix.'timbre.subirarchivo', array('catalog' => $this),compact('valor'));
        }
        else if($names == "Usuarios Empresas"){
        $url = $this->getUrlPrefix();
        $valor= $id;
        $user=User::where('id', '=', $id)->get();
        $empr=Empresas::where('id_user', '=', $id)->get();
        //dd($empr);
        return view($this->tpl_prefix.'timbre.usuarioempresaedit', array('catalog' => $this),compact('valor','user','empr'));
        }
        else if($names == "Usuarios"){
         
        $url = $this->getUrlPrefix();
        $valor= $id;
        $user=User::where('id', '=', $id)->get();
        $membresia=memberships::where('id_users', '=', $id)->get();
        $membresia = Memberships::select('tarjeta.id', 'tarjeta.number_usuario', 'tarjeta.todate', 'tarjeta.todate', 'tarjeta.totals', 'tarjeta.visits', 'users.name', 'users.first_surname',  \DB::raw('count(canjes.number_usuario) as total'), \DB::raw('count(history.number_usuario) as totalhistory'))
                ->leftjoin('canjes', 'tarjeta.number_usuario', '=', 'canjes.number_usuario')
                ->leftjoin('history', 'tarjeta.number_usuario', '=', 'history.number_usuario')
                ->leftjoin('users', 'tarjeta.number_usuario', '=', 'users.username')
                ->where('id_users', '=', $id)
                ->groupBy('canjes.number_usuario')
                ->groupBy('tarjeta.id')
                ->groupBy('tarjeta.todate')
                ->groupBy('tarjeta.totals')
                ->groupBy('tarjeta.visits')
                ->get();
        
         $username=User::where('id', '=', $id)->value('username');
       
          $id_imagen = User::where('username', '=', $username)->value('image');
              
                    if($id_imagen == null){
                    $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($username, 'QRCODE'). ' ';
                    list(, $Base64Img) = explode(';', $Base64Img);
                    list(, $Base64Img) = explode(',', $Base64Img);
                    $Base64Img = base64_decode($Base64Img);
                    file_put_contents("img/usuarioimg/$username.jpg", $Base64Img); 
                    
                    $t = User::find($id);
                    $t->image = $username;
                    $t->save();
                    }
                    
        $empr=FacturaReceptor::where('id_user', '=', $id)->get();
        
        $ids = \Auth::user()->id;
        $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
    
            if ($rol == 1 || $rol == 6) { //verifica si es un usuario
            return view($this->tpl_prefix.'timbre.usuarioclientedit', array('catalog' => $this),compact('valor','user','empr','membresia'));
            }
            else if($rol == 3) {
            return view($this->tpl_prefix.'timbre.usuarioclienteditestacion', array('catalog' => $this),compact('valor','user','empr','membresia'));
            }
        }
        elseif($names == "Usuarios de Estaciones"){
            $form = \FormBuilder::create('App\Core\Forms\Admin\UserEstacionesEditForm', [
            'model' => $data,
            'method' => 'POST',
            'url' => ($this->url_prefix.'/edit/'.$id)
           ]);
           return view($this->tpl_prefix.'edit',array('catalog'=>$this), compact('form'));                     
        }
        else if($names == "Estaciones"){
        $url = $this->getUrlPrefix();
        $valor= $id;
        $user=Station::where('id', '=', $id)->get();
        $empr=FacturaEmisor::where('id_estacion', '=', $id)->get();
        return view($this->tpl_prefix.'timbre.estacionempresaedit', array('catalog' => $this),compact('valor','user','empr'));
        }
       
        /*  LEALTAD **************************************************************************/
        elseif($names == "Despachador"){
            $form = \FormBuilder::create('App\Core\Forms\Admin\Dispatcher2Form', [
            'model' => $data,
            'method' => 'POST',
            'url' => ($this->url_prefix.'/edit/'.$id)
           ]);
           return view($this->tpl_prefix.'edit',array('catalog'=>$this), compact('form'));
        }
        elseif($names == "Usuarios con mas puntos"){
        $request->session()->forget('detalles');
        $request->session()->put('detalles', $id);
                  
        return redirect("usuariodetalle");
               
        }
        elseif($names == "Administradores de Estacion"){
            $form = \FormBuilder::create('App\Core\Forms\Admin\Faturation2Form', [
            'model' => $data,
            'method' => 'POST',
            'url' => ($this->url_prefix.'/edit/'.$id)
           ]);
           return view($this->tpl_prefix.'edit',array('catalog'=>$this), compact('form'));
        }
        elseif($names == "Vale"){
              $id_us = \Auth::user()->id;
               $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->value('role_id');
                 if($rol != ""){ //verifica si es un usuario
                    date_default_timezone_set("America/Mexico_City");
                    $fech = date('Y-m-d') ; $i = "$fech 00:00:00"; $f = "$fech 23:59:59";
                    $qr_memberships = Memberships::where('id_users', '=', $id_us)->value('number_usuario');
                    $count1 = Exchange::where('number_usuario', '=', $qr_memberships)->where('estado_uno', '>=', $i)->where('estado_uno', '<=', $f)->count(); //contar del exchange
                    $count2 = History::where('number_usuario', '=', $qr_memberships)->where('todate', '>=', $i)->where('todate', '<=', $f)->count(); //contar del historial
                    $newcount1 = ($count1 + $count2); //suma los numeros existen en las 2 tablas
                    $countVaucher = Voucher::where('id', '=', $id)->value('id_count_voucher'); //id del contador de vaucher actual 
                    $maxVoucher = Count_Voucher::where('id', '=', $countVaucher)->value('max'); //saca el maximo del count vaucher
                    $voucher_valores = Voucher::findOrFail($id); //saca toda la fila de voucher
                    
                    if($newcount1 < 1){ //cuenta los vaucher en general vales y premios y regresa si son menores a tres
                    $fecha = date('Y-m-d h:i') ; // Fecha 
                    //muestra el numero ultimo de exchange 
                    $count11 = Exchange::select('conta')->orderBy('id', 'desc')->limit(1)->where('id_estacion', '=', $voucher_valores->id_station)->max('conta');
                    $count22 = History::select('numero')->orderBy('id', 'desc')->limit(1)->where('id_station', '=', $voucher_valores->id_station)->max('numero');                              
                    if($count11 > $count22){ $newcount = $count11; } else {$newcount = $count22; }
                    $total_points = Memberships::where('id_users', '=', $id_us)->value('totals'); //total de puntos que se tienen
                    $number1 = (int)$count11;
                 
                // dd($countVaucher);
              
                     if($number1 < $maxVoucher){ //verifica si el numero es menor al maximo de numero de vales que hay
                           if($total_points >= $voucher_valores->points){ //verifica si le alcansan los puntos a la membresia
                                $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                                $numero1 = Exchange::select('conta')->orderBy('id', 'desc')->limit(1)->where('id_estacion', '=', $voucher_valores->id_station)->max('conta');
                                $numero2 = History::select('numero')->orderBy('id', 'desc')->limit(1)->where('id_station', '=', $voucher_valores->id_station)->max('numero');
                                if($numero1 == null and $numero2 == null){ //verifica que los numeros no estan vacios
                                  $c  = Count_Voucher::where('id', '=', $countVaucher)->value('min');
                                  $newnumero = $c; //declara a nuevo numero con el minimo que existe                     
                                }
                                else{
                                   if($numero1 > $numero2){ $newnumero = $numero1+1; } else { $newnumero = $numero2+1;} //toma el valor maximo de cualquier de las 2 tablas
                                }     
                           }
                           else{
                                $url = $this->getUrlPrefix();
                                //return redirect()->to($url)->with('message', 'No se tiene suficientes puntos.'); 
                                return redirect()->to($url)->withStatus(__('No se tiene suficientes puntos.'));
        
                           }      
                        } 
                        
                        
                        
                        else{
                      
                            $cou  = Count_Voucher::where('id_station', '=', $voucher_valores->id_station)->where('max', '>', $newcount)->value('id');
                          // dd($cou);
                            if($newcount == null){ // verifica que exista algun vale en las tablas 
                                $newcount = Count_Voucher::where('id_station', '=', $countVaucher)->value('min'); // se le asigna el numero minimo que existe 
                            }
                            elseif($cou == null){
                                $url = $this->getUrlPrefix();
                                //return redirect()->to($url)->with('message', 'Se acabaron los vales en esta estacion.');
                                return redirect()->to($url)->withStatus(__('Se acabaron los vales en esta estacion.'));
        
                            }
                            else{
                            $update = Voucher::where('id', '=', $id)
                            ->update(['id_count_voucher' => $cou]);
                             $newnumero  = Count_Voucher::where('id', '=', $cou)->value('min');                 
                            }
                        }
                     
                           
                      $alea = Exchange::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
                      $ano = date('Y') ; $mes = date('m') ; $dia = date('d') ; // dia
                      if($alea != ""){ $str = (string) $alea+1;  $folio=($ano.$mes.$dia.$str); }
                      else{ $alea = 0; $str = $alea+1;  $folio=($ano.$mes.$dia.$str); }
                    
                    $datos = Exchange::create([
                        'identificador' => $folio,
                        'conta' => $newnumero,
                        'generado' => "Web",
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
         
                           $decrement = \DB::table('vouchers')->where('id', '=', $id)->decrement('total_voucher', 1);     
         
                        $station = Station::where('id', '=', $voucher_valores->id_station)->value('name');
                       $url = $this->getUrlPrefix();
                       return redirect()->to("/")->withStatus(__('Recuerda presentar este Folio ' . $folio . ' junto con tu identificacion oficial en la estacion que seleccionaste, Recuerda que solo en esta estacion ' . $station . ' se podra entregar.'));
                              
                }
                else{
                       $url = $this->getUrlPrefix();
                       
                       return redirect()->to($url)->withStatus(__('Solo se permiten 1 vale por dia.'));
                }
            }
        }
        elseif($names == "Premio"){
            $id_us = \Auth::user()->id;
            $rol = Role_User::where('user_id', '=', $id_us)->where('role_id', '=', 5)->get();
            if($rol != ""){
            $form = \FormBuilder::create('App\Core\Forms\Admin\Voucher2Form', [
            'model' => $data,
            'method' => 'POST',
            'url' => ($this->url_prefix.'/edit/'.$id)
           ]);
           return view($this->tpl_prefix.'edit',array('catalog'=>$this), compact('form'));                     
            }
            else{
            $form = \FormBuilder::create($this->form, [
            'model' => $data,
            'method' => 'POST',
            'url' => ($this->url_prefix.'/edit/'.$id)
           ]);
           return view($this->tpl_prefix.'edit',array('catalog'=>$this), compact('form'));          
            }
        }
        else if($names == "Administracion Premio"){
        $url = $this->getUrlPrefix();
        $valor= $id;
        $premio=Awards::where('id', '=', $id)->get();
        //dd($empr);
        return view($this->tpl_prefix.'timbre.premiosedit', array('catalog' => $this),compact('premio','valor'));
        }
        else{
        $form = \FormBuilder::create($this->form, [
            'model' => $data,
            'method' => 'POST',
            'url' => ($this->url_prefix . '/edit/' . $id)
        ]);

        return view($this->tpl_prefix . 'edit', array('catalog' => $this), compact('form'));
        }
    }

    //------------------------------------------------------------------------------------------------------------------------
    public function postEdit(Request $request, $id)
    {
        $model = $this->getModelInstance();
        $v = Validator::make($request->all(), $this->getValidatorAdd());
        $url = $this->getUrlPrefix();
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            $names = $this->name;
            if ($names == "Usuarios") {
                $antiguoemail = User::where('id', '=', $id)->value('email');
                //dd($request->all());
                if ($antiguoemail == $request->email) {
                    if($request->password == ""){
                        $ticket = User::find($id);
                        $ticket->name = $request->name;
                        $ticket->first_surname = $request->app_name;
                        $ticket->second_surname = $request->apm_name;
                        $ticket->email = $request->email;
                        $ticket->sex = $request->sex;
                        $ticket->phone = $request->telefono;
                        $ticket->active = $request->activo;
                        $ticket->save();
                    }
                    else{
                        $ticket = User::find($id);
                        $ticket->name = $request->name;
                        $ticket->first_surname = $request->app_name;
                        $ticket->second_surname = $request->apm_name;
                        $ticket->email = $request->email;
                        $ticket->password = Hash::make($request->password);
                        $ticket->sex = $request->sex;
                        $ticket->phone = $request->telefono;
                        $ticket->active = $request->activo;
                        $ticket->save();
                    }
                    
                    $idempre = FacturaReceptor::where('id_user', '=', $id)->value('id');
                       if($idempre != null){
                        $ticket = FacturaReceptor::find($idempre);
                        $ticket->nombre = $request->nombre;
                        $ticket->rfc = $request->rfc;
                        $ticket->usocfdi = $request->usocfdi;
                        $ticket->emailfiscal = $request->emailfiscal;
                        $ticket->save();
                       }
                   
                } else {
                    $nuevoemail = User::where('email', '=', $request->email)->value('id');
                    if ($nuevoemail == "") {
                       if($request->password == ""){
                        $ticket = User::find($id);
                        $ticket->name = $request->name;
                        $ticket->first_surname = $request->app_name;
                        $ticket->second_surname = $request->apm_name;
                        $ticket->email = $request->email;
                        $ticket->sex = $request->sex;
                        $ticket->phone = $request->telefono;
                        $ticket->active = $request->activo;
                        $ticket->save();
                       }
                       else{
                        $ticket = User::find($id);
                        $ticket->name = $request->name;
                        $ticket->first_surname = $request->app_name;
                        $ticket->second_surname = $request->apm_name;
                        $ticket->email = $request->email;
                        $ticket->password = Hash::make($request->password);
                        $ticket->sex = $request->sex;
                        $ticket->phone = $request->telefono;
                        $ticket->active = $request->activo;
                        $ticket->save();
                       }
                        
                         $idempre = FacturaReceptor::where('id_user', '=', $id)->value('id');
                       if($idempre != null){
                        $ticket = FacturaReceptor::find($idempre);
                        $ticket->nombre = $request->nombre;
                        $ticket->rfc = $request->rfc;
                        $ticket->usocfdi = $request->usocfdi;
                        $ticket->emailfiscal = $request->emailfiscal;
                        $ticket->save();
                       }
                       
                    } else {
                        return redirect()->to($url)->withStatus(__('El correo electronico ya existe.'));
                    }
                }
                return redirect()->to($url)->withStatus(__('Se cambio la informacion correctamente'));
            }
            elseif ($names == "Usuarios de Estaciones") {
                $antiguoemail = User::where('id', '=', $id)->value('email');
                if ($antiguoemail == $request->email) {
                    
                     if($request->password == ""){
                      
                    $ticket = User::find($id);
                    $ticket->name = $request->name;
                    $ticket->first_surname = $request->first_surname;
                    $ticket->second_surname = $request->second_surname;
                    $ticket->email = $request->email;
                    $ticket->sex = $request->sex;
                    $ticket->phone = $request->telefono;
                    $ticket->save();
                     }
                     else{
                    $ticket = User::find($id);
                    $ticket->name = $request->name;
                    $ticket->first_surname = $request->first_surname;
                    $ticket->second_surname = $request->second_surname;
                    $ticket->email = $request->email;
                    $ticket->password = Hash::make($request->password);
                    $ticket->sex = $request->sex;
                    $ticket->phone = $request->telefono;
                    $ticket->save();
                         
                     }
                } else {
                    $nuevoemail = User::where('email', '=', $request->email)->value('id');
                    if ($nuevoemail == "") {
                          if($request->password == ""){
                   
                        $ticket = User::find($id);
                        $ticket->name = $request->name;
                        $ticket->first_surname = $request->first_surname;
                        $ticket->second_surname = $request->second_surname;
                        $ticket->email = $request->email;
                        $ticket->sex = $request->sex;
                        $ticket->phone = $request->telefono;
                        $ticket->save();
                        }
                        else{
                        $ticket = User::find($id);
                        $ticket->name = $request->name;
                        $ticket->first_surname = $request->first_surname;
                        $ticket->second_surname = $request->second_surname;
                        $ticket->email = $request->email;
                        $ticket->password = Hash::make($request->password);
                        $ticket->sex = $request->sex;
                        $ticket->phone = $request->telefono;
                        $ticket->save();
                        
                        }
                        
                    } else {
                        return redirect()->to($url)->withStatus(__('El correo electronico ya existe.'));
                    }
                }
                return redirect()->to($url)->withStatus(__('Se cambio la informacion correctamente'));
            }
            else if ($names == "Usuarios Empresas") {
                //dd($request->all());
                $antiguoemail = User::where('id', '=', $id)->value('email');
                if ($antiguoemail == $request->email) {
                   // dd($request->all());
                       if($request->password == ""){
                            $ticket = User::find($id);
                            $ticket->name = $request->name;
                            $ticket->first_surname = $request->first_surname;
                            $ticket->second_surname = $request->second_surname;
                            $ticket->username = $request->nombre;
                            $ticket->email = $request->email;
                            $ticket->sex = $request->sex;
                            $ticket->phone = $request->telefono;
                            $ticket->activo = $request->activo;
                            $ticket->save();
                       }
                       else{
                            $ticket = User::find($id);
                            $ticket->name = $request->name;
                            $ticket->first_surname = $request->first_surname;
                            $ticket->second_surname = $request->second_surname;
                            $ticket->username = $request->nombre;
                            $ticket->email = $request->email;
                            $ticket->password = Hash::make($request->password);
                            $ticket->sex = $request->sex;
                            $ticket->phone = $request->telefono;
                            $ticket->activo = $request->activo;
                            $ticket->save();
                       }
                     $idempre = Empresas::where('id_user', '=', $id)->value('id');
                    
                    if($request->file('imglogo') != null){
                    $file = $request->file('imglogo');
                    $nombre = $file->getClientOriginalName();
                    \Storage::disk('logos')->put($nombre,  \File::get($file));
                    }
                    else{
                        $nombre = Empresas::where('id_user', '=', $id)->value('imglogo');
                    }
                    
                    $ticket = Empresas::find($idempre);
                    $ticket->nombre = $request->nombre;
                    $ticket->direccion = $request->direccion;
                    $ticket->phone = $request->telefonoempresa;
                    $ticket->imglogo = $nombre;
                    $ticket->activo = $request->activo;
                    $ticket->save();
                   
                    
                } else {
                    $nuevoemail = User::where('email', '=', $request->email)->value('id');
                    if ($nuevoemail == "") {
                    if($request->password == ""){
                       
                     $ticket = User::find($id);
                    $ticket->name = $request->name;
                    $ticket->first_surname = $request->first_surname;
                    $ticket->second_surname = $request->second_surname;
                    $ticket->username = $request->nombre;
                    $ticket->email = $request->email;
                    $ticket->sex = $request->sex;
                    $ticket->phone = $request->telefono;
                    $ticket->active = $request->activo;
                    $ticket->save();
                    }
                    else{
                     $ticket = User::find($id);
                    $ticket->name = $request->name;
                    $ticket->first_surname = $request->first_surname;
                    $ticket->second_surname = $request->second_surname;
                    $ticket->username = $request->nombre;
                    $ticket->email = $request->email;
                    $ticket->password = Hash::make($request->password);
                    $ticket->sex = $request->sex;
                    $ticket->phone = $request->telefono;
                    $ticket->active = $request->activo;
                    $ticket->save();
                        
                    }
                    
                    $idempre = Empresas::where('id_user', '=', $id)->value('id');
                    
                    if($request->file('imglogo') != null){
                    $file = $request->file('imglogo');
                    $nombre = $file->getClientOriginalName();
                    \Storage::disk('logos')->put($nombre,  \File::get($file));
                    }
                    else{
                        $nombre = Empresas::where('id_user', '=', $id)->value('imglogo');
                    }
                    
                    $ticket = Empresas::find($idempre);
                    $ticket->nombre = $request->nombre;
                    $ticket->direccion = $request->direccion;
                    $ticket->phone = $request->telefonoempresa;
                    $ticket->imglogo = $nombre;
                    $ticket->activo = $request->activo;
                    $ticket->save();
                  
                    } else {
                        return redirect()->to($url)->withStatus(__('El correo electronico ya existe.'));
                    }
                }
                return redirect()->to($url)->withStatus(__('Se cambio la informacion correctamente'));
            }
            else if($names == "Pagos"){
               $nombre = $id;
               $fileKey=$request->file('fileKey');
               $nombreKey = $fileKey->getClientOriginalName();
                  \Storage::disk('pagos')->put($id.''.$nombreKey,  \File::get($fileKey));
    
                 $pago=Pagos::find($id);
                 $pago->archivo=$id.''.$nombreKey;
                 $pago->save();
            
             $nombre = "ricardo.resendiz@digitalsoft.mx";
             $de = "ricardo.resendiz@digitalsoft.mx";
             $asunto  = "Autorizar Pago";
             $para = "ricardo.resendiz@digitalsoft.mx"; 
             $titulo = "Autorizar Pago";
                        
             $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo);
        
             Mail::send('mails.mails2', $data, function($message) use($de, $para){
             $message->from('ricardo.resendiz@digitalsoft.mx', 'Autorizar Pago');
             $message->subject('Autorizar Pago');
             $message->to($para);
             });
                return redirect()->to("pagosautorizados")->withStatus(__('Se agrego el archivo correctamente.'));
                    
            }
            /*elseif ($names == "Bombas") {
            
                $empresa = Station::where('id', '=', $request->id_estacion)->value('id_empresa');
        
                       $ticket = Station::find($id);
                        $ticket->nombre = $request->nombre;
                        $ticket->numero = $request->numero;
                        $ticket->id_estacion = $request->id_estacion;
                        $ticket->id_empresa = $empresa;
                        $ticket->save();
                        
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                
            }*/
             if ($names == "Estaciones") {
                  $usuario=Empresas::where('id', '=', $request->id_empresa)->value('id_user');
            
                    $ticket = Station::find($id);
                    $ticket->name = $request->name;
                    $ticket->number_station = $request->numero;
                    $ticket->address = $request->direccion;
                    $ticket->telefono = $request->telefono;
                    $ticket->id_empresa = $request->id_empresa;
                    $ticket->save();
                
                   /* $idfact=FacturaEmisor::where('id_estacion', '=', $id)->value('id');
                    
                    if($request->file('fileimg') != null){
                    $fileImg=$request->file('fileimg');
                    \Storage::disk('estaciones')->put($request->name.'.jpg',  \File::get($fileImg));
                    }
                    else{           
                    return redirect()->to($url)->withStatus(__('Tiene que cargar la imagen de la estaci��n.'));
                    }
                    
                    if($request->file('fileKey') != null){
                    $fileKey=$request->file('fileKey');
                    $nombreKey = $fileKey->getClientOriginalName();
                    \Storage::disk('empresas')->put('/'.$id.'/'.$nombreKey,  \File::get($fileKey));
                    }
                    else{
                        $nombreKey = FacturaEmisor::where('id_estacion', '=', $id)->value('archivokey');
                    }
                   if($request->file('fileCer') != null){
                    $fileCer=$request->file('fileCer');
                    $nombreCer = $fileCer->getClientOriginalName();
                    \Storage::disk('empresas')->put('/'.$id.'/'.$nombreCer,  \File::get($fileCer));
                    }
                    else{
                        $nombreCer = FacturaEmisor::where('id_estacion', '=', $id)->value('archivocer');
                    }
                   if($request->file('consituacion') != null){
                    $fileCon=$request->file('consituacion');
                    $nombreCon = $fileCon->getClientOriginalName();
                    \Storage::disk('empresas')->put('/'.$id.'/'.$nombreCon,  \File::get($fileCon));
                    }
                    else{
                        $nombreCon = FacturaEmisor::where('id_estacion', '=', $id)->value('consituacion');
                    }
                   
                   
                    $ticket = FacturaEmisor::find($idfact);
                    $ticket->nombre = $request->nombre;
                    $ticket->rfc = $request->rfc;
                    $ticket->regimenfiscal = $request->regimenfiscal;
                    $ticket->direccionfiscal = $request->direccion;
                    $ticket->cp = $request->codigopostal;
                    $ticket->emailfiscal = $request->emailfiscal;
                    $ticket->archivocer = $nombreCer;
                    $ticket->archivokey = $nombreKey;
                    $ticket->consituacion = $nombreCon;
                    $ticket->avredescripcion1 = $request->avredescripcion1;
                    $ticket->descripcion1 = $request->descripcion1;
                    $ticket->avredescripcion2 = $request->avredescripcion2;
                    $ticket->descripcion2 = $request->descripcion2;
                    $ticket->avredescripcion3 = $request->avredescripcion3;
                    $ticket->descripcion3 = $request->descripcion3;
                    $ticket->cuenta = $request->cuenta;
                    //$ticket->pass = $request->pass;
                    //$ticket->user = $request->user;
                    $ticket->id_user = $usuario;
                    $ticket->id_estacion = $id;
                    $ticket->id_empresa = $request->id_empresa;
                    $ticket->save();*/
                
            
                return redirect()->to($url)->withStatus(__('Se cambio la informacion correctamente'));
            }
            elseif ($names == "Precios") {
            
                  $precio = (($request->num_ticket) * ($request->costo_timbre));
                  $precioadmin = (($request->num_ticket) * ($request->costo_timbre_admin));
                  $ganancia = (($precio) - ($precioadmin));
                  
                    $ticket = CatPrecios::find($id);
                    $ticket->num_ticket = $request->num_ticket;
                    $ticket->costo = $precio;
                    $ticket->costo_timbre = $request->costo_timbre;
                    $ticket->costo_admin = $precioadmin;
                    $ticket->costo_timbre_admin = $request->costo_timbre_admin;
                    $ticket->ganancia = $ganancia;
                    $ticket->save();
                
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                
            }
            /* LEALTAD*/
            elseif ($names == "Perfil") {
                 
                 if($request->password == null){
                   
                 $ticket = User::find($id);
                 $ticket->name = $request->name;
                 $ticket->first_surname = $request->first_surname;
                 $ticket->second_surname = $request->second_surname;
                 $ticket->email = $request->email;
                 $ticket->sex = $request->sex;
                 $ticket->cp = $request->cp;
                 $ticket->phone = $request->phone;
                 $ticket->save();
                 
                 $ids = \Auth::user()->id;
                 $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
              
                 if ($rol == 5) { //verifica si es un usuario
                 $id_client = Client::where('user_id', '=', $id)->value('id');
                 $ticket = Client::find($id_client);
                 $ticket->birthdate = $request->birthdate;
                 $ticket->save();
                 }
                 
                 }
                 else{
                 $ticket = User::find($id);
                 $ticket->name = $request->name;
                 $ticket->first_surname = $request->first_surname;
                 $ticket->second_surname = $request->second_surname;
                 $ticket->email = $request->email;
                 $ticket->password = Hash::make($request->password);
                 $ticket->sex = $request->sex;
                 $ticket->cp = $request->cp;
                 $ticket->phone = $request->phone;
                 $ticket->save();
                 
                 $ids = \Auth::user()->id;
                 $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
              
                 if ($rol == 5) { //verifica si es un usuario
                 $id_client = Client::where('user_id', '=', $id)->value('id');
                 $ticket = Client::find($id_client);
                 $ticket->birthdate = $request->birthdate;
                 $ticket->save();
                 }
                
                 }
                 $url = $this->getUrlPrefix();    
                 return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
          }
            elseif ($names == "Usuario") {
           
                  if($request->password == ""){
                 $ticket = User::find($id);
                 $ticket->name = $request->name;
                 $ticket->first_surname = $request->first_surname;
                 $ticket->second_surname = $request->second_surname;
                 $ticket->email = $request->email;
                 $ticket->sex = $request->sex;
                 $ticket->cp = $request->cp;
                 $ticket->phone = $request->phone;
                 $ticket->active = $request->active;
                 $ticket->save();
                 
                 $ids = \Auth::user()->id;
                 $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
              
                 if ($rol == 5) { //verifica si es un usuario
                 $id_client = Client::where('user_id', '=', $id)->value('id');
                 $ticket = Client::find($id_client);
                 $ticket->birthdate = $request->birthdate;
                 $ticket->save();
                 }
                 
                  }
                  else{
                 $ticket = User::find($id);
                 $ticket->name = $request->name;
                 $ticket->first_surname = $request->first_surname;
                 $ticket->second_surname = $request->second_surname;
                 $ticket->email = $request->email;
                 $ticket->password = Hash::make($request->password);
                 $ticket->sex = $request->sex;
                 $ticket->cp = $request->cp;
                 $ticket->phone = $request->phone;
                 $ticket->active = $request->active;
                 $ticket->save();
                 
                 $ids = \Auth::user()->id;
                 $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
              
                 if ($rol == 5) { //verifica si es un usuario
                 $id_client = Client::where('user_id', '=', $id)->value('id');
                 $ticket = Client::find($id_client);
                 $ticket->birthdate = $request->birthdate;
                 $ticket->save();
                 }
                 
                  }
                 $url = $this->getUrlPrefix();    
                 return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                 
          }
            else if($names == "Cobrar"){
	            $id_us = \Auth::user()->id;
	           $state = $request->id_state;
               if($state == 4){
                date_default_timezone_set("America/Mexico_City");
                $fecha = date('Y-m-d h:i') ; // Fecha
                $date = Exchange::findOrFail($id);
                
                if($date->descrip == "Premio"){
                $datos = History::create([
                'folio' => $date->identificador,
                'folio_exchange' => $date->identificador,
                'numero' => $date->conta,
                'id_admin' => $id_us,
                'number_usuario' => $date->number_usuario,
                'id_station' => $date->id_estacion,
                'id_exchange' => 2,
                'points' => $date->punto,
                'value' => $date->value,
                'todate' => $fecha, 
                ]);
                }
                else{
                $datos = History::create([
                'folio' => $date->identificador,
                'folio_exchange' => $date->identificador,
                'numero' => $date->conta,
                'id_admin' => $id_us,
                'number_usuario' => $date->number_usuario,
                'id_station' => $date->id_estacion,
                'id_exchange' => 1,
                'points' => $date->punto,
                'value' => $date->value,
                'todate' => $fecha, 
                ]);
                }
                
                 $data = $model::destroy($id);
                 $url = $this->getUrlPrefix();
                 return redirect()->to($url)->withStatus(__('Se registro correctamente.'));

               }
            }
            elseif($names == "Entrega"){
                
                $id_us = \Auth::user()->id;
	           $state = $request->id_state;
               if($state == 4){
                date_default_timezone_set("America/Mexico_City");
                $fecha = date('Y-m-d h:i') ; // Fecha
                
                $date = Exchange::findOrFail($id);
                if($date->descrip == "Premio"){
                $datos = History::create([
                'folio' => $date->identificador,
                'folio_exchange' => $date->identificador,
                'numero' => $date->conta,
                'id_admin' => $id_us,
                'number_usuario' => $date->number_usuario,
                'id_station' => $date->id_estacion,
                'id_exchange' => 2,
                'points' => $date->punto,
                'value' => $date->value,
                'todate' => $fecha, 
                ]);
                }
                else{
                $datos = History::create([
                'folio' => $date->identificador,
                'folio_exchange' => $date->identificador,
                'numero' => $date->conta,
                'id_admin' => $id_us,
                'number_usuario' => $date->number_usuario,
                'id_station' => $date->id_estacion,
                'id_exchange' => 1,
                'points' => $date->punto,
                'value' => $date->value,
                'todate' => $fecha, 
                ]);
                }                 
                 $data = $model::destroy($id);
                 $url = $this->getUrlPrefix();
                 return redirect()->to($url);

               }
               else{
                $update = Exchange::where('id', '=', $id)
                          ->update(['estado' => 3]);
         
                date_default_timezone_set("America/Mexico_City");
                     $fecha = date('Y-m-d h:i') ; // Fecha
                    
                         $upd = Exchange::where('id', '=', $id)
                          ->update(['estado_tres' => $fecha]);    
      
                $url = $this->getUrlPrefix();
                return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
                }
             
            }
            elseif($names == "Proceso"){
               date_default_timezone_set("America/Mexico_City");
               $fecha = date('Y-m-d h:i') ; // Fecha
                    
                $update = Exchange::where('id', '=', $id)
                          ->update(['estado' => 2]);    
                          
                           $upd = Exchange::where('id', '=', $id)
                          ->update(['estado_dos' => $fecha]);    
                   
                
                $url = $this->getUrlPrefix();
                return redirect()->to($url);  
                
             
            }
            elseif($names == "Administracion de Membresia"){
              
                 $revisar = Memberships::where('number_usuario', '=', $request->qr_membership)->where('id_users', '>', 0)->value('id');
                if($revisar == null){
                    
                $datos = User::create([
                'name' => $request->name,
                'first_surname' => $request->first_surname,
                'second_surname' => $request->second_surname,
                'username' => $request->qr_membership,
                'email' => $request->email,
                'password' => Hash::make($request->qr_membership),
                'sex' => $request->sex,
                'birthdate' => $request->birhtdate
                ]);
                
                $id_user = User::where('username', '=', $request->qr_membership)->value('id');
                $id_us = \Auth::user()->id;
                $station = Faturation::where('id_users', '=', $id_us)->value('id_station');
            
                        $update = Memberships::where('number_usuario', '=', $request->qr_membership)
                          ->update(['id_users' => $id_user]);
                        $updat = Memberships::where('number_usuario', '=', $request->qr_membership)
                          ->update(['active' => $request->active]);
                          
                          if($station != ""){
                          $update = Memberships::where('number_usuario', '=', $request->qr_membership)
                          ->update(['id_station' => $station]);
                          }
                          else{
                           $update = Memberships::where('number_usuario', '=', $request->qr_membership)
                          ->update(['id_station' => null]);
                          }
                
                $dat = Role_User::create([
                'user_id' => $id_user,
                'role_id' => 5,
                ]);
               
                   $url = $this->getUrlPrefix();
                    return redirect()->to($url)->withStatus(__('Se registro correctamente.'));               
                }
                else{
                    $url = $this->getUrlPrefix();
                    return redirect()->to($url)->with('message', 'Esta membresia ya fue asignada');                 
                }
                
                        
          }
            elseif($names == "Membresia"){
              date_default_timezone_set("America/Mexico_City");
              $fecha = date('Y-m-d') ; // Fecha
              $qr_memberships = Memberships::where('id', '=', $id)->value('number_usuario');  
             if($request->qr_membership == $qr_memberships){
                 $update = Memberships::where('number_usuario', '=', $request->qr_membership)
                          ->update(['active' => $request->active]);
             }
             else{

              $qr = Memberships::where('number_usuario', '=', $request->qr_membership)
              ->where('id_users', '=', 0)
              ->value('number_usuario');  
              
              $qr_id = Memberships::where('number_usuario', '=', $request->qr_membership)
              ->where('id_users', '=', 0)
              ->value('id');  
              
             if($request->qr_membership == $qr){
             $id_mem = Memberships::where('id', '=', $id)->value('id_users');  
                    
                    $data = $model::findOrFail($id);
                    $data->fill($request->all());
                    $data->save();
                        
                $datos = Change_Memberships::create([
                'qr_membership' => $request->qr_membership,
                'id_users' => $id_mem,
                'todate' => $fecha,
                'qr_membership_old' => $qr_memberships
                ]);
                
                $update = User::where('id', '=', $id_mem)
                          ->update(['username' => $request->qr_membership]);
                     
                $update = User::where('id', '=', $id_mem)
                          ->update(['password' => Hash::make($request->qr_membership)]);
                
                $update = Exchange::where('number_usuario', '=', $qr_memberships)
                          ->update(['number_usuario' => $request->qr_membership]);
                 $update = Movement::where('number_usuario', '=', $qr_memberships)
                          ->update(['number_usuario' => $request->qr_membership]);
              
                 $update = Memberships::where('number_usuario', '=', $request->qr_membership)
                          ->update(['active' => $request->active]);

                $delete = Memberships::destroy($qr_id);             
         
             
             }
          
             else{
            $url = $this->getUrlPrefix();
                       return redirect()->to($url)->with('message', "EL QR no existe o ya esta ocupado");
             } 

            }             
                   $url = $this->getUrlPrefix();
                   return redirect()->to($url);        
          }
            elseif($names == "Despachador"){
              
               $qr_dispatcher = Dispatcher::where('id', '=', $id)->value('qr_dispatcher'); //QR actual del despachador   
               $qr_dispatcher2 = Dispatcher::where('qr_dispatcher', '=', $request->qr_dispatcher)->value('qr_dispatcher'); //QR que quiere cambiar   
               
               if($qr_dispatcher2 == $request->qr_dispatcher){
                        
                    $update = Dispatcher::where('id', '=', $id)
                          ->update(['active' => $request->active]);                
                    $update = Dispatcher::where('id', '=', $id)
                          ->update(['id_station' => $request->id_station]);                
              }
               else{
                    if($request->qr_dispatcher == $qr_dispatcher2){
                        
                       return redirect()->to($url)->with('message', "EL QR del despachador ya existe");                                 
                    }
                    else{
                    $id_mem = Dispatcher::where('id', '=', $id)->value('id_users');  
                    $data = $model::findOrFail($id);
                    $data->fill($request->all());
                    $data->save();
                       
                    $update = User::where('id', '=', $id_mem)
                          ->update(['username' => $request->qr_dispatcher]);                        
                    }
              }                       
                   $url = $this->getUrlPrefix();
                   return redirect()->to($url);        
          }
            elseif($names == "Usuario Despachador"){
              
                    $id_mem = Dispatcher::where('id', '=', $id)->value('id_users');  
                    $data = $model::findOrFail($id);
                    $data->fill($request->all());
                    $data->save();
                    $pas = Hash::make($request->qr_dispatcher);
                    
                    $update = User::where('id', '=', $id)
                          ->update(['password' => $pas]);                        
                   
                    $url = $this->getUrlPrefix();
                    return redirect()->to($url);     
                    
                     }
            elseif($names == "Usuario de Estacion"){
                    $id_mem = Faturation::where('id', '=', $id)->value('id_users');  
                    $data = $model::findOrFail($id);
                    $data->fill($request->all());
                    $data->save();
                    $pas = Hash::make($request->password);
                    
                    
                    $update = User::where('id', '=', $id)
                          ->update(['password' => $pas]);                        
                   
                    $url = $this->getUrlPrefix();
                    return redirect()->to($url);     
                    
                     }
            elseif($names == "Administracion Premio"){
              
              if($request->file('fileimg') != null){
                   $fileCon=$request->file('fileimg');
                   $nombreCon = $fileCon->getClientOriginalName();
                   \Storage::disk('premios')->put($nombreCon,  \File::get($fileCon));
                
                $ticket = Awards::find($id);
                $ticket->name = $request->name;
                $ticket->points = $request->puntos;
                $ticket->value= $request->valor;
                $ticket->id_status = $request->id_status;
                $ticket->activo = $request->activo;
                $ticket->img = $nombreCon;
                $ticket->save();
                        
              }
                    else{           
                
                $ticket = Awards::find($id);
                $ticket->name = $request->name;
                $ticket->points = $request->puntos;
                $ticket->value= $request->valor;
                $ticket->id_status = $request->id_status;
                $ticket->activo = $request->activo;
                $ticket->save();
                    }
                
                return redirect()->to($url)->withStatus(__('Se cambio correctamente.'));
                    
          }
            else {
                $data = $model::findOrFail($id);
                $data->fill($request->all());
                $data->save();

                $url = $this->getUrlPrefix();
                return redirect()->to($url)->withStatus(__('Se registro correctamente.'));
            }
        }
    }

    public function getDestroy($id)
    {
       
        $names = $this->name;
        $model = $this->getModelInstance();
        $url = $this->getUrlPrefix();

        if($names=="Usuarios Empresas"){
            
            //return redirect()->to($url)->withStatus(__('Profile successfully updated.'));
            
            $ticket = User::find($id);
            $ticket->activo = 2;
            $ticket->save();
            
            $idempresa = Empresas::where('id_user', '=', $id)->value('id');
            
            $ticket = Empresas::find($idempresa);
            $ticket->activo = 2;
            $ticket->save();
            return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            
        }
        else if($names=="Usuarios"){
            
            $ticket = User::find($id);
            $ticket->active = 3;
            $ticket->save();
            
            return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            
        }
        else if($names=="Usuarios de Estaciones"){
            
            $ticket = User::find($id);
            $ticket->active = 2;
            $ticket->save();
            
            return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            
        }
        else if ($names == "Pagos") {
    
            $idautorizo = Pagos::where('id', '=', $id)->value('autorizado');
            if($idautorizo != 2){
                 $data = $model::destroy($id);
                 return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            }
            else{
               return redirect()->to($url)->withStatus(__('No se puede eliminar los que fueron ya autorizados.'));
            }


        }
        else if($names=="Estaciones"){
            
            $ticket = Station::find($id);
            $ticket->activo = 2;
            $ticket->save();
            
            return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            
        }
        else if($names=="Bombas"){
            
            $ticket = CatBombas::find($id);
            $ticket->activo = 2;
            $ticket->save();
            
            return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            
        }
        
        /* LEALTAD ************************************************/
        if($names == "Administradores de Estacion"){ //ADMIN ASIGNAR ADMIN DE ESTACION A UNA ESTACION PROPIA 
          $id_fat = Faturation::where('id', '=', $id)->value('id_users');  
          
           $model = $this->getModelInstance();
            $url = $this->getUrlPrefix();
             $data = $model::destroy($id);
               $datas = User::destroy($id_fat);             
             
             $url = $this->getUrlPrefix();
             return redirect()->to($url);
      
        }
        elseif($names == "Despachador"){ //ADMIN ASIGNAR ADMIN DE ESTACION A UNA ESTACION PROPIA 
          $id_fat = Dispatcher::where('id', '=', $id)->value('id_users');  
          
           $model = $this->getModelInstance();
            $url = $this->getUrlPrefix();
             $data = $model::destroy($id);
               $datas = User::destroy($id_fat);             
             
             $url = $this->getUrlPrefix();
             return redirect()->to($url);
      
        }
        elseif($names == "Administracion Premio"){
        
            $ticket = Awards::find($id);
            $ticket->activo = 3;
            $ticket->save();
            
            return redirect()->to($url)->withStatus(__('Se elimino correctamente.'));
            
        }   
        else{
            
        $data = $model::destroy($id);
        return redirect()->to($url);
        }
    }

    public function getVer($id)
    {   
        $url = $this->getUrlPrefix();
            $ins = ("*$url-ins");
            $mod = ("*$url-mod");
            $eli = ("*$url-eli");
            $ver = ("*$url-ver");
            $fac = ("*$url-fac");
            $pac = ("*$url-pac");
            $valmod = \Entrust::can($mod);
            $valeli = \Entrust::can($eli);
            $valver = \Entrust::can($ver);
            $valfac = \Entrust::can($fac);
            $valpac = \Entrust::can($pac);
        //dd($ver);
        $names = $this->name;
        $show = "";
       
        if($names=="Estaciones"){
            $empresa=\DB::table('empresas')->where('id','=',$id)->value('nombre');
            $estaciones=\DB::table('station')->where('id_empresa','=',$id)->get();
            $precios=CatPrecios::all();
            $totalEstaciones = 0;
            $totalTimbres = 0;
            $precioTimbre = 0.53;
            $nombreEstaciones = array();
            $timbres = array();
            foreach ($estaciones as $estacion) {
                $totalEstaciones++;
                $totalTimbres += $estacion->total_timbres;
                array_push($nombreEstaciones, $estacion->name);
                array_push($timbres, $estacion->total_timbres);
            }
             return view($this->tpl_prefix . 'listEstacionesVer', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac)->with('pac', $pac)->with('nombreEstaciones', $nombreEstaciones)->with('timbres', $timbres)->with('totalEstaciones', $totalEstaciones)->with('totalTimbres', $totalTimbres)->with('precioTimbre', $precioTimbre)->with('ids', $id)->with('empresa', $empresa)->with('precios', $precios); 
            }
        else if ($names == "Bombas") {
            $totalEstaciones = 0;
            $totalTimbres = 0;
            $precioTimbre = 0.53;
            $nombreEstaciones = array();
            $timbres = array();
            $precios=CatPrecios::all();
            $estacion=\DB::table('station')->where('id','=',$id)->value('name');
            $id_empresa=\DB::table('station')->where('id','=',$id)->value('id_empresa');
            $empresa=\DB::table('empresas')->where('id','=',$id_empresa)->value('nombre');
            $bombas=\DB::table('cat_bombas')->where('id_estacion','=',$id)->get();
            foreach($bombas as $bomba){
                $facturas=count(\DB::table('facturas')->where('id_bomba','=',$bomba->id)->get());
                $totalEstaciones++;
                array_push($nombreEstaciones, $bomba->nombre);
                array_push($timbres,$facturas);
            }
            return view($this->tpl_prefix . 'listBombasVer', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac)->with('nombreEstaciones', $nombreEstaciones)->with('timbres', $timbres)->with('totalEstaciones', $totalEstaciones)->with('ids', $id)->with('empresa', $empresa)->with('estacion', $estacion)->with('idsempresa',$id_empresa)->with('precios', $precios); 
    }
        else if($names=="Pagos"){
            $url = $this->getUrlPrefix();
            $ins = ("*$url-ins");
            $mod = ("*$url-mod");
            $eli = ("*$url-eli");
            $ver = ("*$url-ver");
            $valmod = \Entrust::can($mod);
            $valeli = \Entrust::can($eli);
            $valver = \Entrust::can($ver);
            $names = $this->name;
            $show = ""; 
            $estacion= Pagos::select("pagos.id", "pagos.pago", "pagos.num_timbres","pagos.autorizado", "pagos.archivo","station.name as estacion", "pagos.id_estacion", "pagos.id_empresa","empresas.nombre as empresa")
                    ->join('station', 'pagos.id_estacion', '=', 'station.id')
                    ->join('empresas', 'station.id_empresa', '=', 'empresas.id')
                    ->where('pagos.id','=',$id)
                    ->get();
            $facturaEmisor=\DB::table('factura_emisor')->where('id_estacion','=',$estacion[0]->id_estacion)->get();
            return view($this->tpl_prefix.'timbre.autorizado', array('catalog' => $this),compact('facturaEmisor','estacion'));
        }
        /*elseif($names=="Facturas"){
            $url = $this->getUrlPrefix();
            $ins = ("*$url-ins");
            $mod = ("*$url-mod");
            $eli = ("*$url-eli");
            $ver = ("*$url-ver");
            $valmod = \Entrust::can($mod);
            $valeli = \Entrust::can($eli);
            $valver = \Entrust::can($ver);
            $names = $this->name;
            $show = ""; 
            $factura=Facturas::find($id);
            return view($this->tpl_prefix.'timbre.facturas', array('catalog' => $this),compact('factura'));
        }*/
        else if ($names == "Facturas") {
            $totalEstaciones = 0;
            $totalTimbres = 0;
            $precioTimbre = 0.53;
            $nombreEstaciones = array();
            $timbres = array();
            $precios=CatPrecios::all();
            $idestacion=\DB::table('cat_bombas')->where('id','=',$id)->value('id_estacion');
            $nombomba=\DB::table('cat_bombas')->where('id','=',$id)->value('nombre');
            $estacion=\DB::table('station')->where('id','=',$idestacion)->value('name');
            $id_empresa=\DB::table('station')->where('id','=',$idestacion)->value('id_empresa');
            $id_estacion=$idestacion;
            $empresa=\DB::table('empresas')->where('id','=',$id_empresa)->value('nombre');
            
            $facturas=\DB::table('facturas')->where('id_estacion','=',$estacion)->get();
            
            return view($this->tpl_prefix . 'listFacturasVer', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac)->with('nombreEstaciones', $nombreEstaciones)->with('timbres', $timbres)->with('totalEstaciones', $totalEstaciones)->with('ids', $id)->with('empresa', $empresa)->with('estacion', $estacion)->with('idempresa', $id_empresa)->with('idsestacion',$id_estacion)->with('precios', $precios)->with('nombomba',$nombomba); 
    
        }
        else if($names=="Movimiento"){
            $empresa=\DB::table('users')->where('id','=',$id)->value('username');
         
             return view($this->tpl_prefix . 'listEstadoCuentaVer', array('catalog' => $this))->with('ins', $ins)->with('mod', $mod)->with('eli', $eli)->with('show', $show)->with('ver', $ver)->with('fac', $fac)->with('pac', $pac)->with('ids', $id)->with('empresa', $empresa); 
            }
        

        /* $model = $this->getModelInstance();
        $data = $model::findOrFail($id);
        $names = $this->name; */
        
    }
    
    public function postVer(Request $request, $id)
    {
        $names = $this->name;
        $url = $this->getUrlPrefix();
        $model = $this->getModelInstance();
        $v = Validator::make($request->all(), $this->getValidatorAdd());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            
            if($names=="Pagos"){
                $ids = \Auth::user()->id;
                $usuario = \Auth::user()->email;
              
                if($request->auto==2){
                    $pago=Pagos::find($id);
                    $estacion=Station::find($pago->id_estacion);
                    $empresa=Empresas::find($pago->id_empresa);
                    $pago->autorizado=$request->auto;
                    $pago->save();
                    
                    if($estacion->total_timbres == null){
                        $tottim = 0;
                    }
                    else {
                        $tottim = $estacion->total_timbres;
                    }
                    if($empresa->total_timbres == null){
                        $tottimemp = 0;
                    }
                    else {
                        $tottimemp = $empresa->total_timbres;
                    }
                    $tottim+=$request->timbres;
                    $tottimemp+=$request->timbres;
                     $updates = Station::where('id', '=', $pago->id_estacion)
                          ->update(['total_timbres' => $tottim]);
          
                     $update = Empresas::where('id', '=', $pago->id_empresa)
                          ->update(['total_timbres' => $tottimemp]);
                    
                     $emailfiscal = User::where('id', '=', $empresa->id_user)->value('email');
        
                     $nombre = "ricardo.resendiz@digitalsoft.mx";
                     $de = "ricardo.resendiz@digitalsoft.mx";
                     $asunto  = "Se autorizo el pago";
                     $para = [$emailfiscal, $nombre]; 
                     $titulo = "Se autorizo el pago";
                                
                     $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo);
                
                     Mail::send('mails.mails3', $data, function($message) use($de, $para){
                     $message->from('ricardo.resendiz@digitalsoft.mx', 'Se autorizo el pago');
                     $message->subject('Se autorizo el pago');
                     $message->to($para);
                     });
             
                }elseif($request->auto==3){
                    $pago=Pagos::find($id);
                    $pago->autorizado=$request->auto;
                    $pago->save();
                }
                return redirect()->to("pagoshistorial")->withStatus(__('Se actualizo el pago correctamente.'));
            }
        }
       
    }

    public function getFac($id){
        $url = $this->getUrlPrefix();
        $ins = ("*$url-ins");
        $mod = ("*$url-mod");
        $eli = ("*$url-eli");
        $ver = ("*$url-ver");
        $valmod = \Entrust::can($mod);
        $valeli = \Entrust::can($eli);
        $valver = \Entrust::can($ver);
        $names = $this->name;
        $show = "";
        $estacion=\DB::table('station')->where('id','=',$id)->get();
        $facturaEmisor=\DB::table('factura_emisor')->where('id_estacion','=',$estacion[0]->id)->get();
        $verificar=\DB::table('factura_emisor')->where('id_estacion','=',$estacion[0]->id)->value('id');
        $precios=CatPrecios::all();
        if($verificar == null){
        return view($this->tpl_prefix.'timbre.timbrescreate', array('catalog' => $this),compact('facturaEmisor','estacion','precios'));
        }
        else{
             return view($this->tpl_prefix.'timbre.timbres', array('catalog' => $this),compact('facturaEmisor','estacion','precios'));
        }
    }

    public function postFac(Request $request,$id){
        $url = $this->getUrlPrefix();
        $model = $this->getModelInstance();
        $v = Validator::make($request->all(), $this->getValidatorAdd());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            $ids = \Auth::user()->id;
            
            $estacion=Station::find($id);
            
            $usuario = Empresas::where('id', '=', $estacion->id_empresa)->value('id_user');
           
            if($request->file('fileKey') != null and $request->file('fileCer') != null){
               // Creando una carpeta en en storage
                \Storage::makeDirectory('csd/' . $id);
    
               $fileKey=$request->file('fileKey');
               $nombreKey = $fileKey->getClientOriginalName();
               \Storage::disk('empresas')->put('/'.$id.'/'.$nombreKey,  \File::get($fileKey));
    
               $fileCer=$request->file('fileCer');
               $nombreCer = $fileCer->getClientOriginalName();
               \Storage::disk('empresas')->put('/'.$id.'/'.$nombreCer,  \File::get($fileCer));
            }
            else{           
                return redirect()->to($url)->with('error', "Tiene que cargar los archivos CER y KEY");
                }
            
            if($request->file('consituacion') != null){
               $fileCon=$request->file('consituacion');
               $nombreCon = $fileCon->getClientOriginalName();
               \Storage::disk('empresas')->put('/'.$id.'/'.$nombreCon,  \File::get($fileCon));
            }
            else{           
                return redirect()->to($url)->with('error', "Tiene que cargar la constancia");
                }
            
            
            $facturaEmisor=\DB::table('factura_emisor')->where('id_estacion','=',$estacion->id)->get();
            $timbre= $request->timbres;
            $timb = CatPrecios::where('id', '=', $timbre)->value('num_ticket');
            $cost = CatPrecios::where('id', '=', $timbre)->value('costo');
            
            Pagos::create([
                'pago' => $cost,
                'num_timbres' => $timb,
                'archivo' => null,
                'autorizado' => 1,
                'id_estacion' => $id,
                'id_empresa' => $estacion->id_empresa,
            ]);
            
            $estacion->nombre=$request->nEstacion;
            $estacion->numero=$request->nNumero;
            $estacion->direccion=$request->nDireccion;
            $estacion->telefono=$request->ntelefono;
            $estacion->save();
            
            if(count($facturaEmisor)==0){
                FacturaEmisor::create([
                    'nombre' => $request->emNombre,
                    'rfc' =>$request->emRFC,
                    'regimenfiscal' => $request->emRegimenF,
                    'direccionfiscal' => $request->emDireccion,
                    'cp' => $request->nCp,
                    'emailfiscal' => $request->emEmail,
                    'archivocer' => $nombreCer,
                    'archivokey' => $nombreKey,
                    'consituacion' => $nombreCon,
                    'avredescripcion1' => $request->avredescripcion1,
                    'descripcion1' => $request->descripcion1,
                    'avredescripcion2' => $request->avredescripcion2,
                    'descripcion2' => $request->descripcion2,
                    'avredescripcion3' => $request->avredescripcion3,
                    'descripcion3' => $request->descripcion3,
                    'id_user' => $usuario,
                    'id_estacion' => $estacion->id,
                    'id_empresa' => $estacion->id_empresa,
                ]);
            }else{
                $facturaEmisor=FacturaEmisor::find($facturaEmisor[0]->id);
                $facturaEmisor->nombre=$request->emNombre;
                $facturaEmisor->rfc=$request->emRFC;
                $facturaEmisor->regimenfiscal=$request->emRegimenF;
                $facturaEmisor->direccionfiscal=$request->emDireccion;
                $facturaEmisor->cp=$request->nCp;
                $facturaEmisor->emailfiscal=$request->emEmail;
                $facturaEmisor->archivocer=$nombreCer;
                $facturaEmisor->archivokey=$nombreKey;
                $facturaEmisor->consituacion=$nombreCon;
                $facturaEmisor->avredescripcion1=$request->avredescripcion1;
                $facturaEmisor->descripcion1=$request->descripcion1;
                $facturaEmisor->avredescripcion2=$request->avredescripcion2;
                $facturaEmisor->descripcion2=$request->descripcion2;
                $facturaEmisor->avredescripcion3=$request->avredescripcion3;
                $facturaEmisor->descripcion3=$request->descripcion3;
                $facturaEmisor->save();
                // Creando una carpeta en en storage
                \Storage::makeDirectory('csd/' . $id);
                
                \Storage::disk('empresas')->put('/'.$id.'/'.$nombreKey,  \File::get($fileKey));
                \Storage::disk('empresas')->put('/'.$id.'/'.$nombreCer,  \File::get($fileCer));
            }
            
             $nombre = "ricardo.resendiz@digitalsoft.mx";
             $de = "ricardo.resendiz@digitalsoft.mx";
             $asunto  = "Pago Generado";
             $para = [$emailfiscal, $nombre]; 
             $titulo = "Se genero nuevo pago";
                        
             $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo, 'precio' => $cost, 'timbres' => $timb);
        
             Mail::send('mails.mails', $data, function($message) use($de, $para){
             $message->from('ricardo.resendiz@digitalsoft.mx', 'Pago Generado');
             $message->subject('Pago Generado');
             $message->to($para);
             });
                       
            return redirect()->to($url)->withStatus(__('Se agrego el pago correctemente, asigne sus bombas a la estacion en el caso de no tener.'));
        }
    }   

    public function postPac(Request $request,$id){
        $url = $this->getUrlPrefix();
        $model = $this->getModelInstance();
        $v = Validator::make($request->all(), $this->getValidatorAdd());
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            $ids = \Auth::user()->id;
            $estacion=Station::find($id);
            $usuario = Empresas::where('id', '=', $estacion->id_empresa)->value('id_user');
            $emailfiscal = User::where('id', '=', $usuario)->value('email');
        
            $timbre= $request->timbres;
            $timb = CatPrecios::where('id', '=', $timbre)->value('num_ticket');
            $cost = CatPrecios::where('id', '=', $timbre)->value('costo');
            
            Pagos::create([
                'pago' => $cost,
                'num_timbres' => $timb,
                'archivo' => null,
                'autorizado' => 1,
                'id_estacion' => $id,
                'id_empresa' => $estacion->id_empresa,
            ]);
            
             $nombre = "ricardo.resendiz@digitalsoft.mx";
             $de = "ricardo.resendiz@digitalsoft.mx";
             $asunto  = "Pago Generado";
             $para = [$emailfiscal, $nombre]; 
             $titulo = "Se genero nuevo pago";
                        
             $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo, 'precio' => $cost, 'timbres' => $timb);
        
             Mail::send('mails.mails', $data, function($message) use($de, $para){
             $message->from('ricardo.resendiz@digitalsoft.mx', 'Pago Generado');
             $message->subject('Pago Generado');
             $message->to($para);
             });
                       
            return redirect()->to('pagos')->withStatus(__('Se agrego el pago correctemente, asigne sus bombas a la estacion en el caso de no tener.'));
        }
    }   

     public function getDownload($file)
     {
       $path = storage_path('app/pagos/').$file;
    
       return response()->download($path);
     }

    public function getDownloadcer($file)
     {
      $verificar = Station::where('id', '=', $file)->value('id_empresa');
      if($verificar == null ){    
      $estacion = Pagos::where('id', '=', $file)->value('id_estacion');
      $cer= FacturaEmisor::where('id_estacion', '=', $estacion)->value('archivocer');
      $path = storage_path("app/csd/$estacion/$cer");
       }
       else{
      $cer= FacturaEmisor::where('id_estacion', '=', $file)->value('archivocer');
      $path = storage_path("app/csd/$file/$cer");
       }
       return response()->download($path);
     }
     
     public function getDownloadkey($file)
     {
      $verificar = Station::where('id', '=', $file)->value('id_empresa');
      if($verificar == null ){    
      $estacion = Pagos::where('id', '=', $file)->value('id_estacion');
      $key= FacturaEmisor::where('id_estacion', '=', $estacion)->value('archivokey');
      $path = storage_path("app/csd/$estacion/$key");
      }
      else{
      $key= FacturaEmisor::where('id_estacion', '=', $file)->value('archivokey');
      $path = storage_path("app/csd/$file/$key");
      }
       return response()->download($path);
     }
     
      public function getDownloadConsituacion($file)
     {
      $verificar = Station::where('id', '=', $file)->value('id_empresa');
      if($verificar == null ){    
      $estacion = Pagos::where('id', '=', $file)->value('id_estacion');
      $key= FacturaEmisor::where('id_estacion', '=', $estacion)->value('consituacion');
      $path = storage_path("app/csd/$estacion/$key");
      }
      else{
      $key= FacturaEmisor::where('id_estacion', '=', $file)->value('consituacion');
      $path = storage_path("app/csd/$file/$key");
      }
       return response()->download($path);
     }
 
      public function getDownloadPDF($file)
     {
      $key= Facturas::where('archivopdf', '=', $file)->value('folio');
      $path = storage_path("app/factura/$key/$file");
      return response()->download($path);
     }
 
 
    //SUBIR INFO AL PAC--------------------------------------------------------------------------------------
    
    public static function jsonEmisionTimbradoV4($json, $isb64 = false){
 
    //$token = "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRqWEhjMi9qMGlXcDBLR1F4ZVFWM1RhSjI2Z1o3ZXlLL2ROcXljdGswODZ6OWZFTnMwWlJseDhiT0E4dDluZ29mdEhtSkZ5Z3UxU2RjN1pmVWhCalQxY2tXaE9oWFFHTVpETnYxMTNHcktOdHMzUEFYZ0k3em9uaERmZzhJTXZWN2RQbjVOUmNGeUgwRktSQmt1c0FGa0hyajYwR1VLd1gzdDc1VHltajFMYkNYdjNiNlo4aFZwcncrM1FZRkh6LzJpSFhlbUFnMGpMbzNJUlF2NFFLbTQ0L1R1MWdaVTFhLzlxSUwvcE5kcTJZTnJOblFYalk3b0RReTRBYU1NQ1o5NjZjeDl3QlVOR0dFRzljV2ZYUjA5cEZyMjEvSWRaV2xEQnNMUnBJb2RvTjI2aDRJbGhVWVFWRkJ3SGJ4bGJUU3VVckxEK3VmZ3U3TFdnWEtldHc3Y3VVWlZ6RFdaVzNVTXNuMElleTdLTEp3OVJmY3VPL0lxSTlXRkVHUmdDdGltaHlGRzVXc3Z5eE5RTXhhd1BzOVlRPT0.twkhIZjT_rFn2n8PwYvot5qZ8boxHEQ0NAey0rsl8So";
    $token = "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRkZEFZcDFhY3lhUC95OUZOaU1xZGttU2ttV0RUQjZyZVIwNDRzUTRTVVlGckRJREdyclBhbWk0QmZyblRkaUtIVFQ0dGRKMExqZFpTS0wydzdNcEg4QmVrWEQ4L1RMZkxkUU5WV1duMTJTOTd6OWY3U0ZVVU9YNzBua2xCSjE0N3o1dTVEbGRqU280cXVjWFgvOGV0NjQwbGFsMm5Xak5NckJLRHdreXNGUzVhbllxSlpSdURjWjA1TEdWSW1seW9INXFMVVY4SEtvYlgrT0N3N0pjaFpuOExLR0REY0phNG42TG83RDJvL3ZVRzk2ZmRISXVUQUhVamlOVERzK09ucmtEWmxyYitpaHVyRlhqVUd0dVF5dThiTklyL3JFdFVPV2VSZ2gyUWFxU2NoczdvRlNIL3JBK3IweUVoNXVJdC9kVmdWbzVpUm9xeC96RmYwYWZVY0UrVWllc0M4WmNKZUdWaWZnaG4rbDVDRFVyMkgwZFpJdU5QL2QrSlA4Qlc.HTktXkSaHo82KUTDpF2gzt5N4fgF8xK1zJ5DDC_xANI";
    $url = "https://api.test.sw.com.mx/management/api/users";
    
    return self::sendReq($url, $token, $json);
    
    }

     public static function sendReq($url, $token, $json){
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        "Authorization: bearer ".$token,
        "Content-Type: application/json"
      ),
    ));

    if(isset($proxy)){
        curl_setopt($curl , CURLOPT_PROXY, $proxy);
       }
       $response = curl_exec($curl);
       $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
       $err = curl_error($curl );
       curl_close($curl);

       if ($err) {
           throw new Exception("cURL Error #:" . $err);
       } else{
           if($httpcode < 500)
               return json_decode($response);
           else
               throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
       }
    }
    
    function CallAPI($Data, $JsonBody){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $Data['url'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS =>$JsonBody,
      CURLOPT_HTTPHEADER => array(
        "Authorization: ".$Data['token'],
        "Content-Type: application/json"
      ),
    ));
    
    $response = json_decode(curl_exec($curl));
    
    if($response === false) {
        var_dump('Curl error: ' . curl_error($curl));
    } else if($response->status == 'error') {
        print($response->message . PHP_EOL .
              $response->status);
    }else{
        print($response->data . PHP_EOL .
              $response->status);
    };
    
    curl_close($curl);
    
      return $response;
    }
    

    
    //Select 2 ----------------------------------------------------------------------------------------------

    public function getAjaxlistaGraphics()
    {
        $almacen = [
            ['id' => '1', 'name' => 'Numero de registros'],
            ['id' => '2', 'name' => 'Sexo'],
            ['id' => '3', 'name' => 'no se']
        ];
        return response()->json(['data' => $almacen]);
    }
    public function getAjaxlistaSex()
    {
        $almacen = [
            ['id' => 'H', 'name' => 'Hombre'],
            ['id' => 'M', 'name' => 'Mujer']
        ];
        return response()->json(['data' => $almacen]);
    }
    public function getAjaxlistaActivo()
    {
        $almacen = [
            ['id' => '1', 'name' => 'Si'],
            ['id' => '0', 'name' => 'No']
        ];
        return response()->json(['data' => $almacen]);
    }
    public function getAjaxlistaDays_Deliver()
    {
        $almacen = [
            ['id' => '1', 'days_deliver' => '1'], ['id' => '2', 'days_deliver' => '2'], ['id' => '3', 'days_deliver' => '3'], ['id' => '4', 'days_deliver' => '4'], ['id' => '5', 'days_deliver' => '5'], ['id' => '6', 'days_deliver' => '6'], ['id' => '7', 'days_deliver' => '7'], ['id' => '8', 'days_deliver' => '8'], ['id' => '9', 'days_deliver' => '9'], ['id' => '10', 'days_deliver' => '10'],
            ['id' => '11', 'days_deliver' => '11'], ['id' => '12', 'days_deliver' => '12'], ['id' => '13', 'days_deliver' => '13'], ['id' => '14', 'days_deliver' => '14'], ['id' => '15', 'days_deliver' => '15'], ['id' => '16', 'days_deliver' => '16'], ['id' => '17', 'days_deliver' => '17'], ['id' => '18', 'days_deliver' => '18'], ['id' => '19', 'days_deliver' => '19'], ['id' => '20', 'days_deliver' => '20'],
            ['id' => '21', 'days_deliver' => '21'], ['id' => '22', 'days_deliver' => '22'], ['id' => '23', 'days_deliver' => '23'], ['id' => '24', 'days_deliver' => '24'], ['id' => '25', 'days_deliver' => '25'], ['id' => '26', 'days_deliver' => '26'], ['id' => '27', 'days_deliver' => '27'], ['id' => '28', 'days_deliver' => '28'], ['id' => '29', 'days_deliver' => '29'], ['id' => '30', 'days_deliver' => '30'],
        ];
        return response()->json(['data' => $almacen]);
    }
    public function getAjaxlistaUser()
    {
           $ids = \Auth::user()->id;
          $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
          if ($rol == 1) { //verifica si es un usuario
            $almacen = User::select("users.*", "role_user.role_id", \DB::raw("CONCAT(users.name,' ',users.first_surname,' ',users.second_surname, '    ',  users.username) as nombre"))
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', '=', 2)
            ->get();
          }
          else{
            $almacen = User::select("users.*", "role_user.role_id", \DB::raw("CONCAT(users.name,' ',users.first_surname,' ',users.second_surname, '    ',  users.username) as nombre"))
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', '=', 2)
            ->where('users.id', '=', $ids)
            ->get();
      }
    
    
        return response()->json(['data' => $almacen]);
    }
     public function getAjaxlistaPrecios()
    {
        $almacen = CatPrecios::select("cat_precios.*",  \DB::raw("CONCAT(cat_precios.num_ticket,' ',cat_precios.costo,') as nombre"))
            ->get();

        return response()->json(['data' => $almacen]);
    }
    public function getAjaxlistaPago()
    {
        $almacen = Pagos::select('id', 'name')
            ->get();

        return response()->json(['data' => $almacen]);
    }
    public function getAjaxlistaEmpresa()
    {

        $ids = \Auth::user()->id;
          $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
          if ($rol == 1) { //verifica si es un usuario
            $almacen = Empresas::select("id", "nombre")
            ->get();
          }
          else{
            $almacen = Empresas::select("id", "nombre")
                       ->where('id_user', '=', $ids)
                       ->get();
          }
        return response()->json(['data' => $almacen]);
    }
     public function getAjaxlistaEstacion()
    {
          $ids = \Auth::user()->id;
          $rol = Role_User::where('user_id', '=', $ids)->value('role_id');
          if ($rol == 1) { //verifica si es un usuario
             $almacen = Station::select("id", "name")
            ->get();
          }
          else{
          $emp = Empresas::where('id_user', '=', $ids)->value('id');
             $almacen = Station::select("id", "name")
                ->where('id_empresa', '=', $emp)
                       ->get();
          }
     
        return response()->json(['data' => $almacen]);
    }
     public function getAjaxlistaBomba()
    {

        $almacen = CatBombas::select("id", "nombre")
            ->get();
        return response()->json(['data' => $almacen]);
    }
     public function getAjaxlistaNotification() 
    {

      $id = \Auth::user()->id;
      $rol = Role_User::where('user_id', '=', $id)->value('role_id');
             $almacen = Pagos::where('autorizado', '=', 1)->count();
    
      return $almacen;
     }
    
    /** LEALTAD ***********************************************************/

    public function getAjaxlistaEdad() {
      $almacen = [
                 ['id' => '1940', 'name' => '1940 a 1949'],
                 ['id' => '1950', 'name' => '1950 a 1959'],
                 ['id' => '1960', 'name' => '1960 a 1969'],
                 ['id' => '1970', 'name' => '1970 a 1979'],
                 ['id' => '1980', 'name' => '1980 a 1989'],
                 ['id' => '1990', 'name' => '1990 a 1999'],
                 ['id' => '2000', 'name' => '2000 a 2009']
                ];           
      return response()->json(['data' => $almacen]);
    }
    
     public function getAjaxlistaActive() {
      $almacen = [
                 ['id' => '1', 'name_active' => 'Activo'],
                 ['id' => ' ', 'name_active' => 'Desactivar']
                ];           
   
      //$almacen = \DB::select("SELECT id, name_active FROM cat_active");
      return response()->json(['data' => $almacen]);
    }

     public function getAjaxlistaType() {
      $almacen = \DB::select("SELECT id, name_type FROM cat_type");
      return response()->json(['data' => $almacen]);
    }
    
     public function getAjaxlistaComes() {
      $almacen = \DB::select("SELECT id, db_name FROM cat_server");
      return response()->json(['data' => $almacen]);
    }
    
     public function getAjaxlistaStatus() {
      $almacen = \DB::select("SELECT id, name_status FROM cat_status");
      return response()->json(['data' => $almacen]);
    }
     
     public function getAjaxlistaStation() {
      $almacen = \DB::select("SELECT id, concat(name,' ',address) AS estacion FROM station");
      return response()->json(['data' => $almacen]);
    }   
    
     public function getAjaxlistaUsersFaturation() {
                $almacen = User::select('users.id', 'users.username')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->where('role_user.role_id', '=', 3)
                ->get();      
      return response()->json(['data' => $almacen]);
    }
     
     public function getAjaxlistaUsers() {
                $almacen = User::select('users.id', 'users.username')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->where('role_user.role_id', '=', 5)
                ->get();      
      return response()->json(['data' => $almacen]);
    }
     
     public function getAjaxlistaState() {
      $almacen = \DB::select("SELECT id, name_state FROM cat_state");
      return response()->json(['data' => $almacen]);
    }
     
     public function getAjaxlistaMemberships() {
        $id_us = \Auth::user()->id;
           $almacen = Memberships::select('id', 'number_usuario')
                ->where('id_users', '=', $id_us)
                ->get(); 
       return response()->json(['data' => $almacen]);
    }
     
     public function getAjaxlistaCertificado($id) {
         date_default_timezone_set("America/Mexico_City");
         $fecha = date('Y-m-d h:i') ; // Fecha
                    
         $fol = Exchange::where('id', '=', $id)->value('folio');                                   
         $mes = date('m') ; $dia = date('d') ; // dia
         $certificado=($mes.$fol.$dia);
                 
          $update = Exchange::where('id', '=', $id)
                          ->update(['conta' => $certificado]);
          $updat = Exchange::where('id', '=', $id)
                          ->update(['todate_cerficado' => $fecha]);
          return redirect()->to("entregaexchange");                               
    }
    
    # Template 
    function get_tpl_prefix()
    {
        return strtolower($this->tpl_prefix + get_class($this));
    }

    function get_tpl_oper($oStr)
    {
        return strtolower($this->get_tpl_prefix() + "_" + oStr + "->html");
    }

    function get_tpl_list()
    {
        return $this->get_tpl_oper('list');
    }

    function get_tpl_list_data()
    {
        if ($this->tpl_list_data == null) {
            return 'core/cat_functionault/' + 'list_data' + "->html";
        } else {
            return $this->get_tpl_oper($this->tpl_list_data);
        }
    }

    function get_tpl_add()
    {
        return $this->get_tpl_oper('add');
    }

    function get_tpl_ver()
    {
        return $this->get_tpl_oper('ver');
    }

    function get_tpl_edit()
    {
        return $this->get_tpl_oper('edit');
    }

    function get_tpl_view()
    {
        return $this->get_tpl_oper('view');
    }

    # Querys 
    function get_list_query()
    {
        if ($this->model != null) {
            return $this->model->objects->all();
        } else {
            return [];
        }
    }

    # Verbose name 
    function get_nombre_plural()
    {
        return $this->model->_meta->verbose_name_plural;
    }

    function get_nombre()
    {
        return $this->model->_meta->verbose_name;
    }

    ### URLS list, add, edit, delete
    function get_list_url()
    {
        return reverse($this->url_prefix . "_list");
    }

    function get_search_url()
    {
        return reverse($this->url_prefix . "_search");
    }

    function get_add_url()
    {
        return reverse($this->url_prefix . "_add");
    }

    function get_ver_url()
    {
        return reverse($this->url_prefix . "_ver");
    }

    function get_edit_url_name()
    {
        return $this->url_prefix . "_edit";
    }

    function get_delete_url_name()
    {
        return $this->url_prefix . "_delete";
    }

    function get_edit_url($id)
    {
        return reverse($this->get_edit_url_name(), $kwargs = array('id' => id));
    }

    function get_delete_url($id)
    {
        return reverse($this->get_delete_url_name(), $kwargs = array('id' => id));
    }


    public function getJsUrl()
    {
        return strtolower('assets/js/' . $this->getName() . 'js');
    }

    function get_form_id()
    {
        if ($this->form_id == null) {
            $this->form_id = "form_" +  str(random . randint(1, 999));
        }
        return $this->form_id;
    }
}
