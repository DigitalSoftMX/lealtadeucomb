<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class CatFacturasController extends Controller
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
        $this->field_list = ['nombre' => 'Nombre', 'rfc' => 'RFC', 'numero' => 'Número', 'id' => 'Acciones'];
        $this->name = 'Catalogo Facturas';
        $this->name_plural = 'Catálogo Facturas';
        $this->form = 'App\Core\Forms\Admin\CatFacturasForm';
        $this->model = 'App\Models\Catalogos\CatFacturas';
        $this->url_prefix = 'catfacturas';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}
