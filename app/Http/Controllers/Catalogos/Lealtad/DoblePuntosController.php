<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class DoblePuntosController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['active'=>'Puntos dobles','id'=>'Acciones'];
        $this->name = 'Puntos Dobles';
        $this->name_plural = 'fa fa-child';
        $this->form = 'App\Core\Forms\Lealtad\DoblePuntosForm';
        $this->model = 'App\Models\Lealtad\DoblePuntos';
        $this->url_prefix = 'doblepuntos';
        $validation_add = [
           ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}