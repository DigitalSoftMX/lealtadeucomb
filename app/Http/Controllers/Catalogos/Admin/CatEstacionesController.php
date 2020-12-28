<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class CatEstacionesController extends Controller
{
    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth');
        //$this->field_list = ['number_station' => 'No. de estacion', 'name' => 'Nombre', 'rfc' => 'RFC', 'emailfiscal' => 'Email', 'total_timbres' => 'Timbres', 'total_facturas' => 'Facturas', 'id' => 'Acciones'];
        $this->field_list = ['number_station' => 'No. de estación', 'name' => 'Nombre', 'id' => 'Acciones'];
        $this->name = 'Estaciones';
        $this->name_plural = 'Catalogo Estaciones';
        $this->form = 'App\Core\Forms\Admin\CatEstacionesForm';
        $this->model = 'App\Models\Lealtad\Station';
        $this->url_prefix = 'catestaciones';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}
