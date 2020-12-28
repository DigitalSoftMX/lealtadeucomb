<?php namespace App\Http\Controllers\Catalogos\Usuarios;

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
        $this->field_list = ['number_usuario'=>'Memebresía','points'=>'Puntos','value'=>'Valor','todate'=>'Fecha'];
        $this->name = 'Mi Historial';
        $this->name_plural = 'fa fa-newspaper-o';
        $this->form = 'App\Core\Forms\Admin\HistoryForm';
        $this->model = 'App\Models\Catalogos\History';
        $this->url_prefix = 'usuariohistory';
        $validation_add = [
            'folio'=>'required|max:25',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}