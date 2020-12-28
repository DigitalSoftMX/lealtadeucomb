<?php namespace App\Http\Controllers\Catalogos\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class ExchangeController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['identificador'=>'Folio','conta'=>'Número de vale','name'=>'Lugar','punto'=>'Puntos','value'=>'Valor','estado'=>'Estatus','estado_uno'=>'Fecha'];
        $this->name = 'Mi Vale';
        $this->name_plural = 'fa fa-newspaper-o';
        $this->form = 'App\Core\Forms\Admin\ExchangeForm';
        $this->model = 'App\Models\Catalogos\Exchange';
        $this->url_prefix = 'usuarioexchange';
        $validation_add = [
       //     'folio'=>'required|max:25',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}