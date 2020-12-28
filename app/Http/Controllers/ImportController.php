<?php
 
namespace App\Http\Controllers;
 
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Availability;
use App\Models\Catalogos\Brands;
use App\Models\Catalogos\Carrito_compra;
use App\Models\Catalogos\Orden_compra;
use App\Models\Catalogos\Entidad;
use App\Models\Catalogos\Facturation;
use App\Models\Catalogos\Historial_cotizacion;
use App\Models\Catalogos\Ilumination;
use App\Models\Catalogos\Material;
use App\Models\Catalogos\Medio;
use App\Models\Catalogos\Permission;
use App\Models\Catalogos\Permission_Role;
use App\Models\Catalogos\Providers;
use App\Models\Catalogos\Referencias;
use App\Models\Catalogos\Role;
use App\Models\Catalogos\Space;
use App\Models\Catalogos\Spectaculars;
use App\Models\Catalogos\Municipio;
use App\Models\Catalogos\Traffic;
use App\Models\Catalogos\Type;
use App\Models\Catalogos\Type_provider;
use App\Models\Catalogos\Ubicacion;
use App\Models\Catalogos\View;

class ImportController extends Controller
{
    public function index(){
        return view("import");
    }
    public function import()
    {
    	Excel::load('bd/cartelera.csv', function($reader) {
                     
     foreach ($reader->get() as $book) {

        //dd($book->all());
       
        $user = Spectaculars::where('clave', '=', $book->clave)->value('id');  
         if($user == ""){
             $datos = Spectaculars::create([
                'clave' => $book->clave,
                'base' => $book->base,
                'altura' => $book->altura,
                'met_cuad' => $book->met_cuad,
                'id_user' => $book->proveedor,
                'id_medio' => $book->medio,
                'id_ubication' => $book->ubicacion,
                'id_availability' => $book->disponibilidad,
                'id_view' => $book->vista,
                'id_ilumination' => $book->iluminacion,
                'id_traffic' => $book->trafico,
               ]);

         }
         else{
            echo "duplicado";
         }       
            
}
 });
  
    }
}