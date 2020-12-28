<?php namespace App\Http\Controllers\Catalogos\Lealtad;

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
        $this->field_list = ['name'=>'Nombre','points'=>'Puntos','value'=>'Valor','name_status'=>'Status','total_voucher'=>'Total de vales','id'=>'Acciones'];
        $this->name = 'Administracion Vale';
        $this->name_plural = 'fa fa-ticket';
        $this->form = 'App\Core\Forms\Lealtad\VoucherAdminForm';
        $this->model = 'App\Models\Lealtad\Voucher';
        $this->url_prefix = 'adminvoucher';
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