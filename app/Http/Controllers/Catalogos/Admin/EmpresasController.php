<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class EmpresasController extends Controller
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
        //$this->field_list = ['nombre' => 'Nombre', 'direccion' => 'Dirección', 'telefono' => 'Teléfono', 'imglogo' => 'Logo', 'total_facturas' => 'Facturas', 'total_timbres' => 'Timbres', 'activo' => 'Activo', 'id' => 'Acciones'];
        $this->field_list = ['nombre' => 'Nombre', 'direccion' => 'Dirección', 'telefono' => 'Teléfono', 'id' => 'Acciones'];
        $this->name = 'Empresas';
        $this->name_plural = 'Empresas';
        $this->form = 'App\Core\Forms\Admin\EmpresaForm';
        $this->model = 'App\Models\Catalogos\Empresas';
        $this->url_prefix = 'empresas';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}
