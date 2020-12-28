<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class PagosHistorialController extends Controller
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
        $this->field_list = ['pago' => 'Pago', 'num_timbres' => 'Timbres', 'archivo' => 'Archivo', 'autorizado' => 'Estado', 'estacion' => 'Estacion', 'empresa' => 'Empresa'];
        $this->name = 'Pagos Historial';
        $this->name_plural = 'Catalogo Pagos';
        $this->form = 'App\Core\Forms\Admin\PagosForm';
        $this->model = 'App\Models\Catalogos\Pagos';
        $this->url_prefix = 'pagoshistorial';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}