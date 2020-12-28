<?php namespace App\Http\Controllers\Catalogos\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class MembershipsController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['number_usuario'=>'QR','todate'=>'Fecha','totals'=>'Puntos', 'visits'=>'Visitas'];
        $this->name = 'Mi Membresia';
        $this->name_plural = 'fa fa-folder';
        $this->form = 'App\Core\Forms\Admin\MembershipsForm';
        $this->model = 'App\Models\Catalogos\Memberships';
        $this->url_prefix = 'usermemberships';
        $validation_add = [
            'qr_membership'=>'required',
            'active'=>'required|max:2',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}