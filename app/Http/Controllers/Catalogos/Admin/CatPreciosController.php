<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class CatPreciosController extends Controller
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
        $this->field_list = ['num_ticket' => 'Número de timbres', 'costo' => 'Precio al Cliente', 'costo_timbre' => 'Costo del Timbre al Cliente', 'costo_admin' => 'Precio Administrador', 'costo_timbre_admin' => 'Costo del Timbre al Administrador', 'ganancia'=>'Ganancia', 'id' => 'Acciones'];
        $this->name = 'Precios';
        $this->name_plural = 'Catálogo Precios';
        $this->form = 'App\Core\Forms\Admin\CatPreciosForm';
        $this->model = 'App\Models\Catalogos\CatPrecios';
        $this->url_prefix = 'catprecios';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}
