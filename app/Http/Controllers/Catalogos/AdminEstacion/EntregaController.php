<?php namespace App\Http\Controllers\Catalogos\AdminEstacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class EntregaController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['identificador'=>'Folio','number_usuario'=>'Membresía','conta'=>'Número','premio'=>'Premio','dtip'=>'Tipo', 'name'=>'Lugar','punto'=>'Puntos','estado_uno'=>'Fecha de elaboración','id'=>'Acciones'];
        $this->name = 'Entrega';
        $this->name_plural = 'fa fa-newspaper-o';
        $this->form = 'App\Core\Forms\Lealtad\EntregaForm';
        $this->model = 'App\Models\Lealtad\Exchange';
        $this->url_prefix = 'entregaexchange';
        $validation_add = [
       //     'folio'=>'required|max:25',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}