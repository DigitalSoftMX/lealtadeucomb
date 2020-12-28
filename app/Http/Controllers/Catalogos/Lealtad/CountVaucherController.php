<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class CountVaucherController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['name'=>'Nombre','min'=>'Número mínimo','max'=>'Número máximo'];
        $this->name = 'Agregar Vales';
        $this->name_plural = 'fa fa-ticket';
        $this->form = 'App\Core\Forms\Lealtad\CountVaucherForm';
        $this->model = 'App\Models\Lealtad\Count_Voucher';
        $this->url_prefix = 'countvouchers';
        $validation_add = [
           /* 'name'=>'required|max:25',
            'address'=>'required|max:225',
            'id_type'=>'required|max:25',
            'id_comes'=>'required|max:25',*/
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}