<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class HistoryController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['folio'=>'Folio','numero'=>'Número de Vale', 'username'=>'Estacion','number_usuario'=>'Memebresía','name_exchange'=>'Tipo','points'=>'Puntos','value'=>'Valor','fecha'=>'Fecha'];
        $this->name = 'Historial';
        $this->name_plural = 'fa fa-newspaper-o';
        $this->form = 'App\Core\Forms\Lealtad\HistoryForm';
        $this->model = 'App\Models\Lealtad\History';
        $this->url_prefix = 'history';
        $validation_add = [
            'folio'=>'required|max:25',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}