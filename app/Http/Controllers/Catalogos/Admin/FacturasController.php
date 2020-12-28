<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class FacturasController extends Controller
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
        $this->field_list = ['serie' => 'Serie', 'fecha' => 'Fecha', 'descripcion' => 'Descripcion', 'archivopdf' => 'PDF', 'emis' => 'Emisor', 'recept' => 'Receptor'];
        $this->name = 'Facturas';
        $this->name_plural = 'Facturas';
        $this->form = 'App\Core\Forms\Admin\FacturasForm';
        $this->model = 'App\Models\Catalogos\Facturas';
        $this->url_prefix = 'facturas';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}
