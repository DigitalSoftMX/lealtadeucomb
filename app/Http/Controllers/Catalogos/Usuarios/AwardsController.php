<?php namespace App\Http\Controllers\Catalogos\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class AwardsController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['name'=>'Nombre','points'=>'Puntos','value'=>'Valor','days_deliver'=>'Dias para entregar','name_status'=>'Estatus','validity'=>'Vigencia','id'=>'Acciones'];
        $this->name = 'Premio';
        $this->name_plural = 'fa fa-ticket';
        $this->form = 'App\Core\Forms\Admin\AwardsForm';
        $this->model = 'App\Models\Catalogos\Awards';
        $this->url_prefix = 'awards';
        $validation_add = [
       /*     'name'=>'required|max:25',
            'points'=>'required|numeric',
            'value'=>'required|numeric',
            'days_deliver'=>'required',
        */];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}