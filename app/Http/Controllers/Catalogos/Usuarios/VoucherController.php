<?php namespace App\Http\Controllers\Catalogos\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class VoucherController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['name'=>'Nombre','points'=>'Puntos', 'name'=>'Estación', 'total_voucher'=>'Total de vales','id'=>'Acciones'];
        $this->name = 'Vale';
        $this->name_plural = 'fa fa-ticket';
        $this->form = 'App\Core\Forms\Admin\VoucherForm';
        $this->model = 'App\Models\Catalogos\Voucher';
        $this->url_prefix = 'voucher';
        $validation_add = [
            //'name'=>'required|max:25',
            //'points'=>'required|numeric',
            //'value'=>'required|numeric',
           // 'days_deliver'=>'required',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}