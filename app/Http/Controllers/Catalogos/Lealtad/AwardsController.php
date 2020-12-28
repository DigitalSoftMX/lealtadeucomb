<?php namespace App\Http\Controllers\Catalogos\Lealtad;

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
        $this->field_list = ['name'=>'Nombre','img'=>'Imagen','points'=>'Puntos','value'=>'Valor','name_status'=>'Estatus','active'=>'Active','id'=>'Acciones'];
        $this->name = 'Administracion Premio';
        $this->name_plural = 'fa fa-ticket';
        $this->form = 'App\Core\Forms\Lealtad\AwardsAdminForm';
        $this->model = 'App\Models\Lealtad\Awards';
        $this->url_prefix = 'adminawards';
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