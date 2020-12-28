<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class Change_MembershipsController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['qr_membership'=>'QR','name'=>'Nombre','first_surname'=>'Apellido Paterno','second_surname'=>'Apellido Materno','qr_membership_old'=>'QR Anterior','todate'=>'Fecha'];
        $this->name = 'Cambio de Membresia';
        $this->name_plural = 'fa fa-folder-open';
        $this->form = 'App\Core\Forms\Lealtad\MembershipsForm';
        $this->model = 'App\Models\Lealtad\Change_Memberships';
        $this->url_prefix = 'changememberships';
        $validation_add = [
            'qr_membership'=>'required',
            'active'=>'required|max:2',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}